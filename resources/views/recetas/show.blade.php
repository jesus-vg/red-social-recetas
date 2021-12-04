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
					<span class="font-weit-bold text-primary">Escrito en: </span> {{ $receta->categories->nombre }}
				</p>
			</div>
			<div class="col-md-6 text-right">
				<p>
					<span class="font-weit-bold text-primary">Por: </span> {{ $receta->getAuthor->name }}
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

	</article>
@endsection
