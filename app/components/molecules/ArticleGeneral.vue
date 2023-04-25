<template>
	<article class="ctnArticleGeneral" :class="{ bgActive: bgColor }">
		<AppContainer class="ctnArticleGeneral__container" :class="{ leftActive: imageLeft }">
			<div class="ctnArticleGeneral__information" :class="{ doubleActive: doubleImage }">
				<TitleArticle class="ctnArticleGeneral__information__title" :title="title" />
				<template>
					<div class="ctnArticleGeneral__information__text" v-if="tag" v-html="text"></div>
					<p class="ctnArticleGeneral__information__text" v-else>{{ text }}</p>
				</template>
				<ButtonGeneral class="green !rounded-[.5rem]" :path="{ name: 'contact-us' }" :text="btnText" />
			</div>
			<div v-if="listImages" class="ctnArticleGeneral__images" :class="{ doubleActive: doubleImage }">
				<picture
					v-for="(img, index) in listImages"
					:key="index"
					class="ctnArticleGeneral__images__picture"
					:class="[`picture${index + 1}`, { doubleActive: doubleImage }]"
				>
					<source media="(min-width: 961px)" :srcset="img.image" />
					<img :src="img.imageMob" :alt="title" />
				</picture>
			</div>
			<div v-else class="ctnArticleGeneral__images" :class="{ doubleActive: doubleImage }">
				<figure class="ctnArticleGeneral__images__picture" :class="[`picture1`, { doubleActive: doubleImage }]">
					<img :src="onlyImage" alt="" />
				</figure>
			</div>
		</AppContainer>
		<img v-if="bgImageActive" class="ctnArticleGeneral__bgImage" src="~/assets/img/bgAbout.png" alt="" />
	</article>
</template>

<script>
export default {
	name: 'CommonArticle',
	props: {
		title: String,
		text: String,
		btnText: String,
		listImages: Array,
		onlyImage: String,
		bgColor: {
			type: Boolean,
			default: false, //  TRUE para darle color al Background
		},
		imageLeft: {
			type: Boolean,
			default: false,
		},
		doubleImage: {
			type: Boolean,
			default: false,
		},
		bgImageActive: {
			type: Boolean,
			default: false,
		},
	},
	computed: {
		tag() {
			return this.text.includes('</p>');
		},
	},
};
</script>

<style lang="postcss">
.ctnArticleGeneral {
	@apply w-full flex items-center justify-center relative;
	&__bgImage {
		@apply hidden absolute right-0 bottom-0;
	}
	&__container {
		@apply flex flex-col items-start gap-[3rem];
	}
	&.bgActive {
		@apply bg-lightblue/[.05];
	}
	&__information {
		@apply w-full flex flex-col items-start;
		&__title {
			@apply mb-[1.5rem];
		}
		&__text {
			@apply text-[1.7rem] mb-[3rem];
		}
	}
	&__images {
		@apply w-full flex items-center justify-center relative;
		&__picture {
			@apply w-full overflow-hidden rounded-[1rem] flex items-center justify-center;
			filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.2));
			img {
				@apply w-full object-cover;
			}
			&.picture2 {
				@apply hidden;
			}
		}
	}

	@media (min-width: 520px) {
		&__images {
			&__picture {
				@apply w-[85%];
			}
		}
	}

	@media screen(md) {
		&__images {
			&__picture {
				@apply w-[75%];
			}
		}
	}
	@media screen(lg) {
		&__container {
			@apply flex-row items-center;
			&.leftActive {
				@apply flex-row-reverse;
			}
		}
		&__information {
			&.doubleActive {
				@apply w-[40%];
			}
			@apply w-[50%];
			&__text {
				@apply text-[1.6rem];
			}
		}
		&__images {
			&.doubleActive {
				@apply flex justify-start;
			}
			@apply w-[60%];
			&__picture {
				@apply w-auto;
				&.picture1.doubleActive {
					@apply w-[60%];
				}
				&.picture1 {
					@apply w-[90%];
				}
				&.picture2 {
					@apply absolute right-[3rem] bottom-[-3rem] flex w-[40%];
				}
			}
		}
	}

	@media screen(xl) {
		&__bgImage {
			@apply flex object-cover w-[32rem];
		}
		&__container {
			@apply max-w-[76%];
		}
		&__information {
			@apply pr-[5rem];
			&.doubleActive {
				@apply w-[50%] pr-0;
			}
			&__text {
				@apply text-[1.4rem];
			}
		}
		&__images {
			&.doubleActive {
				@apply w-[60%] items-start;
			}
			@apply w-[50%];
			&__picture {
				&.picture1.doubleActive {
					@apply w-[55%];
				}
				&.picture1 {
					@apply w-[90%];
				}
				&.picture2 {
					@apply right-[6rem] bottom-[-6rem] w-[42%];
				}
			}
		}
	}

	@media screen(design) {
		&__bgImage {
			@apply flex object-cover w-[35rem];
		}
		&__information {
			&__text {
				@apply text-[1.6rem];
			}
		}
	}

	@media screen(monitor) {
		&__bgImage {
			@apply w-[45rem];
		}
		&__information {
			&__title {
				@apply mb-[2.5rem];
			}
			&__text {
				@apply text-[1.9rem] mb-[3.5rem];
			}
		}
		&__images {
			&.doubleActive {
				@apply w-[60%] items-start;
			}
			@apply w-[50%];
			&__picture {
				&.picture1.doubleActive {
					@apply w-[53%];
				}
				&.picture1 {
					@apply w-[90%];
				}
				&.picture2 {
					@apply right-[10rem] bottom-[-10rem] w-[42%];
				}
			}
		}
	}
}
</style>
