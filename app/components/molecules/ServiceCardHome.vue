<template>
	<AppLink
		class="hs-card"
		:class="[`card${index}`]"
		:to="
			slugLink
				? {
						name: 'service-category-slug',
						params: { shop: 'services', category: categoryLink, subcategory: subcategoryLink, slug: slugLink },
				  }
				: {
						name: 'service-category',
						params: { shop: 'services', category: categoryLink, subcategory: subcategoryLink },
				  }
		"
	>
		<div :style="cssVar" class="hs-card__picture"></div>
		<div class="hs-card__content">
			<picture class="hs-card__category-icon">
				<img class="hs-card__category-img" :src="category" :alt="title" />
			</picture>
			<h3 class="hs-card__title">{{ title }}</h3>
			<p class="hs-card__text">{{ text }}</p>
			<div class="hs-card__bottom">
				<span class="hs-card__link">{{ polylang.btn_see_more }}</span>

				<picture class="hs-card__category-icon bottom">
					<img class="hs-card__category-img" :src="category" :alt="title" />
				</picture>
			</div>
		</div>
		<span class="hs-card__index">{{ currentIndex }}</span>
	</AppLink>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'ServiceCardHome',
	props: {
		img: {
			type: String,
			default: '',
		},
		title: {
			type: String,
			default: '',
		},
		text: {
			type: String,
			default: '',
		},
		index: {
			type: Number,
			default: 0,
		},
		link: {
			type: String,
			default: '#',
		},
		category: {
			type: String,
			default: '',
		},
		slug: {
			type: String,
		},
		categoryLink: String,
		subcategoryLink: String,
		slugLink: String,
	},
	computed: {
		...mapState(['polylang']),
		cssVar() {
			return {
				'--bg-image': 'url(' + this.img + ')',
			};
		},
		currentIndex() {
			const indexLength = this.index.toString().length;
			const currentIndex = Number(this.index) + 1;
			return indexLength < 2 ? '0' + currentIndex : currentIndex;
		},
	},
};
</script>

<style lang="postcss">
.hs-card {
	background-color: rgb(222 171 152 / 0.7);
	@apply cursor-pointer w-full h-full relative max-h-[60rem] min-h-[40rem] rounded-2xl overflow-hidden flex items-end text-[3rem];
	@media screen(md) {
		@apply min-h-[40rem];
	}
	@media screen(xl) {
		@apply min-h-[50rem];
	}
	@media screen(monitor) {
		@apply text-[3.8rem] h-[60rem];
	}
	&__picture {
		background-image: linear-gradient(180deg, rgba(168, 74, 38, 0) 35.94%, rgba(168, 74, 38, 0.56) 79.69%, rgba(168, 74, 38, 0.7) 98.96%),
			var(--bg-image);
		background-size: cover;
		background-repeat: no-repeat;
		@apply absolute inset-0;
	}

	&__content {
		@apply absolute px-[1em] bottom-0 pb-[6rem];
	}

	&__title {
		font-family: 'Cormorant-Garamond-SemiBold', serif;
		text-shadow: 0 0 4px rgb(0 0 0 / 0.3);
		@apply font-semibold text-white text-[.9em] leading-none my-[.25em];
	}

	&__text {
		font-family: 'Roboto', sans-serif;
		@apply text-[1.7rem] text-white leading-relaxed font-normal pr-[2.6em];
		@media screen(xl) {
			@apply text-[1.6rem];
		}
		@media screen(design) {
			@apply text-[1.6rem];
		}
		@media screen(monitor) {
			@apply text-[1.9rem];
		}
	}

	&__bottom {
		@apply flex justify-between items-start mt-[1.2em];
	}

	&__link {
		font-family: 'Rubik-Medium', sans-serif;
		border-bottom: 2px solid;
		@apply font-medium text-white text-[0.47368421052em]  tracking-[0.02em] uppercase leading-none border-white pb-[.3em];
	}

	&__index {
		font: normal 600 12rem / 0.8 'EBGaramond-SemiBold', serif;
		color: transparent;
		-webkit-text-stroke-width: 1px;
		-webkit-text-stroke-color: rgb(255 255 255 / 0.7);
		bottom: 0;
		right: 5px;
		@apply absolute lg:text-[8rem] design:text-[10rem] monitor:text-[12rem];
	}

	&__category-icon {
		border: 1px solid;
		@apply w-[7.5rem] h-[7.5rem] flex absolute top-[-8rem] left-[1em] items-center justify-center rounded-[100%] border-white p-[2rem];
		&.bottom {
			@apply hidden;
		}
	}
	@screen laptop {
		&__category-icon {
			@apply w-[6rem] h-[6rem] p-[1.5rem];
		}
	}
}

.hs-card.card1 {
	@apply bg-blue;
	.hs-card__picture {
		background-image: linear-gradient(180deg, rgba(124, 183, 194, 0) 6.77%, #3aa1b4 87.5%, #3aa1b4 100%), var(--bg-image);
		background-size: cover;
		background-repeat: no-repeat;
		@apply absolute inset-0;
	}

	.hs-card__index {
		@apply top-[1rem] left-[1rem] right-[inherit] bottom-[inherit];
	}

	.hs-card__category-icon {
		@apply left-[initial] bottom-[4rem] right-[1em] top-[initial];
	}
}
</style>
