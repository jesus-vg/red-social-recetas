@extends('layouts.app')

@section('content')
	<h2 class="title mb-5">Categoria: {{ $categoria->nombre }}</h2>
	@include('ui/galeria-recetas', ['recetas' => $recetas])

	{{-- mostramos la paginacion con estilo bootstrap --}}
	<div class="d-flex justify-content-center mt-5">
		{{ $recetas->links('pagination::bootstrap-4') }}
	</div>
@endsection
