<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1"
	>

	<!-- CSRF Token -->
	<meta
		name="csrf-token"
		content="{{ csrf_token() }}"
	>

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<script
	 src="{{ asset('js/app.js') }}"
	 defer
	></script>

	<!-- Fonts -->
	<link
		rel="dns-prefetch"
		href="//fonts.gstatic.com"
	>
	<link
		href="https://fonts.googleapis.com/css?family=Nunito"
		rel="stylesheet"
	>

	<!-- Styles -->
	<link
		href="{{ asset('css/app.css') }}"
		rel="stylesheet"
	>

	@yield('styles')


</head>

<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
			<div class="container">
				<a
					class="navbar-brand navbar-title"
					href="{{ url('/') }}"
				>
					{{ config('app.name', 'Laravel') }}
				</a>
				<button
					class="navbar-toggler"
					type="button"
					data-toggle="collapse"
					data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent"
					aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}"
				>
					<span class="navbar-toggler-icon"></span>
				</button>

				<div
					class="collapse navbar-collapse"
					id="navbarSupportedContent"
				>
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto"></ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Authentication Links -->
						@guest
							@if (Route::has('login'))
								<li class="nav-item">
									<a
										class="nav-link"
										href="{{ route('login') }}"
									>{{ __('Login') }}</a>
								</li>
							@endif

							@if (Route::has('register'))
								<li class="nav-item">
									<a
										class="nav-link"
										href="{{ route('register') }}"
									>{{ __('Register') }}</a>
								</li>
							@endif
						@else
							<li class="nav-item">
								<avatar
									username="{{ Auth::user()->name }}"
									src="{{ Storage::url(Auth::user()->profile->imagen) }}"
								></avatar>
							</li>
							<li class="nav-item dropdown">
								<a
									id="navbarDropdown"
									class="nav-link dropdown-toggle"
									href="#"
									role="button"
									data-toggle="dropdown"
									aria-haspopup="true"
									aria-expanded="false"
									v-pre
								>
									{{ Auth::user()->name }}
								</a>

								<div
									class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdown"
								>
									<a
										class="dropdown-item"
										href="{{ route('profile.show', Auth::user()->id) }}"
									>
										{{ __('Profile') }}
									</a>

									<a
										class="dropdown-item"
										href="{{ route('recetas.index') }}"
									>
										{{ __('Recipes') }}
									</a>

									<a
										class="dropdown-item"
										href="{{ route('logout') }}"
										onclick="event.preventDefault();document.getElementById('logout-form').submit();"
									>
										{{ __('Logout') }}
									</a>

									<form
										id="logout-form"
										action="{{ route('logout') }}"
										method="POST"
										class="d-none"
									>
										@csrf
									</form>
								</div>
							</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>

		{{-- mostramos las categorias mediante el service provider --}}
		<nav class="navbar navbar-expand-md navbar-light categorias-bg">
			<div class="container">
				<button
					class="navbar-toggler"
					type="button"
					data-toggle="collapse"
					data-target="#categorias"
					aria-controls="categorias"
					aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}"
				>
					<span class="navbar-toggler-icon"></span>
					Categorias
				</button>
				<div
					class="collapse navbar-collapse "
					id="categorias"
				>
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav w-100 d-flex justify-content-between">
						@foreach ($categorias as $categoria)
							<li class="nav-item">
								<a
									class="nav-link"
									href="{{ route('categorias.show', ['categoria' => $categoria->id]) }}"
								>
									{{ $categoria->nombre }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</nav>

		@yield('hero')

		<div class="container my-4">

			<div class="">
				@yield('botones')
			</div>
			<main class="my-5">
				@yield('content')
			</main>
		</div>
	</div>

	@yield('scripts')
</body>

</html>
