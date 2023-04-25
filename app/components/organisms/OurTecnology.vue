<template>
	<div class="our-tecnology">
		<AppContainer variant="extra" class="our-tecnology__container">
			<div class="our-tecnology-titles">
				<h2 class="our-tecnology-titles-title">{{ title }}</h2>
				<p class="our-tecnology-titles-description">{{ description }}</p>
			</div>
			<div class="our-tecnology-cards">
				<Swiper :options="swiperOptions" :cleanup-styles-on-destroy="false" class="mx-0">
					<SwiperSlide v-for="(card, i) in newList" :key="i" class="our-tecnology-cards-wrapper">
						<AppLink class="our-tecnology-cards-card" :to="{ name: card.slug }">
							<div class="our-tecnology-cards-card-img">
								<img :src="card.picture" :alt="card.slug" />
							</div>
							<div class="our-tecnology-cards-card-content">
								<h3 class="our-tecnology-cards-card-content-title">
									{{ card.post_title }}
								</h3>
								<p class="our-tecnology-cards-card-content-description textGeneral">
									{{ card.home_content }}
								</p>
								<div class="flex-1"></div>
								<button class="our-tecnology-cards-card-content-btn">
									{{ polylang.btn_see_more }}
								</button>
							</div>
						</AppLink>
					</SwiperSlide>
				</Swiper>
			</div>
			<div class="our-tecnology-mobile-paginations"></div>
		</AppContainer>
	</div>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'OurTecnology',
	props: {
		title: String,
		description: String,
		cards: Array,
		newList: [Object, Array],
	},
	computed: {
		...mapState(['polylang']),
		titleSplited() {
			return this.title.split('/').map(w => w.trim());
		},
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
					delay: 6000000,
					disableOnInteraction: false,
				},
				breakpoints: {
					768: {
						slidesPerView: 2,
						spaceBetween: 30,
					},
					960: {
						slidesPerView: 2,
						spaceBetween: 50,
					},
					1200: {
						slidesPerView: 3,
						spaceBetween: 0,
						allowTouchMove: false,
					},
				},
				pagination: {
					el: '.our-tecnology-mobile-paginations',
					clickable: true,
					type: 'bullets',
				},
			},
		};
	},
};
</script>

<style lang="postcss">
.our-tecnology {
	font-size: 16px;
	--size-scoop: 1.6;
	@media (min-width: 1200px) {
		&__container {
			@apply !max-w-[82%];
		}
	}
}
/* //? DESKTOP */
.our-tecnology {
	font-size: 11.35px;
	--size-scoop: 1.135;

	display: flex;
	flex-direction: column;
	gap: 1.875em;
	padding-top: 4em;
	@media (min-width: 1200px) {
		@apply pt-[7.125em];
	}
	padding-bottom: 4.688em;
	&-titles {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		gap: 1em;
		margin-bottom: 3rem;
		&-title {
			/* font-family: 'Cormorant Garamond'; */
			font-style: normal;
			font-size: 3.438em;
			line-height: 100%;
			text-align: center;
			letter-spacing: -0.02em;
			@apply text-primary;
		}
		&-description {
			font-family: 'Roboto-Light';
			font-style: normal;
			text-align: center;
			letter-spacing: calc(var(--size-scoop) * 0.02rem);
			@apply text-gray;
			@apply max-w-[55ch];
		}
	}
	&-cards {
		display: flex;
		justify-content: center;
		gap: 3.063em;
		&-wrapper {
			@apply p-[1rem] flex items-center justify-center;
			@media (min-width: 768px) {
				@apply items-start;
			}
			@media (min-width: 1200px) {
				@apply py-[2.5rem] px-[1.5rem];
			}
		}
		&-card {
			@apply bg-[#f5f4f4] w-full flex flex-col items-center gap-[1.938em] rounded-[1rem] h-full;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);
			padding: 2.5em 2.125em;
			transition: background 0.27s ease-in, filter 0.27s ease-in;

			@media (min-width: 520px) {
				@apply w-[80%];
			}
			@media (min-width: 768px) {
				@apply w-full;
			}
			@media (min-width: 1200px) {
				@apply rounded-none;
				box-shadow: none;
				&:hover {
					background-color: #fff;
					filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.3));
				}
			}
			&-img {
				img {
					width: 100%;
					height: 100%;
					aspect-ratio: 495/359;
					object-fit: cover;
					object-position: center;
				}
			}
			&-content {
				display: flex;
				flex-direction: column;
				height: 100%;
				margin: 1em 0;
				&-title {
					font-family: 'Cormorant-Garamond-Bold';
					font-style: normal;
					font-size: 1.688em;
					line-height: 100%;
					letter-spacing: 0.02em;
					@apply text-primary;
					@media (min-width: 1400px) {
						@apply text-[1.9em];
					}
					@media (min-width: 1700px) {
						@apply text-[2.7rem];
					}
				}
				&-description {
					font-family: 'Roboto-Light';
					font-style: normal;
					line-height: 1.6;
					letter-spacing: 0.02em;
					@apply text-gray;
					margin-top: 0.7em;
					margin-bottom: 1em;
				}
				&-btn {
					/* background: #395d64; */
					@apply bg-primary;
					border: 0.094em solid #395d64;
					border-radius: 0.313em;
					padding: 0.7em 1.5em;
					font-family: 'Rubik-Medium';
					font-style: normal;
					/* font-weight: 500; */
					font-size: 1em;
					line-height: 100%;
					letter-spacing: 0.02em;
					color: #ffffff;
					align-self: baseline;
				}
			}
		}
	}
}
.our-tecnology-mobile-paginations {
	@apply flex gap-[1rem] justify-center items-center mt-[30px];
	@media (min-width: 1200px) {
		display: none;
	}
	.swiper-pagination-bullet {
		@apply w-[1rem] h-[1rem] block rounded-full;
		background-color: #395d6480;
		&-active {
			@apply w-[1.3rem] h-[1.3rem];
			background-color: #395d64;
		}
	}
}
</style>
