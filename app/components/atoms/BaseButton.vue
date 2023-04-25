<template>
	<NuxtLink v-if="path" :to="withPath" :class="css.btn">
		<span :class="css.text"> {{ text }}</span>
		<span :class="css.mask"></span>
	</NuxtLink>
	<button v-else :class="css.btn">
		<span :class="css.text"> {{ text }}</span>
		<span :class="css.mask"></span>
	</button>
</template>

<script>
export default {
	props: {
		text: String,
		path: [Object, String]
	},
	computed: {
		withPath() {
			if (this.path instanceof Object && this.path.hasOwnProperty('name')) {
				return this.localePath(this.path);
			}
			return this.localePath({ name: 'index' });
		},
	},
};
</script>

<style lang="postcss" module="css">
.btn {
	position: relative;
	font: normal 400 var(--p-font-size) / 1 'Roboto', serif;
	padding: 0.75em 1.5em;
	border-radius: 0.3em;
	background-color: var(--primary);
	.text {
		font: inherit;
		position: relative;
		z-index: 1;
		color: var(--white);
	}
	&:hover .mask {
		opacity: 1;
		transform: scaleY(1);
	}
}
.mask {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-image: linear-gradient(180deg, #377885 0%, #395d64 100%);
	border-radius: inherit;
	opacity: 0;
	transform: scaleY(0);
	transition: opacity 400ms ease-in-out, transform 300ms ease-in-out;
}
</style>
