<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecetaController extends Controller
{
	//

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __invoke(Request $request)
	{
		$recetas = [
			'receta pizza', 'Receta habmurguesa', 'receta tacos'
		];

		return view('recetas.index', compact('recetas')); // recetas/index.blade.php
		// return view('recetas.index')->with('recetas', $recetas); // recetas/index.blade.php
	}
}
