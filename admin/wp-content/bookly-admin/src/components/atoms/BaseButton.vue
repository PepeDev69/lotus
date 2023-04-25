<script setup lang="ts">
type ButtonTypes = 'submit' | 'reset' | 'button';
defineProps({
	text: String,
	loading: {
		type: Boolean,
		default: false,
	},
	type: {
		type: String as () => ButtonTypes,
		default: 'button',
	},
});
</script>

<template>
	<button :class="{ loading }" :type="type" class="t-round b-btn">
		{{ text }}
	</button>
</template>

<style lang="scss">
.b-btn {
	position: relative;
	display: inline-flex;
	padding: 0.8rem 1.6rem;
	font: normal 500 calc(var(--ts-font-size) - 1px) / 1.2 var(--font);
	background-color: var(--ts-cyan-alpha);
	border: 1px solid var(--ts-cyan);
	color: var(--ts-grey-100);
	cursor: pointer;
	&::before {
		content: '';
		display: block;
		width: 1.8em;
		height: 1.8em;
		position: absolute;
		left: calc(50% - 0.9em);
		top: calc(50% - 0.9em);
		border: 0.25em solid transparent;
		border-right-color: white;
		border-radius: 50%;
		animation: button-anim 0.7s linear infinite;
		opacity: 0;
	}
	&.loading {
		pointer-events: none;
		color: transparent;
		&::before {
			opacity: 1;
		}
	}
}

@keyframes button-anim {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(360deg);
	}
}
</style>
