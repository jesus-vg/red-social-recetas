<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;

class LikesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
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
		// dd($receta);
		// registramos o eliminamos el like de la receta seleccionada por el usuario actual (auth)
		return auth()->user()->likes()->toggle($receta);
	}
}
