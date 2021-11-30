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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
