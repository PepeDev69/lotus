<script setup>
defineProps({
	text: String,
});
</script>

<template>
	<button :class="css.btn" class="t-round tx-btn" @click="$emit('click')">
		{{ text }}
	</button>
</template>

<style lang="scss" module="css">
.btn {
	display: inline-flex;
	padding: 0.54em 1.6em;
	font: normal 500 var(--ts-font-size) /1.2 var(--font);
	background-color: transparent;
	transition: 300ms ease-in-out;
	transition-property: transform;
	border: 2px solid var(--ts-cyan-light);
	color: var(--ts-grey-100);
	cursor: pointer;
	&:hover {
		transform: scale(1.025);
	}
}
</style>

<style lang="scss">
// .tx-btn {
// 	position: relative;
// 	&::before {
// 		content: "";
// 		display: block;
// 		width: 1.8em;
// 		height: 1.8em;
// 		position: absolute;
// 		left: calc(50% - 0.9em);
// 		top: calc(50% - 0.9em);
// 		border: 0.25em solid transparent;
// 		border-right-color: white;
// 		border-radius: 50%;
// 		animation: button-anim 0.7s linear infinite;
// 		opacity: 0;
// 	}
// 	&.loading {
// 		pointer-events: none;
// 		color: transparent;
// 		&::before {
// 			opacity: 1;
// 		}
// 	}
// }

// @keyframes button-anim {
// 	from {
// 		transform: rotate(0);
// 	}
// 	to {
// 		transform: rotate(360deg);
// 	}
// }
</style>
