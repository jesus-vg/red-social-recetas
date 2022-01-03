/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import VueSweetalert2 from "vue-sweetalert2";
// we import the styles, you don't need to `import` the entire library
import "sweetalert2/dist/sweetalert2.min.css";
// https://www.udemy.com/course/curso-laravel-crea-aplicaciones-y-sitios-web-con-php-y-mvc/learn/lecture/20325255

import "lazysizes";
// import a plugin
import "lazysizes/plugins/parent-fit/ls.parent-fit";
// https://github.com/aFarkas/lazysizes

window.lazySizesConfig = window.lazySizesConfig || {};

// configure lazySizes para que cargue las imagenes solo cuando se hace scroll
window.lazySizesConfig.loadMode = 0;

window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// we need to ignore some components
Vue.config.ignoredElements = ["trix-editor", "trix-toolbar"];
Vue.component("fecha-receta", require("./components/FechaReceta.vue").default);
Vue.component(
	"eliminar-receta",
	require("./components/EliminarReceta.vue").default
);
Vue.component("avatar", require("./components/Avatar.vue").default);
Vue.component(
	"recortar-imagen",
	require("./components/RecortarImagen.vue").default
);

// componente para scroll infinito en recetas
Vue.component(
	"recetas-scroll-infinito",
	require("./components/RecetasScrollInfinito.vue").default
);

// componente para mostrar un loader
Vue.component("loader", require("./components/Loader.vue").default);

/**
 * Here we register the Vue plugins
 *
 */
const options = {
	confirmButtonColor: "#008638",
	cancelButtonColor: "#e3342f",
};

Vue.use(VueSweetalert2, options);
// console.log(Vue.prototype);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: "#app",
});
