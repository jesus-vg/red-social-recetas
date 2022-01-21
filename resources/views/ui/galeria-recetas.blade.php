<div class="gallery-flex">

	@foreach ($recetas as $receta)
		<div class="gallery-flex__item">
			<div class="gallery-flex__item--header">
				<img
					data-src="{{ asset('storage/' . $receta['imagen']) }}"
					class="lazyload"
					alt="{{ $receta['titulo'] }}"
				>
			</div>
			<div class="gallery-flex__item--body">
				<h3>{{ $receta['titulo'] }}</h3>
				<div class="d-flex justify-content-between my-2">
					<div class="text-primary">
						<fecha-receta fecha="{{ $receta['created_at'] }}"></fecha-receta>
					</div>
					<div class="likes-receta">
						{{ $receta['likes_count'] }} Les gustó
					</div>
				</div>
				<p>
					{{ html_entity_decode($receta['preparacion']) }}
				</p>
			</div>
			<div class="gallery-flex__item--footer">
				<a
					href="{{ route('recetas.show', ['receta' => $receta['id']]) }}"
					class="btn btn-primary"
				>Ver</a>
			</div>
		</div>
	@endforeach
</div>
