<template>
	<div class="wrapper-gallery pt-5">
		<div class="gallery">
			<!-- Recorremos las categorias-->
			<template v-for="{categoria, data} in dataRecetas">
				<article class="gallery__item">
					<div class="hexa text-white bg-primary">
						<h2>{{ categoria }}</h2>
					</div>
				</article>
				<template v-for="receta in data">
					<article class="gallery__item">
						<div class="hexa"
							 :style="{ backgroundColor: `rgb(${receta.color})` }">

							<img :data-src="'/storage/'+receta.imagen" class="lazyload blur-up" :alt="receta.titulo">
							<div class="mask"></div>
							<div class="gallery__item__details text-white">
								<h3 class="h3 gallery__item__titulo">
									{{ receta.titulo }}

								</h3>
								<div class="font-italic">
									<small>
										<fecha-receta :fecha="receta.created_at"></fecha-receta>
									</small>
								</div>

								<p class="gallery__item__body">
									{{ receta.preparacion }}
								</p>
								<div class="gallery__item__footer">
									<a href="#" class="btn btn-primary">Ver</a>
								</div>

							</div>
						</div>


					</article>
				</template>
			</template>


		</div>
	</div>
</template>

<script>

import FechaReceta from "./FechaReceta";

export default {
	props: {
		recetas: {
			type: String,
			required: true,
			default: []
		},
		categoria: {
			type: String,
			default: "Sin definir..."
		}
	},
	components: {
		fechaReceta: FechaReceta
	},
	data() {
		return {
			dataRecetas: JSON.parse(this.recetas)
		}
	},
	mounted() {
		// mostrar la preparacion de la receta como cadena y traducir codigos por ej. &nbsp; por su quivalente en html

		this.dataRecetas.forEach((categoria) => {
			categoria.data.forEach((receta) => {
				receta.preparacion = receta.preparacion
					.replace(/&nbsp;/g, " ") // &nbsp; -> " "
					.replace(/&amp;/g, "&") // &amp; -> "&"
					.replace(/&quot;/g, '"') // &quot; -> '"'
					.replace(/&lt;/g, "<") // &lt; -> "<"
					.replace(/&gt;/g, ">"); // &gt; -> ">"
			});
		});
		console.log(this.dataRecetas)

	}
}
</script>
