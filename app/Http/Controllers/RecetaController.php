<?php

namespace App\Http\Controllers;

use App\Models\CategoryRecipe;
use App\Models\Receta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['except' => 'show']); // only authenticated users can access this controller
		// https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/learn/lecture/20324719
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function index(): View
	{
		/**
		 * doc to see how to use the return view() method in a controller
		 * https://laravel.com/docs/8.x/routing#view-routes
		 * https://laravel.com/docs/8.x/views#introduction
		 */
		$recipes = Auth::user()->recipes;
		// dd($recipes);
		return view('recetas.index', ['recetas' => $recipes]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create(): View
	{
		// DB::table('categorias_receta')->get()->pluck('nombre', 'id')->dd();
		// $categorias = DB::table('categorias_receta')->get()->pluck('nombre', 'id');
		$categorias = CategoryRecipe::all([
			'id',
			'nombre',
		]);
		return view('recetas.create', ['categorias' => $categorias]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * doc to see how to use the validate() method in a controller
	 * https://laravel.com/docs/8.x/validation#available-validation-rules
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		// there we validate the request data
		$data = request()->validate([
			'titulo' => 'required|min:6',
			'ingredientes' => 'required|min:10',
			'preparacion' => 'required|min:10',
			'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'categoria' => 'required|numeric',
		]);

		// store() method returns the path of the file
		$route_image = $data['imagen']->store('uploads-recetas', 'public');
		// for amazon s3
		// $image = $data['imagen']->store('uploads-recetas', 's3');
		// the files are stored in the public folder of the project (storage/app/public)

		// To can view the image in the browser, important, we need to add the public path to the image
		// We may need to add the image to the database and create a symbolic link to the public folder:
		// use the following command to create the link:
		// php artisan storage:link

		// To can use the image in the view we need to use the asset() method
		// https://laravel.com/docs/8.x/views#asset-helper
		// https://laravel.com/docs/8.x/filesystem#resizing-images

		// resizing the image with intervention image, we use the fit() method
		// doc http://image.intervention.io/api/fit
		$image_resize = Image::make(public_path('storage/' . $route_image))->fit(1000, 600);
		// saving the image
		$image_resize->save();

		// save the user to db (with model)
		auth()->user()->recipes()->create([
			'titulo' => $data['titulo'],
			'ingredientes' => $data['ingredientes'],
			'preparacion' => $data['preparacion'],
			'imagen' => $route_image, // the path of the image
			'categoria_id' => $data['categoria'],
		]);

		/*DB::table('recetas')->insert([
			'titulo' => $data['titulo'],
			'ingredientes' => $data['ingredientes'],
			'preparacion' => $data['preparacion'],
			'imagen' => $route_image, // the path of the image
			'categoria_id' => $data['categoria'],
			'user_id' => auth()->user()->id,
			'created_at' => now(),
			'updated_at' => now(),
		]);*/
		// dd($request->all()); // show all the request data

		return redirect()->route('recetas.index');
		//
	}

	/**
	 * Display the specified resource.
	 * doc to see how to use show() method in a controller
	 * https://laravel.com/docs/8.x/routing#show-routes
	 *
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function show(Receta $receta)
	{
		// dd($receta);
		// return $receta;
		//
		return view('recetas.show', ['receta' => $receta]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Receta $receta)
	{
		//
		$categorias = CategoryRecipe::all(['id', 'nombre',]);
		return view('recetas.edit', ['receta' => $receta, 'categorias' => $categorias]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Receta $receta)
	{
		// we authorize the user to edit the recipe
		$this->authorize('update', $receta);

		// First we have to validate the request data
		$request = request()->validate([
			'titulo' => 'required|min:6',
			'ingredientes' => 'required|min:10',
			'preparacion' => 'required|min:10',
			'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'categoria' => 'required|numeric',
		]);

		// if the user has uploaded a new image
		if (request()->hasFile('imagen')) {
			// doc to see how to use the delete() method in a controller
			// https://laravel.com/docs/8.x/filesystem#deleting-files
			// delete the old image
			Storage::disk('public')->delete($receta->imagen);
			// store the new image
			// store() method returns the path of the file
			$route_image = $request['imagen']->store('uploads-recetas', 'public');
			// for amazon s3
			// $image = $request['imagen']->store('uploads-recetas', 's3');
			// the files are stored in the public folder of the project (storage/app/public)

			// To can view the image in the browser, important, we need to add the public path to the image
			// We may need to add the image to the database and create a symbolic link to the public folder:
			// use the following command to create the link:
			// php artisan storage:link

			// To can use the image in the view we need to use the asset() method
			// https://laravel.com/docs/8.x/views#asset-helper
			// https://laravel.com/docs/8.x/filesystem#resizing-images

			// resizing the image with intervention image, we use the fit() method
			// doc http://image.intervention.io/api/fit
			$image_resize = Image::make(public_path('storage/' . $route_image))->fit(1000, 600);
			// saving the image
			$image_resize->save();
		} else {
			// if the user has not uploaded a new image, we keep the old one
			$route_image = $receta->imagen;
		}

		// doc to see how to use update() method in a controller
		// https://laravel.com/docs/8.x/eloquent#updating-records
		// update the record in the database
		$receta->update([
			'titulo' => $request['titulo'],
			'ingredientes' => $request['ingredientes'],
			'preparacion' => $request['preparacion'],
			'imagen' => $route_image, // the path of the image
			'categoria_id' => $request['categoria'],
		]);

		return redirect()->route('recetas.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Receta $receta)
	{
		// autoryze the user to delete the recipe
		$this->authorize('delete', $receta);

		// then we delete the record from the database
		$receta->delete();

		// we delete the image from the storage
		if ($receta->imagen && Storage::disk('public')->exists($receta->imagen)) {
			Storage::disk('public')->delete($receta->imagen);
		}

		return redirect()->route('recetas.index');
	}
}
