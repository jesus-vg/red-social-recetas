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
	<h1 class="h1 text-center">
		Editar perfil
	</h1>
	{{-- {{ $perfil }} --}}
	{{-- {{ $perfil->user }} --}}
	<div class="row">
		<div class="col-12">
			<form
				action="{{ route('profile.update', ['perfil' => $perfil->user->id]) }}"
				method="POST"
				enctype="multipart/form-data"
			>
				@csrf
				@method('PUT')

				<div class="form-group">
					<label for="name">Nombre</label>
					<input
						type="text"
						name="name"
						id="name"
						class="form-control @error('name') is-invalid @enderror"
						value="{{ old('name', $perfil->user->name) }}"
						placeholder="Tu nombre"
					>
					@error('name')
						<span
							class="invalid-feedback"
							role="alert"
						>
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>

				{{-- edit web site --}}
				<div class="form-group">
					<label for="url">Sitio web</label>
					<input
						type="text"
						name="url"
						id="url"
						class="form-control @error('url') is-invalid @enderror"
						value="{{ old('url', $perfil->user->url) }}"
						placeholder="Tu sitio web"
					>
					@error('url')
						<span
							class="invalid-feedback"
							role="alert"
						>
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>

				{{-- edit biografia --}}
				<div class="form-group">
					<label for="biografia">Biografía</label>
					<input
						type="hidden"
						id="biografia"
						name="biografia"
						value="{{ old('biografia', $perfil->biografia) }}"
					>
					<trix-editor
						input="biografia"
						class="form-control h-auto @error('biografia') is-invalid @enderror"
						placeholder="Tu biografía ..."
					></trix-editor>
					@error('biografia')
						<div
							class="invalid-feedback"
							role="alert"
						>
							<strong>{{ $message }}</strong>
						</div>
					@enderror
				</div>

				{{-- edit imagen --}}
				<div class="form-group">
					<label for="imagen">Imagen</label>
					<input
						type="file"
						name="imagen"
						id="imagen"
						class="form-control-file @error('imagen') is-invalid @enderror"
					>
					@error('imagen')
						<span
							class="invalid-feedback"
							role="alert"
						>
							<strong>{{ $message }}</strong>
						</span>
					@enderror

					{{-- show if old imagen exist --}}
					@if ($perfil->imagen)
						<div class="mt-3">
							<img
								src="{{ Storage::url($perfil->imagen) }}"
								class="img-fluid"
								alt="{{ $perfil->user->name }}"
							>
						</div>
					@endif
				</div>

				<div class="form-group">
					<button
						type="submit"
						class="btn btn-primary"
					>
						Guardar
					</button>
				</div>
			</form>
		</div>
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
