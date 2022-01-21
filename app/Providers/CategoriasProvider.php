<?php

namespace App\Providers;

use App\Models\CategoryRecipe;
use Illuminate\Support\ServiceProvider;

class CategoriasProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     * Importante registrar el provider en el bootstrap de la aplicacion.
     * TODO verificar buenas practicas para registrar providers
     * @return void
     */
    public function boot()
    {
        // mostramos las categorias en todas las vistas
        view()->composer( '*', function ( $view ) {
            $categorias = CategoryRecipe::select( ['id', 'nombre'] )->get();
            $view->with( 'categorias', $categorias );
        } );
    }
}
