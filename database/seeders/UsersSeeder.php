<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 * use the next command to seed the database
	 * php artisan db:seed
	 *
	 * To clean the database use the next command
	 * php artisan migrate:refresh
	 *
	 * to create the data use the next command
	 * php artisan db:seed
	 *
	 *
	 * @return void
	 */
	public function run()
	{
		//
		$user = User::create([
			'name' => 'admin',
			'email' => 'admin@gmail.com',
			'url' => 'http://localhost:8000/',
			'password' => Hash::make('12345678'),
		]);

		// we create the profile for the user
		// $user->profile()->create([
		// 	'imagen' => 'https://source.unsplash.com/random/200x200',
		// ]);

		$user = User::create([
			'name' => 'user',
			'email' => 'user@gmail.com',
			'url' => 'http://localhost:8000/',
			'password' => Hash::make('12345678'),
		]);

		// we create the profile for the user
		// $user->profile()->create([
		// 	'imagen' => 'https://source.unsplash.com/random/200x200',
		// ]);

		$user = User::create([
			'name' => 'user2',
			'email' => 'user2@gmail.com',
			'url' => 'http://localhost:8000/',
			'password' => Hash::make('12345678'),
		]);

		// we create the profile for the user
		// $user->profile()->create([
		// 	'imagen' => 'https://source.unsplash.com/random/200x200',
		// ]);
	}
}
