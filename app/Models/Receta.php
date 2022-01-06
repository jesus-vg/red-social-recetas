<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
	use HasFactory;

	/**
	 * A model may have multiple relationships.
	 * example: a receta may have many ingredients
	 * So we need to define what this relationship is called.
	 * We can use relationship names like the following:
	 * 1:1 - hasOne
	 * 1:M - hasMany
	 * M:M - belongsToMany
	 *
	 * inverse
	 * 1:1 - belongsTo
	 * 1:M - belongsTo
	 * M:M - belongsToMany
	 *
	 * doc link: https://laravel.com/docs/8.x/eloquent-relationships
	 */

	/**
	 * Define a one-to-many relationship.
	 * A receta has many categories and a category has many recetas.
	 * so, the relationship is one-to-many.
	 *
	 * use reverse order when model only has foreign key.
	 * in this case, we have a category_id column in the receta table.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(CategoryRecipe::class, 'categoria_id');
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var string[]
	 */
	protected $fillable = [
		'titulo',
		'ingredientes',
		'preparacion',
		'imagen',
		'categoria_id'
	];


	public function getAuthor()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * Establecer la relación de muchos a muchos entre Receta y likes_receta_pivot.
	 * @doc https://laravel.com/docs/8.x/eloquent-relationships
	 * @doc https://laravel.com/docs/8.x/eloquent-relationships#many-to-many
	 * @doc https://laravel.com/docs/8.x/eloquent-relationships#many-to-many-pivot-tables
	 * @doc https://laravel.com/docs/8.x/eloquent-relationships#many-to-many-pivot-tables-with-custom-keys
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function likes()
	{
		return $this->belongsToMany(User::class, 'likes_receta_pivot', 'receta_id', 'user_id');
		/**
		 * Donde:
		 * User::class				Es el modelo al que pertenece la relacion.
		 * 'likes_receta_pivot'		Es el nombre de la tabla pivot.
		 * 'receta_id'				Es el nombre del campo de la tabla pivot que contiene la id de la receta.
		 * 							(se va a relacionar con el id de la receta de este modelo).
		 * 'user_id'				Es el nombre del campo de la tabla pivot que contiene la id del usuario.
		 * 							(Se va a relacionar con el id del usuario del modelo declarado en el 1er parametro).
		 */
	}
}
