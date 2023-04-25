<template>
	<section class="h-reviews">
		<AppContainer class="h-reviews__container">
			<Titles :title="title" class="h-reviews__title" />
			<div class="h-reviews__slider">
				<Swiper
					:options="swiperOptions"
					class="h-reviews__swiper"
					ref="reviewsSwiper"
					@slideChange="getCurrentIndex"
					:cleanup-styles-on-destroy="false"
				>
					<SwiperSlide v-for="(review, i) in reviews" :key="i" class="h-reviews__slide">
						<article class="h-reviews__review">
							<div class="h-reviews__picture">
								<div class="h-reviews__icon icon-marks"></div>
								<figure class="h-reviews__image">
									<img :src="review.image" :alt="review.name" />
								</figure>
							</div>
							<div>
								<p class="h-reviews__content max-w-[100ch]">{{ review.content }}</p>
								<h3 class="h-reviews__a-title">
									<span>{{ review.name }} </span> {{ review.position }} /
									{{ review.address }}
								</h3>
							</div>
						</article>
					</SwiperSlide>
				</Swiper>
				<div class="h-reviews__right">
					<div class="h-reviews__current-slide">
						<p class="h-reviews__index">{{ ('0' + currentIndex).slice(-2) }}</p>
					</div>
					<div class="h-reviews__pagination"></div>
				</div>
			</div>
		</AppContainer>
		<picture class="h-reviews__bg"><img src="~/assets/img/butterfly.svg" alt="butterfly background" /></picture>
	</section>
</template>

<script>
export default {
	name: 'Reviews',
	props: {
		title: String,
		reviews: Array,
	},
	data() {
		return {
			/** @type { import('swiper').SwiperOptions } */
			swiperOptions: {
				slidesPerView: 1,
				spaceBetween: 40,
				speed: 1500,
				loop: false,
				autoplay: {
					delay: 8000000,
					disableOnInteraction: false,
				},
				breakpoints: {
					768: {
						direction: 'vertical',
					},
				},
				pagination: {
					el: '.h-reviews__pagination',
					clickable: true,
					type: 'bullets',
				},
			},
			currentIndex: 1,
		};
	},
	methods: {
		getCurrentIndex() {
			this.currentIndex = this.$refs.reviewsSwiper.$swiper.activeIndex + 1;
		},
	},
};
</script>

