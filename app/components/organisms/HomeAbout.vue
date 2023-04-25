<template>
	<section class="homeAbout">
		<AppContainer class="homeAbout__container">
			<div class="homeAbout__images">
				<picture class="homeAbout__images__picture" v-for="(slide, i) in slider" :key="i" :class="[`picture-${i + 1}`]">
					<source media="(min-width: 100px)" :srcset="slide.image" />
					<img :src="slide.image_mobile" :alt="title" />
				</picture>
			</div>
			<div class="homeAbout__information">
				<Information :title="title" :text="text" />
			</div>
		</AppContainer>
		<picture class="homeAbout__bg">
			<img :src="require('@/assets/img/bg-h-about.svg')" alt="bg-about" />
		</picture>
	</section>
</template>

<script>
export default {
	name: 'HomeAbout',
	props: {
		title: String,
		text: String,
		slider: Array,
	},
};
</script>

<style lang="postcss">
.homeAbout {
	@apply w-full flex items-center justify-center bg-linen py-[6rem] relative;
	&__container {
		@apply flex flex-col-reverse;
	}

	&__bg {
		@apply hidden;
	}

	&__images {
		@apply w-full flex items-center justify-center mt-[3rem];
		&__picture {
			@apply w-full overflow-hidden rounded-[1rem];
			filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.25));
			&.picture-2 {
				@apply hidden;
			}
		}
	}

	@media (min-width: 520px) {
		&__images {
			&__picture {
				@apply w-[75%];
			}
		}
	}

	@media (min-width: 768px) {
		&__images {
			&__picture {
				@apply w-[60%];
			}
		}
	}

	@media (min-width: 960px) {
		&__container {
			@apply flex-row gap-[10%] items-center;
		}
		&__information {
			@apply w-[50%];
			.textGeneral {
				@apply text-justify;
			}
		}
		&__images {
			@apply w-[50%];
			&__picture {
				@apply w-full;
			}
		}
	}

	@media (min-width: 1200px) {
		&__container {
			@apply gap-[10%];
		}
		&__bg {
			@apply flex absolute right-0 bottom-0;
			img {
				@apply w-[50%] object-cover;
			}
		}
		&__information {
			/* @apply w-[40%] pr-[5%]; */
			@apply w-[40%];
			.title-general {
				@apply text-[2.9rem];
			}
		}
		&__images {
			@apply flex items-start justify-start w-[48%] relative ml-[-5%];
			&__picture {
				@apply w-[75%];
				&.picture-2 {
					@apply flex absolute right-[-3rem] top-[50%] w-[38%];
					transform: translateY(-50%);
				}
			}
		}
	}

	@media (min-width: 1300px) {
		@apply py-[8rem];
		&__bg {
			img {
				@apply w-[70%];
			}
		}
	}

	@media (min-width: 1400px) {
		@apply py-[10rem];
		&__bg {
			@apply right-[2%];
			img {
				@apply w-[70%];
			}
		}
		&__images {
			@apply w-[50%];
		}
		&__information {
			.title-general {
				@apply text-[3.5rem];
			}
		}
	}

	@media (min-width: 1700px) {
		@apply py-[12rem];
		&__container {
			@apply gap-[2%];
		}
		&__information {
			@apply pr-[1%];
		}
		&__images {
			@apply w-[60%];
			&__picture {
				@apply w-[65%];
				&.picture-2 {
					@apply w-[32%] right-[10%];
				}
			}
		}
		&__bg {
			@apply right-[5%];
			img {
				@apply w-full;
			}
		}
	}
}
</style>
