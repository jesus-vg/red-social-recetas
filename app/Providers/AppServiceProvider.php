<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// se personaliza la paginación de la aplicación para usar bootstrap en vez de tailwind css
		// Paginator::useBootstrap(); // https://laravel.com/docs/8.x/pagination#customizing-the-pagination-view
	}
}
