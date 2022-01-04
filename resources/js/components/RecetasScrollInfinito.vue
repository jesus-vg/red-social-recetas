<template>
	<div class="recetas-scroll-infinito">
		<div class="recetas-scroll-infinito__contenedor">
			<!-- mostrar el total de recetas creadas del usuario -->
			<div
				class="recetas-scroll-infinito__total text-primary text-center h4"
			>
				<span>
					<i class="fas fa-utensils"></i>
					<span>{{ totalRecetas }} recetas</span>
				</span>
			</div>
			<div class="recetas-scroll-infinito__contenido">
				<!-- mostrar las recetas en cards de bootstrap -->
				<div class="card" v-for="(receta, i) in recetas" :key="i">
					<div
						class="img"
						:style="{ backgroundColor: `rgb(${colores[i]})` }"
					>
						<img
							class="card-img-top img-receta lazyload blur-up"
							alt="Card image cap"
							:data-src="'/storage/' + receta.imagen"
						/>
					</div>

					<div class="card-body">
						<h5 class="card-title">
							{{ receta.titulo }}
						</h5>
						<a
							:href="`/recetas/${receta.id}`"
							class="btn btn-primary"
						>
							Ver receta
						</a>
					</div>
				</div>
			</div>
			<loader v-if="cargando" mensaje="Cargando recetas..."></loader>
			<div
				class="text-center h4 my-5"
				v-if="!cargando && paginaActual === ultimaPagina"
			>
				... ya no hay más recetas para mostrar
			</div>
		</div>
	</div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import MagicGrid from "magic-grid";
import Loader from "./Loader";

export default Vue.extend({
	components: {
		loader: Loader,
	},
	props: {
		idUsuario: {
			type: Number,
			required: true,
		},
	},
	data() {
		return {
			totalRecetas: 0,
			recetas: [],
			colores: [],
			paginaActual: 1,
			ultimaPagina: 1,
			myMagicGrid: null,
			cargando: true,
		};
	},
	methods: {
		obtenerRecetas() {
			this.cargando = true;
			// obtener las recetas del usuario
			axios
				.get(
					`/recetas/usuario/${this.idUsuario}?pagina=${this.paginaActual}`
				)
				.then(({ data }) => {
					this.recetas.push(...data.data); // agregar las recetas al final de la lista
					this.colores.push(...data.colores); // agregar el color promedio de cada receta al final de la lista
					this.totalRecetas = data.total;
					this.ultimaPagina = data.last_page;
				})
				.catch((error) => {
					console.log(error);
				})
				.finally(() => {
					// quitamos el loader de carga haya o no habido errores
					this.cargando = false;
				});
		},
		initMagicGrid() {
			this.myMagicGrid = new MagicGrid({
				container: ".recetas-scroll-infinito__contenido",
				items: 1,
				gutter: 20,
				maxWidth: "100%",
				animate: true,
				center: true,
			});
			this.myMagicGrid.listen();
		},
		initScrollInifito() {
			window.addEventListener("scroll", () => {
				if (
					window.innerHeight + window.scrollY >=
					document.body.offsetHeight - 500
				) {
					if (this.paginaActual < this.ultimaPagina) {
						this.paginaActual++;
						this.obtenerRecetas();
					}
				}
			});
		},
	},
	mounted() {
		// console.log("mounted");
		this.initMagicGrid();
		this.obtenerRecetas();

		// disparar un evento por cada imagen cargada para que magic grid sepa que hay que hacer
		document.addEventListener("lazyloaded", (e) => {
			this.myMagicGrid.positionItems(); // reposicionar los items
		});

		// iniciar el scroll infinito
		this.initScrollInifito();
	},
});

// reques.data = {
//	 current_page: 1
//	 data: (5) [{…}, {…}, {…}, {…}, {…}]
//	 first_page_url: "http://localhost:8000/recetas/usuario/3?page=1"
//	 from: 1
//	 last_page: 2
//	 last_page_url: "http://localhost:8000/recetas/usuario/3?page=2"
//	 links: (4) [{…}, {…}, {…}, {…}]
//	 next_page_url: "http://localhost:8000/recetas/usuario/3?page=2"
//	 path: "http://localhost:8000/recetas/usuario/3"
//	 per_page: 5
//	 prev_page_url: null
//	 to: 5
//	 total: 6
// 	}
</script>

<style scoped>
.recetas-scroll-infinito,
.recetas-scroll-infinito__total {
	margin: 1rem 0;
}
.img,
.img-receta {
	max-width: 300px;
	height: 180px;
	border-radius: 0.3rem;
	user-select: none;
	pointer-events: none;
}
.card {
	width: 300px;
}
</style>
