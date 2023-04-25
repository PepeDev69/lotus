<template>
	<Transition name="slide-anim" appear @after-enter="modalOpen = true" @after-leave="modalOpen = false">
		<div class="t-fixed inset tx-overlay t-abs-center" :class="css.overlay" v-if="overlay.isOpen">
			<div
				class="outer-overlay t-w-full t-h-full"
				@click="$emit('close'), overlay.changeClose()"
				:class="{ 'open': modalOpen }"
			></div>
			<section class="inner-overlay" v-bind="$attrs">
				<slot />
			</section>
		</div>
	</Transition>
</template>
<script lang="ts" setup>
import { useOverlayStore } from "@/stores/overlay";
import { ref } from "vue";

const overlay = useOverlayStore()
const modalOpen = ref(false);

</script>

<style module="css" lang="scss">
.overlay {
	z-index: 5;
}
</style>

<style lang="scss">
.outer-overlay {
	background-color: rgba(51, 53, 55, 0.6);
	opacity: 0;
	transition: opacity 200ms ease-in-out;
	position: absolute;
	backdrop-filter: blur(4px);
	&.open {
		opacity: 1;
	}
	.slide-anim-leave-active & {
		opacity: 0;
	}
}

.inner-overlay {
	z-index: 1;
}

.slide-anim-enter-active {
	animation: slideLeft 400ms;
	animation-timing-function: cubic-bezier(0.34, 1.2, 0.8, 1);
}

.slide-anim-leave-active {
	animation: slideLeft 400ms reverse 100ms;
	animation-timing-function: cubic-bezier(0.34, 1.2, 0.8, 1);
}

@keyframes slideLeft {
	from {
		transform: translate3d(0, -100%, 0);
	}
	to {
		transform: translate3d(0 0, 0);
	}
}
</style>
