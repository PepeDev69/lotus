<template>
	<div class="md-mod">
		<button class="md-mod__close" @click="$emit('close')">
			<svg width="23" height="23" fill="none" viewBox="0 0 23 23">
				<path stroke="#fff" stroke-linecap="round" stroke-width="3" d="m2 2 19 19M2 21 21 2" />
			</svg>
		</button>
		<div class="md-mod__content">
			<slot />
		</div>
	</div>
</template>

<script>
export default {
	name: 'AppModalScreen',
};
</script>

<style lang="postcss">
.md-mod {
	position: relative;
	&__close {
		position: absolute;
		padding: 0.8em 1.2em;
		background-color: var(--primary);
		font-size: var(--p-font-size);
		bottom: 100%;
		right: 0;
		svg {
			width: 1.1em;
			height: 1.1em;
		}
	}
}
</style>