<style lang="postcss">
.h-reviews {
	--swiper-height: 26rem;
	@apply pt-[17.5rem] pb-[19rem] relative;

	&__container {
		@apply max-w-[80%];
	}

	&__slider {
		@apply flex items-center max-h-[var(--swiper-height)];
	}

	&__swiper {
		@apply max-h-[var(--swiper-height)];
	}

	&__slide {
		@apply flex;
	}
	&__title {
		@apply mb-[1.2em];
	}

	&__review {
		@apply flex text-[8rem] items-center gap-[.625em];
	}

	&__picture {
		@apply flex;
	}

	&__icon {
		@apply text-[1em] text-linen;
	}
	&__image {
		@apply rounded-full overflow-hidden w-[1.9375em] h-[1.9375em] mt-[.34em];
		img {
			@apply object-cover w-full;
		}
	}

	&__content {
		@apply text-[.25em];
	}

	&__a-title {
		font-family: 'Cormorant Garamond', serif;
		@apply text-[.35em] font-medium flex items-center gap-[0.2em] mt-[.9em];
		& span {
			font-family: 'Cormorant-Garamond-Bold', serif;
			@apply text-[1.14285714286em] font-bold pl-[0.8em] relative;
			&::before {
				content: '';
				@apply absolute left-[-.8rem] top-[50%] w-[1.8rem] h-[2px] bg-primary;
				transform: translateY(-50%);
			}
		}
		&::before {
			content: '';
			@apply w-[1em] h-[2px] bg-primary;
			@media (min-width: 1200px) {
				@apply hidden;
			}
		}
	}

	&__right {
		@apply flex flex-col h-[var(--swiper-height)] gap-4 items-center z-[1];
	}

	&__right {
		@apply flex flex-col items-center justify-center;
	}
	&__current-slide {
		@apply flex-1 relative flex flex-col-reverse justify-center items-center;
		&::before {
			content: '';
			z-index: 10;
			@apply max-h-[100%] h-full w-[2px] bg-primary block;
		}
	}
	&__pagination {
		@apply !inset-auto relative flex;
		transform: none !important;
		.swiper-pagination-bullet {
			@apply !flex items-center !m-0 justify-center;
		}
	}

	/* &__current-slide {
		@apply flex-1 relative flex justify-center items-start;
		&::before {
			content: '';
			z-index: 10;
			@apply max-h-[100%] h-full w-[2px] bg-primary block absolute;
		}
	} */

	&__index {
		font-family: 'Cormorant-Garamond-Bold', serif;
		z-index: 10;
		@apply font-bold text-[5rem] h-fit tracking-[0.02em] leading-none text-primary bg-white mt-[-0.36em] pb-[.38em];
	}
	&__pagination {
		content: '';
		@apply w-fit h-fit z-10 flex flex-col justify-center gap-4;
		.swiper-pagination-bullet {
			border: 1px solid;
			background-color: transparent;
			@apply w-[1.6rem] h-[1.6rem] rounded-full relative cursor-pointer border-primary grid place-items-center;
			&-active::after {
				content: '';
				@apply bg-primary w-[.6rem] h-[.6rem] rounded-full absolute;
			}
		}
	}

	&__bg {
		@apply absolute top-[20%] right-[14.5%] pointer-events-none;
	}
	@screen laptop {
		--swiper-height: 19.5rem;
		@apply py-[13rem];
		&__index {
			@apply text-[4rem];
		}
		&__review {
			@apply text-[6.6rem];
		}
		&__right {
			@apply flex flex-col items-center justify-center;
		}
		&__current-slide {
			@apply flex-1 relative flex flex-col-reverse justify-center items-center;
			&::before {
				content: '';
				z-index: 10;
				@apply max-h-[100%] h-full w-[2px] bg-primary block;
			}
		}
		&__pagination {
			@apply !inset-auto relative flex;
			transform: none !important;
			.swiper-pagination-bullet {
				@apply !flex items-center !m-0 justify-center;
			}
		}
	}
	@screen tablet {
		@apply py-[10rem];
	}
	@screen tabletver {
		@apply py-[7.5rem];
		&__slider {
			max-height: inherit;
			@apply h-auto flex-wrap;
		}
		&__swiper {
			@apply w-full;
		}
		&__bg {
			@apply hidden;
		}
		&__container {
			@apply max-w-[100%];
		}
		&__title {
			@apply text-center;
		}
		&__current-slide {
			@apply hidden;
		}
		&__right {
			@apply h-auto flex-row w-full;
			/* @apply h-auto flex-col-reverse items-center justify-center w-full; */
		}
		&__pagination {
			@apply flex-row w-full mt-[4rem] items-center;
			.swiper-pagination-bullet {
				@apply h-[1rem] w-[1rem];
				border: 0;
				background: rgba(191, 91, 53, 0.5);
				transition: all 0.5s ease-in-out;
				&:after {
					@apply hidden;
				}
				&-active {
					background: #bf5b35;
					@apply h-[1.3rem] w-[1.3rem];
				}
			}
		}
	}
	@screen mobile {
		@apply py-[5rem];
		&__review {
			@apply flex-wrap pt-[2rem];
			font-size: inherit;
		}
		&__picture {
			@apply h-[10rem] w-[10rem] mx-auto relative;
		}
		&__icon {
			@apply absolute top-[-2.3rem] right-[-4rem] text-[6rem];
		}
		&__image {
			@apply mt-0 w-full h-full rounded-[100%] overflow-hidden;
		}
		&__content {
			@apply text-[1.7rem] italic text-center mt-[1.5rem];
		}
		&__swiper {
			max-height: inherit;
		}
		&__a-title {
			@apply text-[1.9rem] text-center flex-col;
			/* &:before {
				@apply hidden;
			} */
			span {
				@apply text-[2.5rem] inline-block;
			}
		}
	}
}
</style>
