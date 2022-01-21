@extends('layouts.app')

@section('content')
	{{-- {{ $receta }} --}}
	<article>
		<h1 class="h1 text-center">{{ $receta->titulo }}</h1>
		<div class="banner my-4">
			<img
				src="/storage/{{ $receta->imagen }}"
				class="rounded"
				alt="{{ $receta->titulo }}"
			>
			<div class="mask"></div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<p>
					<span class="font-weit-bold text-primary">Escrito en: </span>
					<a href="{{ route('categorias.show', ['categoria' => $receta->categoria_id]) }}">
						{{ $receta->categories->nombre }}
					</a>
				</p>
			</div>
			<div class="col-md-6 text-md-right">
				<p>
					<span class="font-weit-bold text-primary">Por: </span>
					<a href="{{ route('profile.show', [$receta->getAuthor->id]) }}">{{ $receta->getAuthor->name }}</a>
				</p>
			</div>
		</div>

		<p>
			<span class="font-weit-bold text-primary">Fecha: </span>
			<fecha-receta fecha="{{ $receta->created_at }}"></fecha-receta>
		</p>

		<div class="ingredientes mb-4">
			<h2 class="h2 text-primary">Ingredientes</h2>
			{!! $receta->ingredientes !!}
		</div>

		<div class="preparacion">
			<h2 class="h2 text-primary">Preparación</h2>
			{!! $receta->preparacion !!}
		</div>

		{{-- mostrar componente likes --}}
		<likes
			:id-receta="{{ $receta->id }}"
			:total-likes="{{ $likes->total_likes }}"
			:liked="{{ $likes->liked ? 'true' : 'false' }}"
		></likes>

	</article>
@endsection
