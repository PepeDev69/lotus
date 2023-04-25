<template>
	<section class="h-featured">
		<div class="h-featured__container">
			<div class="h-featured__info">
				<Information :title="title" :text="text" class="h-featured__info" />
			</div>
			<Swiper :options="swiperOptions" class="h-featured__swiper" :cleanup-styles-on-destroy="false">
				<SwiperSlide v-for="(product, i) in products" :key="i" class="h-featured__slide" :cleanup-styles-on-destroy="false">
					<AppLink :to="{ name: 'product-category', params: { shop: 'products', category: product.slug } }" class="h-featured__link">
						<article class="hp-article">
							<div class="h-featured__title-wrapper">
								<h3 class="h-featured__title">{{ product.name }}</h3>
								<p id="limit-characters-and">
									{{ product.description }}
								</p>
								<div class="flex-1"></div>
								<span>{{ label }}</span>
							</div>
							<div class="h-featured__picture">
								<figure class="h-featured__picture__thumb" :class="[`figure-${i + 1}`]">
									<img class="h-featured__image" :src="product.thumbnail" :alt="product.name" />
								</figure>
								<!-- <figure class="h-featured__picture__icon hp-article__icon">
									<img :src="product.icon_image" :alt="product.name" />
								</figure> -->
							</div>
						</article>
					</AppLink>
				</SwiperSlide>
			</Swiper>
			<div class="h-products__pagination"></div>
		</div>
	</section>
</template>

<script>
export default {
	name: 'ServicesHomeFeatures',
	props: {
		title: String,
		text: String,
		label: String,
		slug: String,
		products: Array,
	},
	data: () => ({
		/** @type { import('swiper').SwiperOptions } */
		swiperOptions: {
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 1500,
			breakpoints: {
				768: {
					slidesPerView: 2,
					spaceBetween: 5,
				},
				960: {
					slidesPerView: 2,
					spaceBetween: 20,
				},
				1025: {
					slidesPerView: 3,
					spaceBetween: 5,
				},
				1200: {
					slidesPerView: 3,
					spaceBetween: 5,
					allowTouchMove: false,
				},
			},
			pagination: {
				el: '.h-products__pagination',
				type: 'bullets',
				clickable: true,
			},
			navigation: {
				nextEl: '.h-featured__navigation--next',
				prevEl: '.h-featured__navigation--prev',
			},
		},
	}),
	computed: {
		splited: () => (switcher, text, limit) => {
			if (typeof switcher == 'string') {
				limit = switcher.length < 13 ? limit : limit - 20;
			}
			return typeof text == 'string' ? text.slice(0, limit) : '';
		},
	},
};
</script>

