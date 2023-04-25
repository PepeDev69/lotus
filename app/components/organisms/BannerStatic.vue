<template>
	<section class="homeBanner">
		<AppContainer class="homeBanner__container">
			<picture class="homeBanner__picture">
				<img class="homeBanner__picture__img" :src="image" :alt="title" />
				<img class="homeBanner__picture__imgLeft" src="~/assets/img/bg-leftimg-banner.svg" alt="decoration" />
				<img class="homeBanner__picture__imgRight" src="~/assets/img/bg-rightimg-banner.svg" alt="decoration" />
			</picture>
			<div class="homeBanner__information">
				<h3 class="homeBanner__information__title">{{ titleSplited[0] }}</h3>
				<h4 class="homeBanner__information__subtitle">{{ titleSplited[1] }}</h4>
			</div>
		</AppContainer>
		<picture class="homeBanner__bgImage">
			<img src="~/assets/img/bg-right-banner.svg" alt="banner background" />
		</picture>
	</section>
</template>

<script>
export default {
	name: 'BannerStatic',
	props: {
		image: String,
		title: String,
	},
	computed: {
		titleSplited() {
			return this.title.split('/').map(w => w.trim());
		},
	},
};
</script>

<style lang="postcss">
.homeBanner {
	@apply w-full flex items-center justify-center pt-[6rem] pb-[15rem] bg-pink relative;
	&__container {
		@apply flex flex-col;
	}

	&__picture {
		@apply hidden;
	}

	&__information {
		@apply w-full flex flex-col items-center justify-center;
		&__title {
			font-family: 'Cormorant Garamond';
			@apply text-[3rem] text-primary font-bold text-center leading-[1.2] max-w-[25ch];
		}
		&__subtitle {
			font-family: 'Cormorant Garamond';
			@apply text-[3rem] text-brown font-bold text-center leading-[1.2] relative;
			&::before {
				content: '\2022';
				@apply absolute left-[-.8em] top-[50%];
				transform: translateY(-50%);
				@media (max-width: 380px) {
					@apply left-[-5px];
				}
			}
			&::after {
				content: '\2022';
				@apply absolute right-[-.8em] top-[50%];
				transform: translateY(-50%);
				@media (max-width: 380px) {
					@apply right-[-5px];
				}
			}
		}
	}

	&__bgImage {
		@apply absolute bottom-0 left-0 right-0 mx-auto flex items-center justify-center w-[35rem];
		img {
			@apply w-full object-cover;
		}
	}

	@media screen(md) {
		@apply pb-[24rem];
		&__bgImage {
			@apply w-[50rem];
		}
	}
	@media screen(lg) {
		@apply py-0;
		&__container {
			@apply flex-row items-center justify-center;
		}
		&__bgImage {
			@apply w-[30%] right-0 left-auto;
		}
		&__picture {
			@apply ml-[-5%] w-[80%] flex items-center justify-center relative;
			&__img {
				@apply w-full object-cover z-[2];
			}
			&__imgLeft {
				@apply absolute left-[5%] top-0 w-[28%] z-[1];
			}
			&__imgRight {
				@apply absolute right-[12%] bottom-0 w-[28%] z-[1];
			}
		}
		&__information {
			@apply w-[50%] mb-[7%];
		}
	}

	@media screen(xl) {
		&__picture {
			@apply ml-[-10%];
		}
		&__information {
			&__title {
				@apply text-[3.6rem] max-w-[30ch];
			}
			&__subtitle {
				@apply text-[3.6rem];
			}
		}
	}
	@media screen(design) {
		&__information {
			&__title {
				@apply text-[4rem];
			}
			&__subtitle {
				@apply text-[4rem];
			}
		}
		&__bgImage {
			@apply w-[25%] right-0 left-auto;
		}
	}
	@media screen(monitor) {
		&__information {
			@apply mb-[2%];
			&__title {
				@apply text-[5rem];
			}
			&__subtitle {
				@apply text-[5rem];
			}
		}
		&__bgImage {
			@apply w-[25%] right-0 left-auto;
		}
	}
	@media (min-width: 768px) and (max-width: 991px) {
		@apply !pb-[21rem];
	}
}
</style>
