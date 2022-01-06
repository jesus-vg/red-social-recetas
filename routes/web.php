<?php

use App\Http\Controllers\LikesController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * doc to see how to use the return view() method in a controller
 * https://laravel.com/docs/8.x/routing#view-routes
 *
 * doc to see how to use the tag name in a view
 * https://laravel.com/docs/8.x/views#introduction
 * https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/learn/lecture/20324653
 */

Route::get('/', function () {
	return view('welcome');
});

Route::get('/recetas', [RecetaController::class, 'index'])->name('recetas.index');

Route::get('/recetas/create', [RecetaController::class, 'create'])->name('recetas.create');

Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store');

// show the recipe with the id passed in the url
// Route::get('/recetas/{id}', [RecetaController::class, 'show'])->name('recetas.show');
Route::get('/recetas/{receta}', [RecetaController::class, 'show'])->name('recetas.show');

Route::get('/recetas/{receta}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
Route::put('/recetas/{receta}', [RecetaController::class, 'update'])->name('recetas.update');

Route::delete('/recetas/{receta}', [RecetaController::class, 'destroy'])->name('recetas.destroy');

// ruta para mostrar las recetas de un usuario paginadas de 5 en 5
Route::get('/recetas/usuario/{idUsuario}', [RecetaController::class, 'paginacionRecetas'])->name('recetas.paginacion')->where('idUsuario', '[0-9]+');

// rutas version corta de recetas
// Route::resource('recetas', 'RecetaController');

// Ruta para almacenar los likes de una receta
Route::post('/recetas/likes/{receta}', [LikesController::class, 'update'])->name('likes.update')->where('idReceta', '[0-9]+');


// routes for the profile user
Route::get('/profile/{perfil}', [PerfilController::class, 'show'])->name('profile.show');
// uri is a string that represents the uri of the route
// example: /profile/{perfil}
// where:
// {perfil} is the name of the parameter and should be the same as the name of the model this is important

// route to edit the profile
Route::get('/profile/{perfil}/edit', [PerfilController::class, 'edit'])->name('profile.edit');

// route to update the profile
Route::put('/profile/{perfil}', [PerfilController::class, 'update'])->name('profile.update');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
