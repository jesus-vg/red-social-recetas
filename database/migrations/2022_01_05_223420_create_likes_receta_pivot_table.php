<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesRecetaPivotTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('likes_receta_pivot', function (Blueprint $table) {
			$table->id();
			$table->foreignId('receta_id')->references('id')->on('recetas');
			$table->foreignId('user_id')->constrained(); //->references('id')->on('users'); es lo mismo que el anterior
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
		Schema::dropIfExists('likes_receta_pivot');
	}
}
