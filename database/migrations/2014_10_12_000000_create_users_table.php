<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

	/**
	 * To create a migration, run the following command from your project root:
	 * php artisan make:migration create_users_table --create=users
	 *
	 * a way to create a migration, a model and resource controller use the following command:
	 * php artisan make:model User -mcr
	 * where -mcr is the option to create a migration, a model and resource controller
	 */

	/**
	 * Run the migrations.
	 * use this command to create the migration:
	 * php artisan make:migration create_users_table --create=users
	 * use with a model:
	 * php artisan make:model User -m or php artisan make:model User --migration
	 * @doc https://laravel.com/docs/8.x/migrations
	 * @doc https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/learn/lecture/20324529#questions
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('url')->nullable();
			$table->string('password');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
