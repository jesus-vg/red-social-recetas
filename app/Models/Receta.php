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
	 */
	public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo( CategoryRecipe::class, 'categoria_id' );
	}
}
