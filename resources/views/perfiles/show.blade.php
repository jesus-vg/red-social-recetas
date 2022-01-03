@extends('layouts.app')


@section('botones')
	<a
		href="{{ route('profile.edit', ['perfil' => $perfil->id]) }}"
		class="btn btn-primary"
	>
		<i class="fa fa-arrow-left"></i> Editar
	</a>
@endsection

@section('content')
	{{-- {{ $perfil }} --}}
	{{-- {{ $perfil->user->recipes }} --}}
	{{-- {{ $perfil->user }} --}}
	<h2 class="h2 text-center mb-2 text-primary">
		{{ $perfil->user->name }}
	</h2>

	<div class="text-center mb-3 mt-2">
		<a
			href="{{ $perfil->user->url }}"
			target="_blank"
		>
			Visitar sitio web
		</a>
	</div>

	<div class="biografia">
		@if ($perfil->imagen)
			<div class="row">
				<div class="col-12 col-md-4">
					<img
						data-src="{{ asset('storage/' . $perfil->imagen) }}"
						class="img-fluid lazyload"
						alt="{{ $perfil->user->name }}"
					>
				</div>

				<div class="col-12 col-md-8">
					{!! $perfil->biografia !!}
				</div>
			</div>
		@else
			{!! $perfil->biografia !!}
		@endif
	</div>

	<div class="recetas-creadas">
		{{-- mostrar carrusel para las recetas creadas por el usuario --}}
		<h3 class="h3 text-center mb-3 text-primary">
			Recetas creadas por {{ $perfil->user->name }}
		</h3>
		<recetas-scroll-infinito :id-usuario="{{ $perfil->id }}"></recetas-scroll-infinito>
	</div>
@endsection
