<script lang="ts" setup>
defineProps({
	tag: {
		type: String,
		default: "h2",
	},
	text: [String, Number],
	variant: {
		type: String,
		default: ''
	},
});

</script>

<template>
	<component :is="tag" :class="[css.title, css[variant]]">
		{{ text }}
	</component>
</template>

<style lang="scss" module="css">
.title {
	font: normal 500 2.2rem /1.2 var(--font);
	padding-bottom: 1em;
	color: var(--ts-cyan-light);
	text-align: center;
	@include media-from(monitor) {
		font-size: 2.5rem;
	}
}
.large {
	font-size: 2.5rem;
}
.medium {
	font-size: 1.8rem;
}
</style>
