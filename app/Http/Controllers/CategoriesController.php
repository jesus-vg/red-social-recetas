<?php

namespace App\Http\Controllers;

use App\Models\CategoryRecipe;
use App\Models\Receta;
use Illuminate\Support\Str;

require 'ImagenUtilidades.php';

class CategoriesController extends Controller
{
    //
    /**
     * @param CategoryRecipe $categoria
     * @link paginate https://laravel.com/docs/8.x/pagination
     */
    public function show( CategoryRecipe $categoria )
    {
        // mostramos las recetas que pertenecen a la categoria actual paginado de 6 en 6
        $recetas = Receta::select( ['id', 'titulo', 'preparacion', 'imagen', 'created_at'] )
            ->withCount( 'likes' )
            ->whereCategoria_id( $categoria->id )
            ->latest()
            ->paginate( 6, ['*'], 'pagina' ); // se cambia el nombre de la variable de paginacion a pagina (default es page)
        // dd( $recetas->toArray() );

        // modificamos y agregamos datos necesarios a cada receta
        foreach ( $recetas as $key => $receta ) {

            // quitamos las etiquetas html y limitamos el contenido a 15 palabras
            $recetas[$key]['preparacion'] = Str::words( strip_tags( $receta['preparacion'] ), 15 );

            // obtenemos el color promedio de cada imagen
            $recetas[$key]['color'] = getAverageColor( $receta['imagen'] );

            // dd( $receta );
        }

        // dd( $recetas->toArray() );

        return view( 'categorias.show', compact( 'categoria', 'recetas' ) );
    }
}
