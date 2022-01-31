@extends('layouts.app')

@section('styles')

	<style>
		.img {
			filter: drop-shadow(2px 4px 6px black);
		}

	</style>
@endsection

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-4 d-none d-sm-block">
			<img
				src="{{ asset('images/chef.png') }}"
				class="img-fluid img my-5"
				alt="error 404"
			>
		</div>
		<div class="col-md-6 order-first order-sm-last text-center">
			<div class="wrapper__content h-100 d-flex justify-content-center align-items-center flex-column">
				<h1 class="display-2">@yield('code')</h1>
				<p class="lead">@yield('message')</p>
				<hr class="my-4 w-50">
				<a
					href="{{ url('/') }}"
					class="btn btn-primary"
				>Ir al inicio</a>
			</div>
		</div>
	</div>
@endsection
