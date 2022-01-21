@extends('layouts.app')

@section('styles')
	<link
		rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/css/splide.min.css"
	>
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
	</galeria-recetas-categoria>{{-- @foreach ($recetas_categoria as $receta)
<galeria-recetas-categoria recetas="{{json_encode($receta['data']) }}" categoria="{{$receta['categoria']}}">
</galeria-recetas-categoria>
@endforeach --}}

	{{-- mostrar las recetas mas votadas --}}
	<h2 class="title mt-5">Nuestras recetas más votadas</h2>
	<div class="gallery-flex">

		@foreach ($recetas_mas_votadas as $receta)
			<div class="gallery-flex__item">
				<div class="gallery-flex__item--header">
					<img
						data-src="{{ asset('storage/' . $receta['imagen']) }}"
						class="lazyload"
						alt="{{ $receta['titulo'] }}"
					>
				</div>
				<div class="gallery-flex__item--body">
					<h3>{{ $receta['titulo'] }}</h3>
					<div class="d-flex justify-content-between my-2">
						<div class="text-primary">
							<fecha-receta fecha="{{ $receta['created_at'] }}"></fecha-receta>
						</div>
						<div class="likes-receta">
							{{ $receta['likes_count'] }} Les gustó
						</div>
					</div>
					<p>
						{{ html_entity_decode($receta['preparacion']) }}
					</p>
				</div>
				<div class="gallery-flex__item--footer">
					<a
						href="{{ route('recetas.show', ['receta' => $receta['id']]) }}"
						class="btn btn-primary"
					>Ver</a>
				</div>
			</div>
		@endforeach
	</div>
@endsection
