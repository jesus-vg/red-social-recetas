<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//
		DB::table('users')->insert([
			'name' => 'Juan',
			'email' => 'juan@gmail.com',
			'url' => 'https://www.juan.com',
			'password' => Hash::make('12345678'),
			'created_at' => now(),
			'updated_at' => now(),
		]);
		DB::table('users')->insert([
			'name' => 'Pedro',
			'email' => 'pedro@gmail.com',
			'url' => 'https://www.pedro.com',
			'password' => Hash::make('12345678'),
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}
