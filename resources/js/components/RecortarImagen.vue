<template>
	<div>
		<div class="mb-3" v-if="imagenSeleccionada">
			<p>
				<strong>Nueva imagen seleccionada:</strong>
			</p>
			<img :src="cropImg" class="img-fluid-crop" />

			<button
				type="reset"
				class="btn btn-danger"
				ref="btnQuitarImagenSeleccionada"
				@click="quitarImagenSeleccionada"
			>
				Quitar imagen
			</button>
		</div>

		<div class="mb-3" v-else-if="!imagenSeleccionada && imagen">
			<p>Imagen actual:</p>
			<img :src="imagen" class="img-fluid-crop" alt="Imagen actual" />
		</div>

		<button
			type="button"
			class="btn btn-outline-primary"
			@click="showFileChooser"
		>
			Subir imagen
		</button>

		<!-- Modal -->
		<div
			class="modal fade"
			id="modal-cropper"
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
						<div class="crop-area">
							<img
								id="cropper-area"
								:src="imgSrc"
								class="img-fluid"
							/>
							<div class="mt-2 text-center">
								<a
									href="#"
									role="button"
									class="btn btn-info"
									@click.prevent="reset"
								>
									Resetear
								</a>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button
							type="button"
							class="btn btn-secondary"
							data-dismiss="modal"
						>
							Cancelar
						</button>

						<button
							type="button"
							class="btn btn-primary"
							data-dismiss="modal"
							@click.prevent="seleccionarImagen"
						>
							Seleccionar area de recorte
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- input para seleccionar una imagen - esta oculta -->
		<input
			type="file"
			ref="input"
			accept="image/*"
			class="d-none"
			@change="setImage"
		/>

		<input type="hidden" name="imagen" id="imagen" />
	</div>
</template>

<script lang="ts">
import Vue from "vue";
// we import the plugin cropper.js
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";
// doc https://fengyuanchen.github.io/cropperjs/

export default Vue.extend({
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
			imgSrc: this.imagen, // imagen a recortar, se inicializa con la imagen original
			cropImg: "", // imagen recortada
			myCropper: Cropper, // instancia del plugin cropper.js
			cropperArea: null, // el elemento del DOM que contiene la imagen a recortar
			imagenSeleccionada: false, // indica si el usuario ha seleccionado una imagen
			// tamaño máximo de la imagen 10mb
			maxSize: 10 * 1024 * 1024, // 10mb
			// type mime de la imagen
			type: "", // mime type de la imagen para indicar que tipo de imagen es (jpg, png, etc)
			inputImagen64: {
				type: HTMLElement, // imagen en base64, esta oculta, input hidden
			},
		};
	},
	methods: {
		cropInit() {
			// we create a new instance of cropper.js
			this.myCropper = new Cropper(this.cropperArea, {
				aspectRatio: this.aspectRatio,
				viewMode: 3,
				dragMode: "move",
				minCropBoxWidth: 100,
				minCropBoxHeight: 100,
				toggleDragModeOnDblclick: false,
				initialAspectRatio: this.aspectRatio,
				responsive: false,
			});
		},
		cropImage() {
			// we get the cropped image data
			this.cropImg = this.myCropper
				.getCroppedCanvas() // el canvas con la imagen recortada
				.toDataURL(this.type); // convertimos la imagen a base64
			// console.log(this.cropImg);
		},
		reset() {
			this.myCropper.reset();
		},
		setImage(e) {
			const file = e.target.files[0];

			// validar que el usuario haya seleccionado un archivo
			if (file) {
				// console.log(file);
				// console.log(e);

				// show error message if file is not an image
				if (file.type.indexOf("image/") === -1) {
					this.$swal({
						title: "Error",
						html:
							"El archivo no es una imagen valida :( <br> <strong>Tipo:</strong> " +
							file.type,
						icon: "error",
					});
					return;
				}

				// we validate the image size, if the image size is bigger than the max size we show an error message
				if (file.size > this.maxSize) {
					this.$swal({
						title: "Error",
						html:
							"El archivo es muy grande :( <br> <strong>Tamaño:</strong> " +
							this.bytesToSize(file.size) +
							"<br> <strong>Tamaño máximo:</strong> " +
							this.bytesToSize(this.maxSize),
						icon: "error",
					});
					return;
				}

				if (typeof FileReader === "function") {
					const reader = new FileReader();
					reader.onload = (event) => {
						this.imgSrc = event.target.result; // cargar la imagen a recortar

						// show the modal
						$("#modal-cropper").modal("show");

						this.quitarImagenSeleccionada();

						// get type of image
						this.type = file.type;
						// console.log(this.type);

						e.target.value = ""; // reset the input
					};
					reader.readAsDataURL(file);
				} else {
					// show error message if FileReader is not supported
					this.$swal({
						title: "Error",
						html:
							"El navegador no soporta la lectura de archivos :( <br> <strong>Tipo:</strong> " +
							file.type,
						icon: "error",
					});
				}
			}
		},
		showFileChooser() {
			this.$refs.input.click();
		},
		seleccionarImagen() {
			this.cropImage();

			this.imagenSeleccionada = true;
			// console.log("imagenSeleccionada", this.imagenSeleccionada);

			this.inputImagen64.value = this.cropImg;
			// console.log(this.inputImagen64.value);
			// console.log("this.cropImg", this.cropImg);
		},
		bytesToSize(bytes) {
			const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
			if (bytes === 0) return "0 Byte";
			const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
		},
		quitarImagenSeleccionada() {
			this.imagenSeleccionada = false;
			this.inputImagen64.value = "";
		},
	},
	mounted() {
		// console.log("mounted");
		// console.log(this.imagen);

		this.cropperArea = document.getElementById("cropper-area");

		// seleccionamos el input que va a tener la imagen en base64
		this.inputImagen64 = document.querySelector("#imagen");

		// destruimos el cropper al cerrar el modal
		$("#modal-cropper").on("hidden.bs.modal", (event4) => {
			// console.log("cerrado");
			this.myCropper.destroy(); // destroy cropperjs
		});

		// iniciar el cropper despues de que el modal se abre
		$("#modal-cropper").on("shown.bs.modal", (event4) => {
			// console.log("mostrado");
			this.cropInit();
		});
	},
});
</script>

<style scoped>
.crop-area {
	width: 100%;
	height: 100%;
	position: relative;
}

.crop-area img {
	width: 100%;
	height: 100%;
}

.img-fluid-crop {
	width: 200px;
	height: 200px;
	border-radius: 0.3rem;
}
</style>
