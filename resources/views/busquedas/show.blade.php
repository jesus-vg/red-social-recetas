@extends('layouts.app')

@section('content')

	<h1 class="h1 mb-3">
		Resutados de la búsqueda:
	</h1>

	{{-- mostrar la cantidad de registros encontrados --}}
	@php
	// total de registros encontrados
	$cantidad = $recetas->total();

	// personalizar el mensaje según la cantidad de registros encontrados
	if ($cantidad == 0) {
					$mensaje = 'No se encontraron recetas con el nombre: ' . $busqueda;
	} elseif ($cantidad == 1) {
					$mensaje = 'Se encontró 1 receta con el nombre: ' . $busqueda;
	} else {
					$mensaje = 'Se encontraron ' . $cantidad . ' recetas con el nombre: ' . $busqueda;
	}
	@endphp
	<h2 class="title mt-5">{{ $mensaje }}</h2>

	{{-- Mostrar las recetas encontradas --}}
	<div class="gallery-flex">

		@foreach ($recetas as $receta)
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
						@php
							$preparacion = Str::words(strip_tags($receta['preparacion']), 15);
						@endphp
						{{ html_entity_decode($preparacion) }}
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

	{{-- Paginación --}}
	<div class="d-flex justify-content-center">
		{{ $recetas->links('pagination::bootstrap-4') }}
	</div>
@endsection
