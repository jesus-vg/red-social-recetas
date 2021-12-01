<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth'); // only authenticated users can access this controller
		// https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/learn/lecture/20324719
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		/**
		 * doc to see how to use the return view() method in a controller
		 * https://laravel.com/docs/8.x/routing#view-routes
		 * https://laravel.com/docs/8.x/views#introduction
		 */
		$recetas = [
			'Receta 1',
			'Receta 2',
			'Receta 3',
		];
		// dd($recetas);
		return view('recetas.index', ['recetas' => $recetas]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		// DB::table('categorias_receta')->get()->pluck('nombre', 'id')->dd();
		$categorias = DB::table('categorias_receta')->get()->pluck('nombre', 'id');
		return view('recetas.create', ['categorias' => $categorias]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * doc to see how to use the validate() method in a controller
	 * https://laravel.com/docs/8.x/validation#available-validation-rules
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$data = request()->validate([
			'titulo' => 'required|min:6',
			'ingredientes' => 'required|min:10',
			'preparacion' => 'required|min:50',
			'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'categoria' => 'required|numeric',
		]);

		// store() method returns the path of the file
		$route_image = $data['imagen']->store('uploads-recetas', 'public');
		// for amazon s3
		// $image = $data['imagen']->store('uploads-recetas', 's3');
		// the files are stored in the public folder of the project (storage/app/public)

		// To can view the image in the browser, important, we need to add the public path to the image
		// We may need to add the image to the database and create a symbolic link to the public folder:
		// use the following command to create the link:
		// php artisan storage:link

		// To can use the image in the view we need to use the asset() method
		// https://laravel.com/docs/8.x/views#asset-helper
		// https://laravel.com/docs/8.x/filesystem#resizing-images

		// resizing the image with intervention image, we use the fit() method
		// doc http://image.intervention.io/api/fit
		$image_resize = Image::make(public_path('storage/' . $route_image))->fit(700, 600);
		// saving the image
		$image_resize->save();

		DB::table('recetas')->insert([
			'titulo' => $data['titulo'],
			'ingredientes' => $data['ingredientes'],
			'preparacion' => $data['preparacion'],
			'imagen' => $route_image, // the path of the image
			'categoria_id' => $data['categoria'],
			'user_id' => auth()->user()->id,
			'created_at' => now(),
			'updated_at' => now(),
		]);
		// dd($request->all()); // show all the request data

		return redirect()->route('recetas.index');
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function show(Receta $receta)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Receta $receta)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Receta $receta)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Receta  $receta
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Receta $receta)
	{
		//
	}
}
