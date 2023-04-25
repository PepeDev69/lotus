<template>
	<section class="home-slider" ref="home_slide">
		<Swiper :options="swiperOptions" class="home-slider__swiper" :cleanup-styles-on-destroy="false">
			<SwiperSlide v-for="(slide, i) in slider" :key="i" class="home-slider__slide">
				<div class="home-slider__slide--left">
					<picture>
						<source media="(min-width: 961px)" :srcset="slide.image" />
						<img :src="slide.img_mob" :alt="slide.title" />
					</picture>
				</div>
				<div class="home-slider__slide--right">
					<div class="home-slider__dash"></div>
					<div class="home-slider__info">
						<h2 class="home-slider__title" v-html="slide.title"></h2>
						<p class="home-slider__content">{{ slide.content }}</p>
					</div>
					<div class="home-slider__button">
						<ButtonGeneral class="blue" :text="label" @click.native="smothToServiceSection" />
						<ButtonGeneral class="border" :text="labelTwo" :path="{ name: 'contact-us' }" />
					</div>
				</div>
			</SwiperSlide>
		</Swiper>
		<div class="home-slider__pagination"></div>
	</section>
</template>

<script>
export default {
	name: 'BannerPrin',
	components: {
		Information: () => import('~/components/molecules/Information.vue'),
	},
	props: {
		title: String,
		text: String,
		label: String,
		labelTwo: String,
		slider: Array,
	},
	methods: {
		smothToServiceSection() {
			const { height, top } = this.$refs.home_slide.getBoundingClientRect();
			window.scrollTo({
				top: height + top,
				behavior: 'smooth',
			});
		},
	},
	data() {
		return {
			/** @type { import('swiper').SwiperOptions } */
			swiperOptions: {
				slidesPerView: 1,
				spaceBetween: 0,
				speed: 1500,
				loop: false,
				effect: 'fade',
				fadeEffect: {
					crossFade: true,
				},
				autoplay: {
					delay: 6000,
					disableOnInteraction: false,
				},
				pagination: {
					el: '.home-slider__pagination',
					type: 'bullets',
					clickable: true,
				},
			},
		};
	},
};
</script>

<style lang="postcss">
.home-slider {
	height: calc(100vh - var(--header-height));
	@apply relative bg-linen;
	&__swiper {
		@apply h-full;
	}
	&__slide {
		@apply flex flex-col h-auto;
		@media screen(xl) {
			@apply flex-row;
		}
	}
	&__slide--left {
		@apply w-2/4;
		img,
		picture {
			@apply w-full h-full object-cover;
		}
	}
	&__slide--right {
		@apply w-2/4 bg-linen px-[1.4em] pt-[3.3em] text-[7rem];
	}

	&__title {
		font-family: 'Cormorant-Garamond-Bold', serif;
		@apply text-primary leading-none text-[1em] tracking-[-0.01em] font-medium my-[0.29em];
	}
	&__content {
		@apply text-[.3em] w-[51ch];
	}
	&__button .btn-gral {
		@apply font-medium max-w-fit h-full py-[.42em] mt-[3.5em];
	}
	&__dash::after {
		content: '';
		@apply h-[.5rem] w-[5.4rem] bg-primary block;
	}
	&__pagination {
		content: '';
		@apply w-fit h-full absolute top-0 right-[6.5rem] z-[1] flex flex-col justify-center gap-4;
		.swiper-pagination-bullet {
			border: 1px solid;
			background-color: transparent;
			@apply w-[1.762rem] h-[1.762rem] rounded-full relative cursor-pointer border-primary grid place-items-center;
			&-active::after {
				content: '';
				@apply bg-primary w-[.775rem] h-[.775rem] rounded-full absolute;
			}
		}
	}
	@screen laptop {
		&__slide--right {
			@apply text-[4.5rem] px-[1.3em] pt-[3.75em];
		}
		&__dash::after {
			@apply h-[.4rem] w-[4.7rem];
		}
		&__content {
			@apply text-[.35em];
		}
		&__button .btn-gral {
			@apply py-[.1em];
		}
		&__pagination {
			@apply right-[4.5rem];
			.swiper-pagination-bullet {
				@apply w-[1.7rem] h-[1.7rem];
				&-active::after {
					@apply w-[.7rem] h-[.7rem];
				}
			}
		}
	}
	@media (min-width: 1400px) {
		&__slide--right {
			@apply pt-[4.75em];
		}
	}
	@media (min-width: 1700px) {
		&__slide--right {
			@apply pt-[3.5em];
		}
	}
	@screen tablet {
		&__slide--right {
			@apply px-[3rem] py-[1.5rem] flex flex-wrap content-center;
		}
		&__info,
		&__button {
			@apply w-full;
		}
		&__button {
			@apply mt-[4rem] flex;
			.btn-gral {
				@apply flex items-center justify-center mt-0 py-[1rem] h-auto mr-[1.3rem] last:mr-0;
			}
		}
		&__pagination {
			@apply right-[inherit] h-auto left-[50%] w-[50%] bottom-[2.5rem] top-[initial] flex-row;
		}
	}
	@screen tabletver {
		@apply h-auto;
		&__slide {
			@apply flex-wrap;
			&--left {
				@apply w-full h-[30rem];
			}
			&--right {
				@apply w-full pt-[5.5rem] pb-[8rem];
			}
		}
		&__content {
			@apply text-[1.6rem] w-full;
		}
		&__pagination {
			@apply left-0 w-full;
		}
	}
}
</style>
