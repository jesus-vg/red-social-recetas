<template>
	<div class="like-wrapper my-4">
		<a class="like-button" @click="like" :class="{ liked: isLiked }">
			<span class="like-icon">
				<div class="heart-animation-1"></div>
				<div class="heart-animation-2"></div>
			</span>
			{{ getTotalLikes }} Me gusta
		</a>
	</div>
</template>

<script>
import Vue from "vue";

export default Vue.extend({
	props: {
		liked: {
			type: Boolean,
			default: false,
			required: true,
		},
		totalLikes: {
			type: Number,
			default: 0,
			required: true,
		},
		idReceta: {
			type: Number,
			required: true,
		},
	},
	data() {
		return {
			isLiked: this.liked,
			totalLikesReceta: this.totalLikes,
			btnActive: false,
		};
	},
	methods: {
		like() {
			// evitar que se pueda dar like más de una vez btnActive
			if (this.btnActive) {
				return;
			}
			this.btnActive = true;
			// envia el like a la api
			axios
				.post(`/recetas/likes/${this.idReceta}`)
				.then(({ data }) => {
					// console.log(data); // attached: [6] detached: []

					if (data.attached.length > 0) {
						// attached = El like se ha registrado en la base de datos
						this.totalLikesReceta++;
					} else {
						// detached = El like se ha eliminado de la base de datos
						this.totalLikesReceta--;
					}
					this.isLiked = !this.isLiked;
				})
				.catch((error) => {
					// console.log(error);
					// validamos si el error es de tipo 401 (no autorizado)
					if (error.response.status === 401) {
						// si es 401, redireccionamos al login
						window.location.href = "/login";
					}
				})
				.finally(() => {
					this.btnActive = false;
				});
		},
	},
	computed: {
		/**
		 * Obtener los likes de la receta, si no hay likes devuelve 0.
		 * devolvera 1k likes si hay 1000 likes o más y así sucesivamente
		 * @returns {string} string con el formato de likes, 1k, 1.5k, etc
		 */
		getTotalLikes() {
			const totalLikes = this.totalLikesReceta;
			if (totalLikes < 1_000) {
				return totalLikes;
			} else if (totalLikes >= 1_000 && totalLikes < 1_000_000) {
				return `${(totalLikes / 1_000).toFixed(1)}k`;
			} else if (totalLikes >= 1_000_000) {
				return `${(totalLikes / 1_000_000).toFixed(1)}M`;
			}
		},
	},
});
</script>
