@extends('layouts.app')

@section('botones')
	<a
		href="{{ route('recetas.create') }}"
		class="btn btn-primary"
	>Crear nueva receta</a>
@endsection

@section('content')

	<div class="container">
		<h1 class="h1 text-center">Administrar tus recetas</h1>

		<table class="table mt-4 table-striped">
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
							<button
								type="button"
								class="btn btn-danger btn-sm"
							>Delete</button>
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
	</div>

@endsection
