<template>
	<section class="h-services" id="services">
		<AppContainer class="h-services__container">
			<Information :title="title" :text="text" titleTag="h1" class="h-services__info" />
			<Swiper :options="swiperOptions" class="h-services__swiper" :cleanup-styles-on-destroy="false">
				<SwiperSlide v-for="(service, i) in services" :key="i" class="h-services__slide">
					<ServiceCardHome
						:title="service.name"
						:text="service.description"
						:img="service.thumbnail"
						:category="service.icon_image"
						:index="i"
						:slug="service.slug"
						:categoryLink="service.category_service"
						:subcategoryLink="service.subcategory_service"
						:slugLink="service.slug_service"
					/>
				</SwiperSlide>
			</Swiper>
			<div class="sh_pagination"></div>
		</AppContainer>
	</section>
</template>

<script>
export default {
	name: 'ServicesHome',
	components: {
		ServiceCardHome: () => import('../molecules/ServiceCardHome.vue'),
	},
	props: {
		title: String,
		text: String,
		services: Array,
	},
	data() {
		return {
			/** @type { import('swiper').SwiperOptions } */
			swiperOptions: {
				slidesPerView: 1,
				spaceBetween: 50,
				speed: 1500,
				loop: false,
				// autoplay: {
				//     delay: 6000,
				//     disableOnInteraction: false,
				// },
				breakpoints: {
					960: {
						slidesPerView: 2,
						spaceBetween: 30,
					},
					1200: {
						slidesPerView: 3,
						spaceBetween: 30,
						loop: false,
						allowTouchMove: false,
					},
					1700: {
						slidesPerView: 3,
						spaceBetween: 60,
						loop: false,
						allowTouchMove: false,
					},
				},
				pagination: {
					el: '.sh_pagination',
					clickable: true,
					type: 'bullets',
				},
			},
		};
	},
};
</script>

<style lang="postcss">
.h-services {
	&__container {
		@apply w-full;
		@media screen(md) {
			@apply max-w-[80%];
		}
		@media screen(xxlg) {
			@apply max-w-[70%];
		}
	}
	@apply py-[6rem];
	@media screen(xl) {
		@apply py-[8rem];
	}
	@media screen(design) {
		@apply py-[10rem];
	}
	@media screen(monitor) {
		@apply py-[12rem];
	}
	&__info {
		@apply text-center mb-8;
		p {
			@apply text-[.9em] max-w-[46ch] mx-auto;
			@media screen(md) {
				@apply text-[1em];
			}
			@media screen(xl) {
				@apply text-[1em];
			}
		}
	}

	&__swiper {
		@apply pt-[2rem];
	}

	&__slide {
		transition: all 0.5s ease;
		&:hover {
			transform: translateY(-2rem);
		}
	}
}

.sh_pagination {
	@apply w-full h-[2rem] flex items-center justify-center gap-[.7rem] mt-[3rem];
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
