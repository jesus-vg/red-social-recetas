<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasTable extends Migration
{
	/**
	 * Run the migrations.
	 * Use the following command to create a migration, a model and resource controller:
	 * php artisan make:migration create_recetas_table --create=recetas
	 *
	 * run the following command to delete a migration:
	 * php artisan migrate:rollback
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recetas', function (Blueprint $table) {
			$table->id();
			$table->string('titulo');
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
		Schema::dropIfExists('recetas');
	}
}
