@extends('layouts.app')

@section('botones')
	<a
		href="{{ route('recetas.create') }}"
		class="btn btn-primary"
	>Crear nueva receta</a>
@endsection

@section('content')
	<div class="container">
		<h1 class="h1 text-center">Administra tus recetas</h1>

		{{-- we validate if data recipes not exist --}}
		@if (count($recetas) > 0)
			<table class="table mt-4 table-striped tabla-recetas">
				<thead class="bg-primary text-white">
					<tr>
						<th>Titulo</th>
						<th>Categoría</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($recetas as $receta)
						<tr>
							<td scope="row">{{ $receta->titulo }}</td>
							<td>{{ $receta->categories->nombre }}</td>
							<td>
								<eliminar-receta
									receta-id="{{ $receta->id }}"
									receta-titulo="{{ $receta->titulo }}"
								></eliminar-receta>

								<a
									href="{{ route('recetas.edit', ['receta' => $receta->id]) }}"
									class="btn btn-primary btn-sm"
								>Editar</a>

								<a
									href="{{ route('recetas.show', ['receta' => $receta->id]) }}"
									class="btn btn-info btn-sm"
								>Ver</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{{-- paginacion centrada --}}
			<div class="d-flex justify-content-center">
				{{-- mostramos la paginacion --}}
				{{ $recetas->links('pagination::bootstrap-4') }}
			</div>
		@else
			{{-- we show message if data recipes not exist --}}
			<div
				class="alert alert-info mt-4"
				role="alert"
			>
				No tienes recetas creadas
			</div>
		@endif
	</div>

@endsection
