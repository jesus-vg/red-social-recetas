<template>
	<span>{{ formatearFecha }}</span>
</template>

<script>
export default {
	props: ["fecha"],
	computed: {
		formatearFecha() {
			// doc https://www.blogdeenrique.com/fecha-en-idioma-y-formato-espanol-con-javascript/
			const months = [
				"enero",
				"febrero",
				"marzo",
				"abril",
				"mayo",
				"junio",
				"julio",
				"agosto",
				"septiembre",
				"octubre",
				"noviembre",
				"diciembre",
			];
			const days_week = [
				"domingo",
				"lunes",
				"martes",
				"miércoles",
				"jueves",
				"viernes",
				"sábado",
			];
			const date = new Date(this.fecha);

			return `${days_week[date.getDay()]}, ${date.getDate()} de ${
				months[date.getMonth()]
			} de ${date.getFullYear()}`;
		},
	},
};
</script>
