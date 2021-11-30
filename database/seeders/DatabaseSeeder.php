<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 * doc to see how to run this the seeders:
	 * https://laravel.com/docs/8.x/seeding#calling-additional-seeders
	 * use the following command to run the seeders:
	 * php artisan db:seed
	 *
	 * @return void
	 */
	public function run()
	{
		// \App\Models\User::factory(10)->create();
		$this->call(CategoriasSeeder::class);
		$this->call(UsersSeeder::class);
	}
}