<style lang="postcss">
/* //? MOBILE */
.h-featured {
	width: 100%;
	background-color: #3d626b0d;
	@apply py-[5rem];
	&__container {
		@media (min-width: 1200px) {
			@apply flex flex-col items-center justify-center;
		}
	}
	&__link {
		@apply flex h-full;
	}
	&__info {
		@apply flex flex-col gap-[.5em] mb-[.5rem];
		@media (min-width: 1400px) {
			@apply gap-[.7em];
		}
		.ctn-info {
			.ctn-title {
				.title-general {
					font-family: 'Cormorant-Garamond-Semibold';
					font-style: normal;
					line-height: 99.6%;
					text-align: center;
					letter-spacing: -0.02em;
					color: #395d64;
				}
			}
			div > p {
				text-align: center;
				color: #606060;
				max-width: 349px;
				margin: calc((100vw / 414) * 16) auto;
				max-width: calc((100vw / 100) * 84.3);
			}
		}
	}
	&__swiper {
		width: 100%;
	}
	&__slide {
		width: 100%;
		height: auto;
		article {
			margin: 2rem;
			background-color: #fff;
			filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.3));
			padding: 2.5rem;
			border-radius: 10px;
			display: flex;
			> div {
				display: flex;
				flex-direction: column;
				gap: 10px;
			}
			.h-featured__title-wrapper {
				width: 75%;
			}
			.h-featured__picture {
				width: auto;
				&__thumb {
					width: calc((100vw / 414) * 120);
					@media screen(tabletver) {
						width: calc((100vw / 414) * 73);
					}
					@media (max-width: 500px) {
						width: calc((100vw / 414) * 120);
					}
					img {
						aspect-ratio: 224/288;
						object-fit: contain;
						object-position: center;
					}
					/* @media (max-width: 960px) {
						@apply absolute bottom-0 left-[-1em];
					} */
				}
			}
			h3 {
				font-family: 'Cormorant-Garamond-Semibold';
				font-style: normal;
				font-size: 30px;
				line-height: 99.6%;
				letter-spacing: -0.02em;
				color: #395d64;
			}
			span {
				font: normal 400 calc(var(--p-font-size) - 3px) / 1 'Rubik-Medium';
				letter-spacing: 0.02em;
				text-transform: uppercase;
				color: #395d64;
				border-bottom: 2px solid #395d64;
				align-self: baseline;
				padding-bottom: 0.6rem;
			}
		}
	}
	/* //? MY OWN LAPTOP AND DESKTOP SETTINGS */
	@media screen(xlg) {
		.h-featured {
			width: 100%;
			--size-scooped: 100vw / 1900;
			background-color: #e9f3f5;
			@apply py-[5rem];
			&__info {
				.ctn-info {
					.ctn-title {
						.title-general {
							font-family: 'Cormorant-Garamond-Semibold';
							font-style: normal;
							font-size: calc((100vw / 1900) * 40);
							font-size: calc((100vw / 1900) * 54);
							line-height: 99.6%;
							text-align: center;
							letter-spacing: -0.02em;
							text-transform: unset;
							color: #395d64;
						}
					}
					div > p {
						max-width: 50ch;
						margin: 0 auto;
					}
				}
			}
			&__swiper {
				width: 100%;
				width: calc((100vw / 1900) * 1641);
			}
			&__link {
				height: 100%;
				@apply flex;
			}
			&__slide {
				height: auto;
				article {
					margin: calc((100vw / 1900) * 32);
					background-color: #fff;
					filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.3));
					padding: calc((100vw / 1900) * 50) calc((100vw / 1900) * 45);
					/* justify-content: center; */
					border-radius: calc((100vw / 1900) * 10);
					display: flex;
					> div.h-featured__title-wrapper {
						display: flex;
						flex-direction: column;
						gap: calc((100vw / 1900) * 10);
						flex-basis: calc((100vw / 1900) * 247);
						border-radius: calc((100vw / 1900) * 10);
					}
					h3 {
						font-family: 'Cormorant-Garamond-Semibold';
						font-style: normal;
						font-size: calc((100vw / 1900) * 30);
						line-height: 99.6%;
						letter-spacing: -0.02em;
						color: #395d64;
					}
					p {
						flex: 1;
					}
					.h-featured__picture {
						position: relative;
						&__thumb {
							max-width: 155px;
							max-width: calc((100vw / 1900) * 155);
							@media (min-width: 1200px) {
								@apply w-[5.5em];
								@apply absolute bottom-[-1em] left-0;
								max-width: none;
							}
							@media (min-width: 1700px) {
								@apply w-[6.5em];
							}
							.h-featured__image {
								object-position: bottom;
								object-fit: contain;
								aspect-ratio: 165/260;
							}
							&.figure-3 {
								@apply w-[9em] left-[-2em];
								@media (min-width: 1200px) {
									@apply w-[8em];
								}
								@media (min-width: 1700px) {
									@apply w-[10em];
								}
							}
						}
					}
				}
			}
		}
	}
}
.hp-article {
	--icon-width: 4rem;
	&__icon {
		position: absolute;
		display: flex;
		bottom: 1rem;
		left: -35%;
		width: var(--icon-width);
		height: var(--icon-width);
		border-radius: 100%;
		align-items: center;
		justify-content: center;
		border: 1px solid #395d64;
		z-index: 1;
		img {
			width: 62%;
			height: 62%;
			object-fit: contain;
		}
	}
	@media screen(m-md) {
		&__icon {
			display: none;
		}
	}
	@media screen(design) {
		--icon-width: 5rem;
	}
	@media screen(monitor) {
		--icon-width: 6.2rem;
	}
}

.h-products__pagination {
	@apply w-full h-[2rem] flex items-center justify-center gap-[.7rem];
	.swiper-pagination-bullet {
		@apply w-[1rem] h-[1rem] bg-[#C4C4C4] !m-0 cursor-pointer rounded-full;
		transform: scale(1);
		transition: 400ms ease-in-out;
		transition-property: background-color, transform;
		&-active {
			@apply bg-primary;
			transform: scale(1.2);
			transition: 400ms ease-in-out;
			transition-property: background-color, transform;
		}
	}
	@media screen(xl) {
		@apply hidden;
	}
}
</style>
