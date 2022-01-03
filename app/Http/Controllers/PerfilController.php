<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth', ['except' => ['show']]); // solo los usuarios registrados pueden acceder a estas funciones
		// https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/learn/lecture/20324719
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Perfil  $perfil
	 * @return \Illuminate\Http\Response
	 */
	public function show(Perfil $perfil)
	{
		// dd($perfil);

		// obtener las primeras 5 recetas del usuario
		$recetas = $perfil->user->recipes()->paginate(5);
		// dd($recetas);

		// mostrar los datos de la paginacion en formato json
		// https://laravel.com/docs/8.x/pagination#json-pagination
		$recetas->withPath('/perfil/' . $perfil->id);


		// return view('perfiles.show', compact('perfil'));
		return view('perfiles.show', ['perfil' => $perfil, 'recetas' => $recetas]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Perfil  $perfil
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Perfil $perfil)
	{
		// usamos el policy para ver si el usuario puede editar el perfil
		$this->authorize('view', $perfil);

		return view('perfiles.edit', ['perfil' => $perfil]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Perfil  $perfil
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Perfil $perfil)
	{
		// usamos el policy para ver si el usuario puede editar el perfil
		$this->authorize('update', $perfil);

		// this method is used to update the profile of the user
		// the request is the object that contains the data from the form
		// the perfil is the object that contains the data from the database
		//

		// we should validate the data from the form
		$request->validate([
			'name' => 'required',
			'url' => 'required',
			'biografia' => 'required',
			'imagen' => 'string|nullable',
		]);

		// dd($request->all());

		// if the user has uploaded a new image, we have to delete the old one
		if ($request->imagen) {
			// Obtener los datos de la imagen
			$img = self::getB64Image($request->imagen);

			// Obtener la extensión de la Imagen
			$img_extension = self::getB64Extension($request->imagen);

			// validar la extensión de la imagen y la imagen
			if (!$img_extension || !$img) {
				return redirect()->back()->with('error', 'No se pudo obtener la imagen, intente de nuevo');
			}

			// de aqui en adelante se entiende que la imagen es válida

			// eliminar la imagen anterior
			Storage::disk('public')->delete($perfil->imagen);

			// Crear un nombre unico con la extensión de la imagen
			$img_name = uniqid() . '.' . $img_extension;

			$route_image = 'uploads-perfiles/' . $img_name;

			// Usando el Storage guardar en el disco creado anteriormente y pasandole a
			// la función "put" el nombre de la imagen y los datos de la imagen como
			// segundo parametro
			Storage::disk('public')->put($route_image, $img);

			// rezise the image with the intervention package and save it
			$image_resize = Image::make(public_path('storage/' . $route_image));
			$image_resize->fit(300, 300);
			$image_resize->encode($img_extension, 0);
			$image_resize->save(); // save the image in the storage
		} else {
			// if the user has not uploaded a new image, we keep the old one
			$route_image = $perfil->imagen;
		}

		// dd($request->all());
		// return "editando";

		// update the data in the database for the perfil
		$perfil->update([
			'biografia' => $request->biografia,
			'imagen' => $route_image,
		]);

		// update the data in the database for the user
		$perfil->user->update([
			'name' => $request->name,
			'url' => $request->url,
		]);

		Session::flash('success', 'Perfil actualizado correctamente');
		// redirect the user to the profile page
		return redirect()->route('profile.edit', ['perfil' => $perfil->id]);
	}

	/**
	 * @param $base64_image string data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAA...
	 * @return string
	 */
	public static function  getB64Image($base64_image)
	{
		// Obtener el String base-64 de los datos
		$image_service_str = substr($base64_image, strpos($base64_image, ",") + 1);
		// +1 para quitar el "," del principio quedando así: iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAA...

		// Decodificar ese string y devolver los datos de la imagen
		$image = base64_decode($image_service_str); // decodificar el string y obtener la imagen

		// Retornamos el string decodificado
		return $image;
	}

	/**
	 * Obtener la extensión de la imagen
	 *
	 * @param $base64_image string data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAA...
	 * @return string | null
	 */
	public static function getB64Extension($base64_image)
	{
		// utilizamos un try catch para evitar errores en caso de que no se pueda obtener la extensión de la imagen
		try {
			// la variable $base64_image contiene el string base-64 de la imagen
			// ejemplo: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAA...
			// Obtener la extensión de la imagen
			$image_extension = explode(";", $base64_image)[0]; // data:image/png
			// Obtener la extensión de la imagen
			$image_extension = explode("/", $image_extension)[1]; // png
			// Retornamos la extensión de la imagen
			return $image_extension;
		} catch (\Exception $e) {
			// retornamos null
			return null;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Perfil  $perfil
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Perfil $perfil)
	{
		//
	}
}
