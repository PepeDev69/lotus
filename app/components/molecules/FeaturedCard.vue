<template>
	<div class="fs-card" :class="{ empty: !img }">
		<picture class="fs-card__image">
			<img :src="withFallbackImage" :alt="title" />
			<div v-if="overlay" class="fs-card__overlay" :class="{ related }">
				<span @click="$emit('open')" class="fs-card__icon icon-header-shop" />
				<span class="fs-card__icon icon-eye" />
			</div>
		</picture>
		<div class="fs-card__body">
			<span class="fs-card__subtitle">{{ subtitle }}</span>
			<h3 class="fs-card__title">{{ title }}</h3>
			<p class="fs-card__price">{{ price | currency }}</p>
		</div>
	</div>
</template>

<script>
export default {
	name: 'FeaturedService',
	props: {
		img: {
			type: [String, Boolean],
			default: '',
		},
		title: {
			type: String,
			default: '',
		},
		subtitle: {
			type: String,
			default: '',
		},
		price: {
			type: Number,
			default: '',
		},
		overlay: {
			type: Boolean,
			default: false,
		},
		related: {
			type: Boolean,
			default: false,
		},
	},
	computed: {
		withFallbackImage() {
			return this.img ? this.img : require('~/assets/img/not-found-image.jpg');
		},
	},
};
</script>

<style lang="postcss">
.fs-card {
	@apply w-full;
	&:hover .fs-card__overlay {
		@apply opacity-100 pointer-events-auto;
	}
	&.empty &__image::before{
		content: '';
		@apply absolute inset-0 bg-linen/60;
	}
}

.fs-card__image {
	@apply w-full relative flex items-center justify-center;
	.fs-card__overlay {
		transition: opacity 0.3s ease-in-out;
		@apply pointer-events-auto opacity-0 absolute bg-linen/60 inset-0 flex justify-center items-center text-[2.5rem] gap-[0.44em];
	}
	@media screen(m-md) {
		.fs-card__overlay {
			@apply opacity-90 pointer-events-auto;
		}
	}
	.fs-card__icon {
		transition-property: background-color, color;
		transition-duration: 0.3s;
		transition-timing-function: ease-in-out;
		@apply text-primary text-[1em] bg-white w-[2em] h-[2em] rounded-full grid place-items-center;
		&:hover {
			@apply bg-primary text-white;
		}
		&.icon-header-shop {
			@apply relative z-[50];
		}
	}
	img {
		@apply w-full object-cover;
	}
}

.fs-card__body {
	@apply text-center leading-none;
}

.fs-card__subtitle {
	font-family: 'Rubik';
	@apply block text-[1.4rem] tracking-widest uppercase text-gray-400 font-normal mt-[2em];
	@media screen(lg) {
		font-size: calc(var(--p-font-size) - 3px);
	}
}

.fs-card__title {
	@apply font-semibold text-primary text-[2rem] mt-[.5em] mb-[.6em];
	@media screen(lg) {
		@apply text-[2rem];
	}
	@media screen(monitor) {
		@apply text-[2.8rem];
	}
}

.fs-card__price {
	@apply leading-none text-[1.9rem] text-gray-500 font-light;
}
</style>
