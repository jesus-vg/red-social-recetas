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
		$recetas_recientes = Receta::select( ['id', 'titulo', 'preparacion', 'imagen', 'created_at'] )
			->orderBy( 'created_at', 'desc' ) // ->latest() se puede user esto siempre y cuando tengamos el campo created_at en la tbl
			->take( 5 )
			->get()
			->toArray();
		// $recetas_recientes = Receta::orderBy('created_at', 'desc')->take(3)->get();

		// dd( $recetas_recientes );
		foreach ( $recetas_recientes as $key => $receta ) {

			// quitamos las etiquetas html de preparacion y cortamos el texto a 15 palabras
			$recetas_recientes[ $key ][ 'preparacion' ] = Str::words(
				strip_tags( $receta[ 'preparacion' ] ),
				15
			);

			// obtenemos el color promedio de cada imagen
			$recetas_recientes[ $key ][ 'color' ] = getAverageColor( $receta[ 'imagen' ] );
		}

		// array para almacenar los datos, cada categoria y sus respectivas recetas
		$recetas_categoria = [];

		// obtenemos el id y el nombre de cada categoria
		$categorias_receta = CategoryRecipe::get( ['id', 'nombre'] )->toArray();

		// obtenermos las recetas por categoria
		foreach ( $categorias_receta as $categoria ) {
			// dd( $categoria );
			// obtenemos las recetas segun la categoria actual
			$recetas = Receta::select( ['id', 'titulo', 'preparacion', 'imagen', 'created_at'] )
				->orderBy( 'created_at', 'desc' ) // ->latest()
				->whereCategoria_id( $categoria[ 'id' ] )
				->take( 5 )
				->get()
				->toArray();

			// pasamos de un array asociativo a uno sin indices
			// $recetas = array_values( $recetas );
			// dd( $recetas );

			// quitamos las etiquetas html y limitamos el contenido a 15 caracteres
			foreach ( $recetas as $key => $receta ) {
				$recetas[ $key ][ 'preparacion' ] = Str::words( strip_tags( $receta[ 'preparacion' ] ), 15 );
				$recetas[ $key ][ 'color' ]       = getAverageColor( $receta[ 'imagen' ] );
				// dd( $receta );
			}

			$data = [
				'categoria_id' => $categoria[ 'id' ],
				'categoria'    => $categoria[ 'nombre' ],
				'data'         => array_values( $recetas ),
			];

			array_push( $recetas_categoria, $data );
		}
		// dd( $recetas_categoria );

		return view( 'inicio.index', [
			'recetas_recientes' => $recetas_recientes,
			'recetas_categoria' => $recetas_categoria,
		] );
	}
}
