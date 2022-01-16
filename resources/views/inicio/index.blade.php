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

	{{--	mostrarmos las categorias de cada receta	--}}
	@foreach($recetas_categoria as $receta)
		<galeria-recetas-categoria recetas="{{json_encode($receta['data']) }}"
								   categoria="{{$receta['categoria']}}"></galeria-recetas-categoria>
	@endforeach
@endsection
