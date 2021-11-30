<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 * Use the following command to create data by default:
	 * php artisan make:seeder CategoriasSeeder
	 *
	 * doc https://laravel.com/docs/8.x/migrations#creating-seeds
	 *
	 * @return void
	 */
	public function run()
	{
		//
		DB::table('categorias_receta')->insert([
			'nombre' => 'Desayuno',
			'created_at' => now(),
			'updated_at' => now(),
		]);
		DB::table('categorias_receta')->insert([
			'nombre' => 'Almuerzo',
			'created_at' => now(),
			'updated_at' => now(),
		]);
		DB::table('categorias_receta')->insert([
			'nombre' => 'Cena',
			'created_at' => now(),
			'updated_at' => now(),
		]);
		DB::table('categorias_receta')->insert([
			'nombre' => 'Postre',
			'created_at' => now(),
			'updated_at' => now(),
		]);
		DB::table('categorias_receta')->insert([
			'nombre' => 'Bebida',
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}
