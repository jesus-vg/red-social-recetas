<template>
	<div class="wrapper-gallery pt-5">
		<div class="gallery">
			<!-- Recorremos las categorias-->
			<template v-for="{ categoria, data } in dataRecetas">
				<article class="gallery__item">
					<div class="hexa text-white bg-primary">
						<h2>{{ categoria }}</h2>
					</div>
				</article>
				<template v-for="receta in data">
					<article class="gallery__item">
						<div
							class="hexa"
							:style="{ backgroundColor: `rgb(${receta.color})` }"
						>
							<img
								:data-src="'./storage/' + receta.imagen"
								class="lazyload blur-up"
								:alt="receta.titulo"
							/>
							<div class="mask"></div>
							<div class="gallery__item__details text-white">
								<h3 class="h3 gallery__item__titulo">
									{{ receta.titulo }}
								</h3>
								<div class="font-italic">
									<small>
										<fecha-receta
											:fecha="receta.created_at"
										></fecha-receta>
									</small>
								</div>

								<p class="gallery__item__body">
									{{ receta.preparacion }}
								</p>
								<div class="gallery__item__footer">
									<a
										:href="'recetas/' + receta.id"
										class="btn btn-primary"
										>Ver</a
									>
									<span style="align-self: center">
										<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
										<svg
											version="1.1"
											id="Layer_1"
											xmlns="http://www.w3.org/2000/svg"
											xmlns:xlink="http://www.w3.org/1999/xlink"
											x="0px"
											y="0px"
											width="24"
											height="24"
											viewBox="0 0 512 512"
											style="
												enable-background: new 0 0 512
													512;
											"
											xml:space="preserve"
										>
											<path
												style="fill: #ff6647"
												d="M474.655,74.503C449.169,45.72,413.943,29.87,375.467,29.87c-30.225,0-58.5,12.299-81.767,35.566
	c-15.522,15.523-28.33,35.26-37.699,57.931c-9.371-22.671-22.177-42.407-37.699-57.931c-23.267-23.267-51.542-35.566-81.767-35.566
	c-38.477,0-73.702,15.851-99.188,44.634C13.612,101.305,0,137.911,0,174.936c0,44.458,13.452,88.335,39.981,130.418
	c21.009,33.324,50.227,65.585,86.845,95.889c62.046,51.348,123.114,78.995,125.683,80.146c2.203,0.988,4.779,0.988,6.981,0
	c2.57-1.151,63.637-28.798,125.683-80.146c36.618-30.304,65.836-62.565,86.845-95.889C498.548,263.271,512,219.394,512,174.936
	C512,137.911,498.388,101.305,474.655,74.503z"
											/>
											<path
												style="fill: #e35336"
												d="M160.959,401.243c-36.618-30.304-65.836-62.565-86.845-95.889
	c-26.529-42.083-39.981-85.961-39.981-130.418c0-37.025,13.612-73.631,37.345-100.433c21.44-24.213,49.775-39.271,81.138-43.443
	c-5.286-0.786-10.653-1.189-16.082-1.189c-38.477,0-73.702,15.851-99.188,44.634C13.612,101.305,0,137.911,0,174.936
	c0,44.458,13.452,88.335,39.981,130.418c21.009,33.324,50.227,65.585,86.845,95.889c62.046,51.348,123.114,78.995,125.683,80.146
	c2.203,0.988,4.779,0.988,6.981,0c0.689-0.308,5.586-2.524,13.577-6.588C251.254,463.709,206.371,438.825,160.959,401.243z"
											/>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
											<g></g>
										</svg>

										{{ getTotalLikes(receta.total_likes) }}
									</span>
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
			default: [],
		},
		categoria: {
			type: String,
			default: "Sin definir...",
		},
	},
	components: {
		fechaReceta: FechaReceta,
	},
	data() {
		return {
			dataRecetas: JSON.parse(this.recetas),
		};
	},
	methods: {
		/**
		 * Obtener los likes de la receta, si no hay likes devuelve 0.
		 * devolvera 1k likes si hay 1000 likes o más y así sucesivamente
		 * @returns {string} string con el formato de likes, 1k, 1.5k, etc
		 */
		getTotalLikes(totalLikes = "0") {
			if (totalLikes < 1_000) {
				return totalLikes;
			} else if (totalLikes >= 1_000 && totalLikes < 1_000_000) {
				return `${(totalLikes / 1_000).toFixed(1)}k`;
			} else if (totalLikes >= 1_000_000) {
				return `${(totalLikes / 1_000_000).toFixed(1)}M`;
			}
		},
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
		// console.log(this.dataRecetas)
	},
};
</script>
