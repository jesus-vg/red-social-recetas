<template>
	<avatar :username="getUsername" :size="40" :src="getAvatar"></avatar>
</template>

<script lang="ts">
import Vue from "vue";
import Avatar from "vue-avatar";

export default Vue.extend({
	props: ["src", "username"],
	components: {
		avatar: Avatar,
	},
	computed: {
		getAvatar() {
			return this.src;
		},
		getUsername() {
			console.log(this.username);

			return this.username;
		},
	},
});
</script>
