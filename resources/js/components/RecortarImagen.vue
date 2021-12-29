<template>
	<div>
		<!-- Button trigger modal -->
		<button
			type="button"
			class="btn btn-primary"
			data-toggle="modal"
			data-target="#modal-recortar-imagen"
		>
			Subir imagen
		</button>

		<!-- Modal -->
		<div
			class="modal fade"
			id="modal-recortar-imagen"
			tabindex="-1"
			aria-labelledby="exampleModalLabel"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">
							Recortar imagen
						</h5>
						<button
							type="button"
							class="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="text-center">
							<input
								ref="input"
								type="file"
								name="image"
								accept="image/*"
								@change="setImage"
							/>
						</div>
						<vue-cropper
							ref="cropper"
							:src="imgSrc"
							alt=""
							@ready="..."
							@cropend="..."
							@crop="..."
						>
						</vue-cropper>
					</div>
					<div class="modal-footer">
						<button
							type="button"
							class="btn btn-secondary"
							data-dismiss="modal"
						>
							Cancelar
						</button>
						<button type="button" class="btn btn-primary">
							Recortar imagen
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
import Vue from "vue";
// we import the plugin cropper.js
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
// doc https://github.com/Agontuk/vue-cropperjs
// doc https://fengyuanchen.github.io/cropperjs/

export default Vue.extend({
	components: {
		VueCropper,
	},
	props: {
		imagen: {
			type: String,
			required: true,
		},
		aspectRatio: {
			type: Number,
			default: 1,
		},
	},
	data() {
		return {
			imgSrc: this.imagen,
			cropImg: "",
			data: null,
		};
	},
	methods: {
		setImage(e: any) {
			const file = e.target.files[0];
			if (file.type.indexOf("image/") === -1) {
				alert("Please select an image file");
				return;
			}
			if (typeof FileReader === "function") {
				const reader = new FileReader();
				reader.onload = (event) => {
					this.imgSrc = event.target.result;
					// rebuild cropperjs with the updated source
					this.$refs.cropper.replace(event.target.result);
				};
				reader.readAsDataURL(file);
			} else {
				alert("Sorry, FileReader API not supported");
			}
		},
	},
	mounted() {
		console.log("mounted");
		console.log(this.imagen);

		// we select the area where we want to crop
		const image = document.getElementById("image");

		// we create a new instance of cropper.js
		const cropper = new Cropper(image, {
			aspectRatio: this.aspectRatio,
			viewMode: 3,
			dragMode: "move",
			minContainerWidth: 300,
			minContainerHeight: 300,
			zoomable: false,
			toggleDragModeOnDblclick: false,
			initialAspectRatio: this.aspectRatio,
			ready: () => {
				// cropper.setCropBoxData({
				// 	left: 0,
				// 	top: 0,
				// 	width: 200,
				// 	height: 200,
				// });
			},
		});

		// aspectRatio: this.aspectRatio,
		// 	viewMode: 3,
		// 	// dragMode: "move",
		// 	autoCrop: true,
		// 	autoCropArea: 1,
		// 	responsive: true,
		// 	restore: false,
		// 	guides: false,
		// 	highlight: false,
		// 	cropBoxMovable: false,
		// 	cropBoxResizable: false,
		// 	toggleDragModeOnDblclick: false,
		// });
	},
});
</script>

<style>
.areaRecorte .cropper-container {
	max-width: 100%;
	max-height: 100%;
	margin: auto;
}
</style>
