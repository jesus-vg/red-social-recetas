<template>
	<button type="button" class="btn btn-danger btn-sm" @click="eliminarReceta">
		Delete
	</button>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";

export default Vue.extend({
	props: ["recetaId", "recetaTitulo"],
	methods: {
		eliminarReceta() {
			// show a modal with vue sweetalert2
			this.$swal({
				title: "Eliminar receta",
				html: `¿Estás seguro de eliminar la receta <strong>${this.recetaTitulo}</strong>?`,
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Eliminar",
				cancelButtonText: "Cancelar",
			}).then((result) => {
				if (result.isConfirmed) {
					this.$swal({
						title: "Eliminando receta",
						html: `Eliminando la receta <strong>${this.recetaTitulo}</strong>...`,
						icon: "info",
						showConfirmButton: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						allowOutsideClick: false,
					});
					this.$swal.showLoading();

					// send axios request to delete the recipe
					const params = {
						id: this.recetaId,
					};
					axios
						.post(`/recetas/${this.recetaId}`, {
							params,
							_method: "DELETE",
						})
						.then((response) => {
							// console.log(response);

							this.$swal.hideLoading();
							this.$swal.close();
							this.$swal({
								title: "Receta eliminada",
								html: `La receta <strong>${this.recetaTitulo}</strong> ha sido eliminada correctamente.`,
								icon: "success",
								showConfirmButton: false,
							});

							// remove the recipe from the DOM
							this.$el.parentNode.parentNode.parentNode.removeChild(
								this.$el.parentNode.parentNode
							);
						})
						.catch((error) => {
							this.$swal.hideLoading();
							this.$swal.close();
							this.$swal({
								title: "Error al eliminar receta",
								html: `Ha ocurrido un error al eliminar la receta <strong>${this.recetaTitulo}</strong>.<br>
													<br>
													<strong>Error:</strong> ${error.response.data.error}`,
								icon: "error",
								showConfirmButton: false,
							});
						});
				}
			});
		},
	},
});
</script>

<style></style>
