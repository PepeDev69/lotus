<template>
	<section class="technologiesLegent">
		<AppContainer class="technologiesLegent__container">
			<div class="ctnTechInfo">
				<TitleArticle class="ctnTechInfo__title" :title="title" />
				<template>
					<div class="textGeneral ctnTechInfo__text" v-if="tag" v-html="text"></div>
					<p class="textGeneral ctnTechInfo__text" v-else>{{ text }}</p>
				</template>
			</div>
			<div class="tp-tech tp-tech-wrapper">
				<Swiper :options="swiperOptions" class="tp-tech__swiper" :cleanup-styles-on-destroy="false">
					<SwiperSlide v-for="(tech, index) in listTech" :key="index" class="tp-tech__swiper__slide">
						<div class="ptech-card">
							<figure class="ptech-card__figure">
								<img :src="tech.picture" alt="" />
							</figure>
							<div class="ptech-card__info">
								<h3 class="ptech-card__info__title">{{ tech.title }}</h3>
								<p class="ptech-card__info__text textGeneral textCard">{{ tech.content }}</p>
							</div>
						</div>
					</SwiperSlide>
				</Swiper>
				<div class="tech__pagination"></div>
			</div>
		</AppContainer>
	</section>
</template>

<script>
export default {
	name: 'TechnologiesLegend',
	props: {
		title: String,
		text: String,
		listTech: Array,
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
					slidesPerView: 2,
					spaceBetween: 50,
					allowTouchMove: false,
				},
			},
			pagination: {
				el: '.tech__pagination',
				type: 'bullets',
				clickable: true,
			},
		},
	}),
};
</script>

<style lang="postcss">
.technologiesLegent {
	@apply w-full flex items-center justify-center;
	&__container {
		@apply flex flex-col items-center justify-center gap-[5rem];
	}
	@media screen(xl) {
		&__container {
			@apply max-w-[76%];
		}
	}
}

/* Container Info */
.ctnTechInfo {
	@apply w-full flex flex-col;
	&__title {
		@apply w-full flex items-center justify-center text-center mb-[1.5rem];
	}
	&__text {
		@apply text-center;
	}
}

.tp-tech {
	@apply w-full overflow-hidden;
	&__swiper {
		&__slide {
			@apply flex items-center justify-center p-[1rem] h-auto;
		}
	}
	@media screen(md) {
		@apply w-[90%];
	}
	@media screen(xl) {
		@apply w-full;
	}
	@media screen(design) {
		&-wrapper {
			width: 75%;
		}
	}
}

.ptech-card {
	@apply w-full h-full flex flex-col rounded-[1rem] bg-white;
	filter: drop-shadow(0px 0px 5px rgba(0, 0, 0, 0.3));
	&__figure {
		@apply w-full overflow-hidden;
		border-radius: 1rem 1rem 0 0;
		img {
			@apply w-full object-cover;
		}
	}
	&__info {
		@apply px-[3rem] pt-[3rem] pb-[4rem];
		&__title {
			font-family: Roboto, sans-serif;
			@apply font-bold text-[1.9rem] text-primary pb-[1.5rem];
		}
	}

	@media (min-width: 520px) {
		@apply w-[75%];
	}

	@media screen(md) {
		@apply w-full;
	}
}

.tech__pagination {
	@apply w-full h-[2rem] flex items-center justify-center gap-[1rem] mt-[1.5rem];
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
