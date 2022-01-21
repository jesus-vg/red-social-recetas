<template>
	<div class="splide">
		<div class="splide__track">
			<ul class="splide__list">
				<li
					class="splide__slide"
					v-for="(receta, i) in recetas"
					:key="i"
				>
					<div class="item">
						<div
							class="item__image"
							:style="{ backgroundColor: `rgb(${receta.color})` }"
						>
							<img
								:data-src="'/storage/' + receta.imagen"
								class="img-fluid lazyload blur-up"
								:alt="receta.titulo"
							/>
						</div>

						<div class="item__content text-center">
							<h3 class="item__title">
								{{ receta.titulo }}
							</h3>
							<p class="item__description">
								{{ receta.preparacion }}
							</p>
							<div class="">
								<a
									class="btn btn-primary"
									:href="'/recetas/' + receta.id"
								>
									Ver receta
								</a>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="splide__progress">
			<div class="splide__progress__bar"></div>
		</div>
	</div>
</template>

<script>
import Vue from "vue";
import Splide from "@splidejs/splide";

export default Vue.extend({
	props: {
		data: {
			type: String,
			required: true,
		},
	},
	data() {
		return {
			recetas: JSON.parse(this.data),
		};
	},
	mounted() {
		// console.log(this.recetas);

		// mostrar la preparacion de la receta como cadena y traducir codigos por ej. &nbsp; por su quivalente en html
		this.recetas.forEach((receta) => {
			receta.preparacion = receta.preparacion
				.replace(/&nbsp;/g, " ") // &nbsp; -> " "
				.replace(/&amp;/g, "&") // &amp; -> "&"
				.replace(/&quot;/g, '"') // &quot; -> '"'
				.replace(/&lt;/g, "<") // &lt; -> "<"
				.replace(/&gt;/g, ">"); // &gt; -> ">"
		});

		const splide = new Splide(".splide", {
			type: "loop",
			drag: "free",
			focus: "center",
			arrows: "slider",
			gap: "1rem",
			perPage: 1,
			rewind: true,
			autoplay: true,
			breakpoints: {
				991: {
					arrows: false,
				},
			},
		});

		splide.mount();
	},
	methods: {},
});
</script>

<style></style>
