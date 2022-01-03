<template>
	<div class="recetas-scroll-infinito">
		<div class="recetas-scroll-infinito__contenedor">
			<!-- mostrar el total de recetas creadas del usuario -->
			<div class="recetas-scroll-infinito__total">
				<span>
					<i class="fas fa-utensils"></i>
					<span>{{ totalRecetas }}</span>
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
		</div>
	</div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import MagicGrid from "magic-grid";

export default Vue.extend({
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
			primeraPagina: 1,
			myMagicGrid: null,
		};
	},
	methods: {
		obtenerRecetas() {
			// obtener las recetas del usuario
			axios
				.get(
					`/recetas/usuario/${this.idUsuario}?pagina=${this.paginaActual}`
				)
				.then(({ data }) => {
					console.log(data);

					this.recetas = data.data;
					this.colores = data.colores;
					this.totalRecetas = data.total;
					this.ultimaPagina = data.last_page;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		cambiarPagina(pagina) {
			this.paginaActual = pagina;
			this.obtenerRecetas();
		},
		cambiarPaginaAnterior() {
			if (this.paginaActual > 1) {
				this.paginaActual--;
				this.obtenerRecetas();
			}
		},
		cambiarPaginaSiguiente() {
			if (this.paginaActual < this.ultimaPagina) {
				this.paginaActual++;
				this.obtenerRecetas();
			}
		},
		initMagicGrid() {
			this.myMagicGrid = new MagicGrid({
				container: ".recetas-scroll-infinito__contenido",
				items: 5,
				gutter: 20,
				maxWidth: "100%",
				animate: true,
				center: true,
			});
			this.myMagicGrid.listen();
		},
	},
	mounted() {
		console.log("mounted");
		this.initMagicGrid();
		this.obtenerRecetas();

		document.addEventListener("lazyloaded", (e) => {
			// console.log("lazyloaded", e);
			this.myMagicGrid.positionItems();
		});
	},
});

// {
// current_page: 1
// data: (5) [{…}, {…}, {…}, {…}, {…}]
// first_page_url: "http://localhost:8000/recetas/usuario/3?page=1"
// from: 1
// last_page: 2
// last_page_url: "http://localhost:8000/recetas/usuario/3?page=2"
// links: (4) [{…}, {…}, {…}, {…}]
// next_page_url: "http://localhost:8000/recetas/usuario/3?page=2"
// path: "http://localhost:8000/recetas/usuario/3"
// per_page: 5
// prev_page_url: null
// to: 5
// total: 6
// 	}
</script>

<style scoped>
.img-receta {
	max-width: 300px;
	height: 180px;
}
.card {
	width: 300px;
}
</style>
