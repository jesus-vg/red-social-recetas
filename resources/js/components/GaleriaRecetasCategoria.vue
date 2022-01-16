<template>
	<div class="wrapper-gallery pt-5">
		<h2>{{ categoria }}</h2>
		<div class="gallery">
			<article class="gallery__item" v-for="receta in dataRecetas">
				<div class="hexa"
					 :style="{ backgroundColor: `rgb(${receta.color})` }">

					<img :data-src="'/storage/'+receta.imagen" class="lazyload " :alt="receta.titulo">
					<div class="gallery__item__details text-white">
						<h3 class="h3 gallery__item__titulo">
							{{ receta.titulo }}
						</h3>

						<p class="gallery__item__body">
							{{ receta.preparacion }}
						</p>
						<div class="gallery__item__footer">
							<a href="#" class="btn btn-primary">Ver</a>
						</div>

					</div>
				</div>


			</article>
		</div>
	</div>
</template>

<script>
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
	data() {
		return {
			dataRecetas: JSON.parse(this.recetas)
		}
	},
	mounted() {
		// mostrar la preparacion de la receta como cadena y traducir codigos por ej. &nbsp; por su quivalente en html
		this.dataRecetas.forEach((receta) => {
			receta.preparacion = receta.preparacion
				.replace(/&nbsp;/g, " ") // &nbsp; -> " "
				.replace(/&amp;/g, "&") // &amp; -> "&"
				.replace(/&quot;/g, '"') // &quot; -> '"'
				.replace(/&lt;/g, "<") // &lt; -> "<"
				.replace(/&gt;/g, ">"); // &gt; -> ">"
		});
	}
}
</script>

<style scoped>

</style>