<?php

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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
