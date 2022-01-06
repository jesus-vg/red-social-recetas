<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var string[]
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'url',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * The user has many recipes.
	 * the recipes are the recipes that the user has created.
	 * So, the relationship is one to many.
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function recipes(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(Receta::class);
	}

	/**
	 * The user has one profile.
	 * So, the relationship is one to one.
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
	{
		return $this->hasOne(Perfil::class);
	}

	/**
	 * Here there are the methods that are used on the life cycle of the model.
	 * for example, when the user is created, the profile is created too.
	 * @doc https://laravel.com/docs/8.x/eloquent#events
	 *
	 * @return void
	 */
	public static function boot()
	{
		parent::boot();

		/**
		 * we create the profile when the user is created.
		 */
		static::created(function (User $user) {
			$user->profile()->create();
		});
	}

	/**
	 * Establecemos la relacion para mostrar las recetas que le han gustado el usuario.
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function likes()
	{
		return $this->belongsToMany(Receta::class, 'likes_receta_pivot', 'user_id', 'receta_id');
		/**
		 * Donde:
		 * Receta::class			Es el modelo al que pertenece la relacion.
		 * 'likes_receta_pivot'		Es el nombre de la tabla pivote que contiene los likes.
		 * 'user_id'				Es el nombre del campo de la tabla pivote que contiene el id del usuario para relacionarlo con el modelo de usuario.
		 * 'receta_id'				Es el nombre del campo de la tabla pivote que contiene el id de la receta para relacionarlo con el modelo de receta.
		 */
	}
}
