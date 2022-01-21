<?php

namespace App\Http\Controllers;

use App\Models\CategoryRecipe;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

require 'ImagenUtilidades.php';

class InicioController extends Controller
{
    //

    public function index()
    {
        // Obtenemos las recetas mas recientes
        $recetas_recientes = Receta::select( ['id', 'titulo', 'preparacion', 'imagen', 'created_at'] )
            ->orderBy( 'created_at', 'desc' ) // ->latest() se puede usar siempre y cuando tengamos el campo created_at en la tbl
            ->take( 5 )
            ->get()
            ->toArray();
        // $recetas_recientes = Receta::orderBy('created_at', 'desc')->take(3)->get();

        $recetas_recientes = $this->getDatosAdicionalesReceta( $recetas_recientes );
        // dd( $recetas_recientes );

        // @var array para almacenar los datos, cada categoria y sus respectivas recetas
        $recetas_por_categoria = [];

        // obtenemos el id y el nombre de cada categoria
        $categorias_receta = CategoryRecipe::get( ['id', 'nombre'] )->toArray();

        // obtenermos las recetas por categoria
        foreach ( $categorias_receta as $categoria ) {
            // dd( $categoria );
            // obtenemos las recetas segun la categoria actual
            $recetas = Receta::select( ['id', 'titulo', 'preparacion', 'imagen', 'created_at'] )
                ->orderBy( 'created_at', 'desc' ) // ->latest()
                ->whereCategoria_id( $categoria['id'] )
                ->take( 5 )
                ->get()
                ->toArray();

            $recetas = $this->getDatosAdicionalesReceta( $recetas );
            // dd( $recetas );

            // obtenemos la cantidad de likes de cada receta
            foreach ( $recetas as $key => $receta ) {
                $recetas[$key]['total_likes'] = DB::table( 'likes_receta_pivot' )
                    ->select( 'id' )
                    ->whereReceta_id( $receta['id'] )
                    ->count();
            }

            $data = [
                'categoria_id' => $categoria['id'],
                'categoria'    => $categoria['nombre'],
                'data'         => array_values( $recetas ),
            ];

            array_push( $recetas_por_categoria, $data );
        }

        // obtenemos las recetas mas votadas
        $recetas_mas_votadas = $this->getRecetasMasVotadas();
        // dd( $recetas_mas_votadas );

        // dd( $recetas_por_categoria );

        return view( 'inicio.index', [
            'recetas_recientes'     => $recetas_recientes,
            'recetas_por_categoria' => $recetas_por_categoria,
            'recetas_mas_votadas'   => $recetas_mas_votadas,
        ] );
    }

    /**
     * @return array
     */
    public function getRecetasMasVotadas(): array
    {
        $recetas_mas_votadas = Receta::select( ['id', 'titulo', 'preparacion', 'imagen', 'created_at'] )
            ->withCount( 'likes' )
            ->orderBy( 'likes_count', 'desc' )
            ->take( 6 )
            ->get()
            ->toArray();

        return $this->getDatosAdicionalesReceta( $recetas_mas_votadas );
    }

    /**
     * @param array $recetas array de recetas
     * @return array el mismo array de recetas con datos adicionales (preparacion, color)
     */
    private function getDatosAdicionalesReceta( array $recetas ): array
    {
        // modificamos y agregamos datos necesarios a cada receta
        foreach ( $recetas as $key => $receta ) {
            // quitamos las etiquetas html y limitamos el contenido a 15 palabras
            $recetas[$key]['preparacion'] = Str::words( strip_tags( $receta['preparacion'] ), 15 );

            // obtenemos el color promedio de cada imagen
            $recetas[$key]['color'] = getAverageColor( $receta['imagen'] );

            // dd( $receta );
        }

        return $recetas;
    }

}
