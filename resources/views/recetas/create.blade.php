@extends('layouts.app')

@section('botones')
	<a
		href="{{ route('recetas.index') }}"
		class="btn btn-primary"
	>
		<i class="fa fa-arrow-left"></i> Volver
	</a>
@endsection

@section('content')
	<h2 class="h2 text-center">Agregar nueva receta</h2>

	<div class="container">
		<form
			method="POST"
			action="{{ route('recetas.store') }}"
		>
			@csrf
			<div class="form-group row">
				<label
					for="titulo"
					class="col-sm-12 col-form-label"
				>Titulo</label>
				<div class="col-sm-12">
					<input
						type="text"
						class="form-control"
						name="titulo"
						id="titulo"
						placeholder="Titulo de la receta"
					>
				</div>
			</div>
			<div class="form-group row">
				<div class="text-center col-sm-12">
					<button
						type="submit"
						class="btn btn-primary"
					>Agregar receta</button>
				</div>
			</div>
		</form>
	</div>
@endsection
