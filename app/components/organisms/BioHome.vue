<template>
	<section class="bioHome">
		<AppContainer class="bioHome__container">
			<Titles :title="title" class="bioHome__titlePrin" />
			<div class="ctnContent">
				<div class="bioHome__information">
					<h2 class="bioHome__information__title">
						<span class="span1"> {{ splited(subTitle, 0) }} </span>
						<span class="span2"> {{ splited(subTitle, 1) }} </span>
					</h2>
					<template>
						<div class="bioHome__information__text textGeneral" v-if="tag" v-html="text"></div>
						<p class="bioHome__information__text textGeneral" v-else>{{ text }}</p>
					</template>
				</div>
				<div class="bioHome__images">
					<picture class="bioHome__images__picture">
						<source media="(min-width: 961px)" :srcset="image" />
						<img :src="imageMob" :alt="title" />
					</picture>
				</div>
			</div>
		</AppContainer>
	</section>
</template>

<script>
export default {
	name: 'Client',
	props: {
		title: String,
		text: String,
		image: String,
		imageMob: String,
		subTitle: String,
	},
	computed: {
		splited() {
			return (str, offset) => {
				return str.split('/')[offset];
			};
		},
		tag() {
			return this.text.includes('</p>');
		},
	},
};
</script>

<style lang="postcss">
.bioHome {
	@apply w-full flex items-center justify-center py-[6rem] bg-lightblue/[0.1];
	&__container {
		@apply flex flex-col items-center justify-center;
	}
	.ctnContent {
		@apply flex flex-col items-center justify-center;
	}
	&__titlePrin {
		@apply w-full flex items-center justify-center mb-[3.5rem];
		.title-general {
			@apply text-center;
		}
	}

	&__information {
		@apply w-full flex flex-col;
		&__title {
			@apply flex flex-col items-start text-primary mb-[2rem];
			.span1 {
				@apply text-[1.2rem] uppercase font-bold tracking-[0.1em] relative;
				font-family: Roboto, sans-serif;
				&::before {
					content: "";
					@apply absolute right-[-1.5em] top-[50%] w-[1.2em] h-[0.15em] bg-primary;
					transform: translateY(-50%);
				}
			}
			.span2 {
				@apply text-[3rem] capitalize font-bold;
				font-family: 'Cormorant Garamond';
			}
		}
	}

	&__images {
		@apply w-full flex items-center justify-center mt-[3rem];
		&__picture {
			@apply w-full overflow-hidden rounded-[1rem];
			filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.3));
			img {
				@apply w-full object-cover;
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

	@media (min-width: 960px) {
		@apply py-[8rem] pb-[10rem];
		.ctnContent {
			@apply flex-row gap-[10%];
		}
		&__titlePrin {
			@apply mb-[6rem];
		}
		&__information {
			@apply w-[50%];
		}
		&__images {
			@apply w-[50%] mt-0;
			&__picture {
				@apply w-full;
			}
		}
	}

	@media (min-width: 1200px) {
		&__information {
			&__title {
				.span1 {
					@apply text-[1.3rem];
				}
				.span2 {
					@apply text-[3.2rem];
				}
			}
		}
	}

	@media (min-width: 1700px) {
		&__information {
			&__title {
				.span1 {
					@apply text-[1.5rem];
				}
				.span2 {
					@apply text-[3.8rem];
				}
			}
		}
	}

}
</style>
