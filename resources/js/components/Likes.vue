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
		isRegistered: {
			type: Boolean,
			default: false,
			required: true,
		},
	},
	data() {
		return {
			isLiked: this.liked,
			totalLikesReceta: this.totalLikes,
		};
	},
	methods: {
		like() {
			if (this.isRegistered) {
				this.isLiked = !this.isLiked;
				this.totalLikesReceta += this.isLiked ? 1 : -1;
				this.likePost();
			} else {
				// redirect to login
				goToLogin();
			}
		},
		likePost() {
			axios
				.post(`/recetas/likes/${this.idReceta}`)
				.then((response) => {})
				.catch((error) => {
					this.isLiked = !this.isLiked;
				});
		},
		goToLogin() {
			window.location.href = "/login";
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
