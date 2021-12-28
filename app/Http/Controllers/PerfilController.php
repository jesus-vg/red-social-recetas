<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Perfil  $perfil
	 * @return \Illuminate\Http\Response
	 */
	public function show(Perfil $perfil)
	{
		// this method is used to show the profile of the user
		//
		// return view('perfiles.show', compact('perfil'));
		return view('perfiles.show', ['perfil' => $perfil]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Perfil  $perfil
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Perfil $perfil)
	{
		//
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
		// this method is used to update the profile of the user
		// the request is the object that contains the data from the form
		// the perfil is the object that contains the data from the database
		//
		// we should validate the data from the form
		$request->validate([
			'name' => 'required',
			'url' => 'required',
			'biografia' => 'required',
			'imagen' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg',
		]);

		// if the user has uploaded a new image, we have to delete the old one
		if (request()->hasFile('imagen')) {
			// delete the old image
			Storage::disk('public')->delete($perfil->imagen);
			// store the new image
			// store() method returns the path of the file
			$route_image = request()->file('imagen')->store('uploads-perfiles', 'public');

			// rezise the image with the intervention package and save it
			$image_resize = Image::make(public_path('storage/' . $route_image))->fit(300, 300);
			// save the image in the storage
			$image_resize->save();
		} else {
			// if the user has not uploaded a new image, we keep the old one
			$route_image = $perfil->imagen;
		}

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

		// redirect the user to the profile page
		return redirect()->route('profile.show', $perfil);
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
