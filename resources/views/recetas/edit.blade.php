@extends('layouts.app')

@section('styles')
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
		integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"
	/>
@endsection

@section('botones')
	<a
		href="{{ route('recetas.index') }}"
		class="btn btn-primary"
	>
		<i class="fa fa-arrow-left"></i> Volver
	</a>
@endsection

@section('content')
	<h2 class="h2 text-center">Editar receta</h2>

	<div class="container">
		<form
			method="POST"
			action="{{ route('recetas.update', ['receta' => $receta->id]) }}"
			novalidate
			enctype="multipart/form-data"
		>
			@csrf
			@method('PUT')
			<div class="form-group row">
				<label
					for="titulo"
					class="col-sm-12 col-form-label"
				>Titulo</label>
				<div class="col-sm-12">
					<input
						type="text"
						class="form-control @error('titulo') is-invalid @enderror"
						name="titulo"
						id="titulo"
						placeholder="Titulo de la receta"
						value="{{ old('titulo') ?? $receta->titulo }}"
					>
					@error('titulo')
						<div
							class="invalid-feedback"
							role="alert"
						>
							<strong>{{ $message }}</strong>
						</div>
					@enderror
				</div>
			</div>
			<div class="form-group">
				<label for="categoria">Categoría</label>
				<select
					class="custom-select @error('categoria') is-invalid @enderror"
					name="categoria"
					id="categoria"
				>
					<option>Seleccione</option>
					@foreach ($categorias as $categoria)
						<option
							value="{{ $categoria->id }}"
							{{ old('categoria') ?? $receta->categoria_id == $categoria->id ? 'selected' : '' }}
						>{{ $categoria->nombre }}</option>
					@endforeach
				</select>
				@error('categoria')
					<div
						class="invalid-feedback"
						role="alert"
					>
						<strong>{{ $message }}</strong>
					</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="preparacion">Preparación</label>
				<input
					id="preparacion"
					type="hidden"
					name="preparacion"
					value="{{ old('preparacion') ?? $receta->preparacion }}"
				>
				<trix-editor
					input="preparacion"
					class="form-control h-auto @error('preparacion') is-invalid @enderror"
					placeholder="Preparación de la receta ..."
				></trix-editor>
				@error('preparacion')
					<div
						class="invalid-feedback"
						role="alert"
					>
						<strong>{{ $message }}</strong>
					</div>
				@enderror
			</div>
			<div class="form-group">
				<label for="ingredientes">Ingredientes</label>
				<input
					id="ingredientes"
					type="hidden"
					name="ingredientes"
					value="{{ old('ingredientes') ?? $receta->ingredientes }}"
				>
				<trix-editor
					input="ingredientes"
					class="form-control h-auto @error('ingredientes') is-invalid @enderror"
					placeholder="Ingredientes de la receta ..."
				></trix-editor>
				@error('ingredientes')
					<div
						class="invalid-feedback"
						role="alert"
					>
						<strong>{{ $message }}</strong>
					</div>
				@enderror
			</div>
			<p>
				Imagen anterior:
				<br>
				<img
					src="{{ asset('storage/' . $receta->imagen) }}"
					alt="{{ $receta->titulo }}"
					class="img-thumbnail"
					width="200"
				>
			</p>
			<div class="form-group">
				<label for="imagen">Imagenes ilustrativas</label>
				<input
					type="file"
					class="form-control-file @error('imagen') is-invalid @enderror"
					name="imagen"
					id="imagen"
					placeholder="Seleccione algunas imagenes"
					aria-describedby="fileHelpId"
				>
				<small
					id="fileHelpId"
					class="form-text text-muted"
				>Seleccione una o varias imagenes</small>
				@error('imagen')
					<div
						class="invalid-feedback"
						role="alert"
					>
						<strong>{{ $message }}</strong>
					</div>
				@enderror
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

@section('scripts')
	<script
	 src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
	 integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
	 crossorigin="anonymous"
	 referrerpolicy="no-referrer"
	 defer
	></script>
@endsection
