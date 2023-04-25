<template>
	<div v-if="sliderActive" class="secSolutionsBenefits">
		<AppContainer class="secSolutionsBenefits__containerTwo">
			<TitleArticle class="titleSolutionsBenefits" :title="title" />
			<div class="sliderSolutionsBenefits">
				<Swiper :options="swiperOptions" class="swiperBenefits" :cleanup-styles-on-destroy="false">
					<SwiperSlide v-for="(slide, index) in listBenefits" :key="index" class="swiperBenefits__slide">
						<div class="cardBenefits">
							<figure class="cardBenefits__figure">
								<img :src="slide.image" alt="" />
							</figure>
							<h3 class="cardBenefits__title">{{ slide.title }}</h3>
							<div class="flex-1 xl:hidden"></div>
							<p class="textGeneral cardBenefits__text">
								{{ slide.content }}
							</p>
						</div>
					</SwiperSlide>
				</Swiper>
				<div class="benefits__pagination"></div>
			</div>
		</AppContainer>
	</div>
	<div v-else class="secSolutionsBenefits">
		<AppContainer class="secSolutionsBenefits__container">
			<div class="ctnInfoSolutionsBenefits">
				<TitleArticle class="titleSolutionsBenefits" :title="title" />
				<template>
					<div class="textGeneral textSolutionsBenefits" v-if="tag" v-html="text"></div>
					<p class="textGeneral textSolutionsBenefits" v-else>{{ text }}</p>
				</template>
				<ButtonGeneral class="green" :text="btnText" />
			</div>
			<div class="ctnImageSolutionsBenefits">
				<figure class="ctnImageSolutionsBenefits__figure">
					<img :src="image" alt="" />
				</figure>
			</div>
		</AppContainer>
	</div>
</template>

<script>
export default {
	props: {
		sliderActive: {
			type: Boolean,
			default: false,
		},
		title: String,
		text: String,
		btnText: String,
		listBenefits: Array,
		image: String,
	},
	computed: {
		tag() {
			return this.text.includes('</p>');
		},
	},
	data: () => ({
		/** @type { import('swiper').SwiperOptions } */
		swiperOptions: {
			slidesPerView: 1,
			spaceBetween: 20,
			speed: 1500,
			breakpoints: {
				960: {
					slidesPerView: 2,
					spaceBetween: 30,
				},
				1200: {
					slidesPerView: 4,
					spaceBetween: 35,
					allowTouchMove: false,
				},
				1700: {
					slidesPerView: 4,
					spaceBetween: 25,
					allowTouchMove: false,
				},
			},
			pagination: {
				el: '.benefits__pagination',
				type: 'bullets',
				clickable: true,
			},
		},
	}),
};
</script>

<style lang="postcss">
.secSolutionsBenefits {
	@apply w-full py-[6rem] bg-lightblue/[.05];
	&__container {
		@apply flex flex-col gap-[3rem];
	}

	/* Containers */
	.ctnInfoSolutionsBenefits {
		@apply w-full;
	}
	.ctnImageSolutionsBenefits {
		@apply hidden;
	}

	.titleSolutionsBenefits {
		@apply w-full flex items-center text-center mb-[1.5rem];
		h2 {
			@apply max-w-[37ch];
		}
	}
	.textSolutionsBenefits {
		@apply mb-[3rem] flex flex-col gap-[.8rem];
		p {
			@apply flex flex-col gap-[.5rem];
		}
		ul {
			@apply w-full flex flex-col items-start gap-[.5rem];
			li {
				@apply flex items-start;
				&::before {
					content: '\2022';
					@apply text-gray font-bold mr-[.8em];
					display: inline-block;
				}
			}
		}
	}

	@media screen(md) {
		.ctnImageSolutionsBenefits {
			@apply flex items-center justify-center;
			&__figure {
				@apply w-[75%] overflow-hidden rounded-[1rem];
				filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.2));
				img {
					@apply w-full object-cover;
				}
			}
		}
	}

	@media screen(lg) {
		&__container {
			@apply flex-row-reverse;
		}
		.ctnInfoSolutionsBenefits {
			@apply w-[45%];
		}
		.ctnImageSolutionsBenefits {
			@apply w-[50%];
			&__figure {
				@apply w-[90%];
			}
		}
	}

	@media screen(xl) {
		&__container {
			@apply max-w-[76%];
		}
		&__containerTwo {
			@apply max-w-[80%];
		}
		.ctnInfoSolutionsBenefits {
			@apply w-[50%] pl-[5rem];
		}
	}

	@media screen(monitor) {
		@apply py-[10rem];
		&__containerTwo {
			@apply max-w-[76%];
		}
	}

	.sliderSolutionsBenefits {
		@apply w-full pt-[1.5rem];
	}
}

.swiperBenefits {
	&__slide {
		@apply flex items-center justify-center p-[1rem] h-auto;
		@media screen(xl) {
			@apply p-0;
		}
	}
}

.cardBenefits {
	@apply bg-white rounded-[1rem] py-[3rem] px-[3.5rem] flex flex-col items-start h-full;
	filter: drop-shadow(0px 0px 6px rgba(0, 0, 0, 0.25));
	&__title {
		font-family: Roboto, sans-serif;
		@apply text-[1.8rem] text-primary font-bold leading-[1.4] my-[1rem];
	}
	@media (min-width: 520px) {
		@apply w-[80%];
	}
	@media screen(md) {
		@apply w-[75%];
		&__title {
			@apply text-[2.1rem];
		}
	}
	@media screen(lg) {
		@apply w-full;
	}
	@media screen(xl) {
		filter: none;
		@apply bg-transparent px-0;
		&__figure {
			@apply w-[4rem];
		}
		&__title {
			@apply text-[1.4rem];
		}
	}

	@media screen(design) {
		&__title {
			@apply text-[1.6rem];
		}
		&__figure {
			@apply w-[5rem];
		}
	}

	@media screen(monitor) {
		&__title {
			@apply text-[1.9rem];
		}
	}
}

.benefits__pagination {
	@apply w-full h-[2rem] flex items-center justify-center gap-[1rem] mt-[3rem];
	.swiper-pagination-bullet {
		@apply !m-0 w-[1rem] h-[1rem] rounded-full bg-primary/[0.5];
		transition: background-color 300ms ease-in-out;
		&-active {
			@apply bg-primary;
			transition: background-color 300ms ease-in-out;
		}
	}
	@media screen(xl) {
		@apply hidden;
	}
}
</style>
