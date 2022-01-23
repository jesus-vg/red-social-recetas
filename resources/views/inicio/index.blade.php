@extends('layouts.app')

@section('styles')
	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/css/splide.min.css"
	>
@endsection

@section('hero')
	<div class="hero-search">
		<form
			class="container h-100"
			action="{{ route('recetas.search') }}"
			method="GET"
		>
			<div class="row h-100 align-items-center">
				<div class="col-md-4 hero-search__search">
					<p class="display-4">Encuentra una receta para tu proxima comida</p>

					<input
						type="search"
						class="form-control"
						name="buscar"
						aria-describedby="Buscar recetas"
						placeholder="Buscar..."
						value="{{ old('buscar', '') }}"
					>

					@error('buscar')
						<small class="text-danger bg-white py-2 d-block">
							{{ $message }}
						</small>
					@enderror

				</div>
			</div>
		</form>
	</div>
@endsection

@section('content')

	<h1 class="h1 mb-3">
		Últimas recetas
	</h1>
	<ultimas-recetas data="{{ json_encode($recetas_recientes) }}"></ultimas-recetas>

	{{-- mostrarmos las categorias de cada receta --}}
	<h2 class="title mt-5">Nuestras últimas entradas por categoría</h2>

	<galeria-recetas-categoria
		recetas="{{ json_encode($recetas_por_categoria) }}"
		categoria="{{ 'categoria' }}"
	>
	</galeria-recetas-categoria>

	{{-- mostrar las recetas mas votadas --}}
	<h2 class="title mt-5">Nuestras recetas más votadas</h2>
	@include('ui/galeria-recetas', ['recetas' => $recetas_mas_votadas]);

@endsection
