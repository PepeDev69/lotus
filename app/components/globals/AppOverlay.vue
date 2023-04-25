<template>
	<Transition name="slide-anim" appear @after-enter="modalOpen = true" @after-leave="modalOpen = false">
		<div class="fixed inset-0 t-abs-center" :class="css.overlay" v-if="open">
			<div class="outer-overlay w-full h-full" @click="$emit('close'), changeClose()" :class="{ open: modalOpen }" />
			<section class="inner-overlay" v-bind="$attrs">
				<slot />
			</section>
		</div>
	</Transition>
</template>
<script>
export default {
	name: 'AppOverlay',
	props: {
		open: Boolean,
	},
	methods: {
		changeClose() {
			this.isOpen = false;
		},
	},
	watch: {
		open(value, old) {
			this.isOpen = value;
		},
	},
	data() {
		return {
			modalOpen: false,
			isOpen: false,
		};
	},
};
</script>

<style lang="postcss" module="css">
.overlay {
	z-index: 16;
}
</style>

<style lang="postcss">
.t-abs-center {
	justify-content: center;
	align-items: center;
	display: flex;
}
.outer-overlay {
	background-color: rgba(51, 53, 55, 0.6);
	opacity: 0;
	transition: opacity 200ms ease-in-out;
	position: absolute;
	&.open {
		opacity: 1;
	}
	.slide-anim-leave-active & {
		opacity: 0;
	}
}

.inner-overlay {
	z-index: 1;
	padding-left: 3rem;
	padding-right: 3rem;
	@media (max-width: 1025px) {
		@apply mt-[4rem];
	}
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
