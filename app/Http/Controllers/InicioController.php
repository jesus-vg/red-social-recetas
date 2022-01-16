<?php

namespace App\Http\Controllers;

use App\Models\CategoryRecipe;
use App\Models\Receta;
use Illuminate\Support\Str;

require 'ImagenUtilidades.php';

class InicioController extends Controller
{
	//

	function index()
	{
		// Obtenemos las recetas mas recientes
		$recetas_recientes = Receta::latest()->take( 5 )->get( ['id', 'titulo', 'preparacion', 'imagen'] )->toArray();
		// $recetas_recientes = Receta::orderBy('created_at', 'desc')->take(3)->get();

		foreach ( $recetas_recientes as $key => $receta ) {

			// quitamos las etiquetas html de preparacion y cortamos el texto a 15 palabras
			$recetas_recientes[ $key ][ 'preparacion' ] = Str::words( strip_tags( $receta[ 'preparacion' ] ), 15 );

			// obtenemos el color promedio de cada imagen
			$recetas_recientes[ $key ][ 'color' ] = getAverageColor( $receta[ 'imagen' ] );
		}
		// dd($recetas_recientes);

		// array para almacenar los datos
		$recetas_categoria = [];

		// obtenemos el id y el nombre de cada categoria
		$categorias_receta = CategoryRecipe::get( ['id', 'nombre'] )->toArray();

		// obtenermos las recetas por categoria
		foreach ( $categorias_receta as $categoria ) {
//			dd( $categoria );
			// obtenemos las recetas segun la categoria actual
			$recetas = Receta::latest()->take( 5 )->where( 'categoria_id', $categoria[ 'id' ] )->get()->toArray();

			// pasamos de un array asociativo a uno sin indices
//			$recetas = array_values( $recetas );
//			dd( $recetas );

			// quitamos las etiqueta html y limitamos el contenido a 15 caracteres
			foreach ( $recetas as $key => $receta ) {
				$recetas[ $key ][ 'preparacion' ] = Str::words( strip_tags( $receta[ 'preparacion' ] ), 15 );
				$recetas[ $key ][ 'color' ]       = getAverageColor( $receta[ 'imagen' ] );
//				dd( $receta );
			}

			$data = [
				'categoria_id' => $categoria[ 'id' ],
				'categoria'    => $categoria[ 'nombre' ],
				'data'         => array_values( $recetas ),
			];
			array_push( $recetas_categoria, $data );
		}
//		dd( $recetas_categoria );

		return view( 'inicio.index', [
			'recetas_recientes' => $recetas_recientes,
			'recetas_categoria' => $recetas_categoria,
		] );
	}
}
