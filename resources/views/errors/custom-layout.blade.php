<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0"
	>
	<meta
		http-equiv="X-UA-Compatible"
		content="ie=edge"
	>
	<title>@yield('title')</title>

	{{-- cdn normalize.css --}}
	<link
		href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
		rel="stylesheet"
		integrity="sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU="
		crossorigin="anonymous"
	/>

	{{-- google fonts --}}
	<link
		href="https://fonts.googleapis.com/css?family=Roboto:400,300,700,900"
		rel="stylesheet"
	/>

	{{-- style --}}
	<style>
		html,
		body {
			height: 100%;
			width: 100%;
			background: linear-gradient(0, #202239, #8595ac);
		}

		::selection {
			background: #cdd4de;
		}

		body,
		.wrapper__content {
			display: flex;
			align-items: center;
			justify-content: center;
			color: rgba(255, 255, 255, 0.9);
		}

		.wrapper,
		.wrapper__content {
			width: 100%;
			height: 100%;
		}

		.wrapper {
			max-width: 700px;
			max-height: 600px;
			margin: 0.5rem;
			border-radius: 0.5rem;
			overflow: hidden;
			position: relative;
			font-family: Roboto, sans-serif;
		}

		.wrapper__background,
		.wrapper__content {
			position: absolute;
		}

		.wrapper__background {
			top: 0;
			left: 0;
			width: 100%;
			transform: scale(1.1);
		}

		.wrapper__background img {
			height: 600px;
			filter: brightness(0.7);
		}

		.wrapper__content {
			flex-direction: column;
		}

		.wrapper__content h1 {
			font-weight: 900;
			font-size: 7rem;
			line-height: 1;
			margin-bottom: -10px;
		}

		h2 {
			font-weight: 700;
			font-size: 2rem;
			margin-bottom: 6px;
			opacity: 0.9;
		}

		p {
			font-weight: 300;
			font-size: 2rem;
		}

		a {
			font-weight: 300;
			font-size: 12px;
			text-transform: uppercase;
			border: 1px solid #cdd4de;
			padding: 8px 14px;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			color: inherit;
			transition: opacity 0.5s, border 0.7s;
		}

	</style>
</head>

<body>

	<div class="wrapper">
		<div class="wrapper__background">
			<img src="{{ asset('images/hero-search.jpg') }}" />
		</div>

		<div class="wrapper__content">
			<h1>@yield('code')</h1>
			<p>@yield('message')</p>
			<a href="{{ url('/') }}">Ir al inicio</a>
		</div>
	</div>

</body>

<script>
 const img = document.querySelector(".wrapper__background");
 let lFollowX = 0,
  lFollowY = 0,
  x = 0,
  y = 0,
  friction = 2.5 / 30;

 const animate = () => {

  x += (lFollowX - x) * friction;
  y += (lFollowY - y) * friction;

  translate = "translate(" + x + "px, " + y + "px) scale(1.1)";

  img.style.transform = translate;

  window.requestAnimationFrame(animate);
 }

 window.addEventListener("mousemove", (e) => {

  const width = window.innerWidth;
  const height = window.innerHeight;
  let lMouseX = Math.max(-100, Math.min(100, width / 2 - e.clientX));
  let lMouseY = Math.max(-100, Math.min(100, height / 2 - e.clientY));
  lFollowX = (20 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
  lFollowY = (10 * lMouseY) / 100;


 });

 animate();
</script>

</html>
