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
		//  table recetas categories
		Schema::create('categorias_receta', function (Blueprint $table) {
			$table->id('id');
			$table->string('nombre');
			$table->timestamps();
		});


		Schema::create('recetas', function (Blueprint $table) {
			$table->id();
			$table->string('titulo');
			$table->text('ingredientes');
			$table->text('preparacion');
			$table->string('imagen');
			$table->foreignId('user_id')->references('id')->on('users')->comment('id del usuario que creó la receta');
			$table->foreignId('categoria_id')->references('id')->on('categorias_receta')->comment('id de la categoria de la receta');
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
		Schema::dropIfExists('categorias_receta');
		Schema::dropIfExists('recetas');
	}
}
