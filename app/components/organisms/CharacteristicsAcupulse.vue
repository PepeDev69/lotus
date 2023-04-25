<template>
	<div class="charAcupulse">
		<AppContainer class="charAcupulse__container">
			<TitleArticle class="titleCharAcu" :title="title" />
			<div class="charInformation">
				<figure class="charInformation__figure">
					<img :src="image" alt="" />
					<span class="leftTop"></span>
					<span class="rightTop"></span>
					<span class="leftBottom"></span>
					<span class="rightBottom"></span>
				</figure>
				<div class="ctnCardChar">
					<div v-for="(char, index) in listChar" :key="index" class="cardGralChar" :class="[`card-${index + 1}`]">
						<span class="cardGralChar__number numberCard"> 0{{ index + 1 }} </span>
						<h3 class="cardGralChar__title" :class="[`titleCard-${index + 1}`]">{{ char.title }}</h3>
						<p class="cardGralChar__text textGeneral textCard" :class="[`textCard-${index + 1}`]">{{ char.content }}</p>
					</div>
				</div>
			</div>
		</AppContainer>
	</div>
</template>

<script>
export default {
	props: {
		title: String,
		listChar: Array,
		image: String,
	},
};
</script>

<style lang="postcss">
.charAcupulse {
	@apply w-full flex items-center justify-center;
	&__container {
		@apply flex flex-col items-center justify-center;
		@media screen(xl) {
			@apply max-w-[80%];
		}
	}
}

.titleCharAcu {
	@apply w-full flex items-center justify-center mb-[3.5rem];
	h2 {
		@apply text-center max-w-[32ch];
	}
}

.charInformation {
	@apply w-full flex flex-col items-center justify-center relative;
	&__figure {
		@apply w-full flex items-center justify-center relative py-[1.5rem] mb-[5rem];
		img {
			@apply w-full object-cover;
		}
		.leftTop {
			@apply absolute left-[8%] top-0 w-[2.5rem] h-[1rem];
			border-top: 2px solid #395d64;
			border-left: 2px solid #395d64;
		}
		.rightTop {
			@apply absolute right-[8%] top-0 w-[2.5rem] h-[1rem];
			border-top: 2px solid #395d64;
			border-right: 2px solid #395d64;
		}
		.leftBottom {
			@apply absolute left-[8%] bottom-0 w-[2.5rem] h-[1rem];
			border-bottom: 2px solid #395d64;
			border-left: 2px solid #395d64;
		}
		.rightBottom {
			@apply absolute right-[8%] bottom-0 w-[2.5rem] h-[1rem];
			border-bottom: 2px solid #395d64;
			border-right: 2px solid #395d64;
		}
	}
	@media (min-width: 520px) {
		@apply w-[75%];
	}
	@media screen(lg) {
		@apply flex-row w-full gap-[5%];
		&__figure {
			@apply w-[50%];
		}
	}
	@media screen(xl) {
		@apply w-full flex-col;
		&__figure {
			@apply w-[40%] mr-[5rem];
			@media (min-width: 1200px) {
				@apply w-[36%] mr-0;
			}
			@media (min-width: 1400px) {
				@apply mr-0 w-[40%];
			}
			@media (min-width: 1700px) {
				/* @apply mr-[5rem]; */
			}
			.leftTop {
				@apply w-[4rem] h-[4rem];
			}
			.rightTop {
				@apply w-[4rem] h-[4rem];
			}
			.leftBottom {
				@apply w-[4rem] h-[4rem];
			}
			.rightBottom {
				@apply w-[4rem] h-[4rem];
			}
		}
	}
}

.ctnCardChar {
	@apply flex flex-col gap-[2rem];
	@media screen(md) {
		@apply gap-[2.5rem];
	}
	@media screen(lg) {
		@apply w-[50%];
	}
}

.cardGralChar {
	@apply flex flex-col gap-[.5rem] relative pl-[5rem];
	@media (min-width: 1200px) {
		@apply w-[27ch];
	}
	@media (min-width: 1400px) {
		@apply w-[30ch];
	}
	@media (min-width: 1600px) {
		@apply w-[35ch];
	}
	&__number {
		font-family: 'Cormorant-Garamond', sans-serif;
		@apply text-[3rem] font-bold text-primary absolute top-0 left-0 leading-none;
	}
	&__title {
		font-family: Roboto, sans-serif;
		@apply text-primary text-[1.8rem] tracking-[0.01em] font-bold;
		@media (min-width: 1200px) {
			@apply max-w-[25ch];
		}
		@media (min-width: 1400px) {
			@apply max-w-[27ch];
		}
		@media (min-width: 1700px) {
			@apply max-w-[29ch];
		}
	}
	&__text {
		@media (min-width: 1200px) {
			@apply max-w-[35ch];
		}
		@media (min-width: 1400px) {
			@apply max-w-[33ch];
		}
		@media (min-width: 1700px) {
			@apply max-w-[29ch];
		}
	}
	@media screen(xl) {
		&__title {
			@apply text-[1.9rem];
			&.titleCard-1,
			&.titleCard-2,
			&.titleCard-3 {
				@apply text-right;
			}
		}
		&__text {
			&.textCard-1,
			&.textCard-2,
			&.textCard-3 {
				@apply text-right;
			}
			&.textCard-4,
			&.textCard-5,
			&.textCard-6 {
				@apply text-left max-w-[35ch];
			}
		}
		&.card-1,
		&.card-2,
		&.card-3 {
			@apply absolute left-0 top-[5rem] pl-0 pr-[5rem];
			.numberCard {
				@apply right-0 left-auto;
			}
		}
		&.card-2 {
			@apply top-[20rem];
		}
		&.card-3 {
			@apply top-[35rem];
		}
		&.card-4,
		&.card-5,
		&.card-6 {
			@apply absolute right-0 top-[5rem] pl-[5rem];
			.numberCard {
				@apply left-0 right-auto;
			}
		}
		&.card-5 {
			@apply top-[20rem];
		}
		&.card-6 {
			@apply top-[35rem];
		}
	}

	@media screen(design) {
		&__title {
			@apply text-[1.8rem];
		}
	}
	@media screen(monitor) {
		&__title {
			@apply text-[1.9rem];
		}
		&__text {
			@apply max-w-[30ch];
			&.textCard-1,
			&.textCard-2,
			&.textCard-3 {
				@apply text-right;
			}
			&.textCard-4,
			&.textCard-5,
			&.textCard-6 {
				@apply text-left max-w-[40ch];
			}
		}
		&.card-1,
		&.card-2,
		&.card-3 {
			@apply absolute left-0 top-[7rem] pl-0 pr-[5rem];
			.numberCard {
				@apply right-0 left-auto;
			}
		}
		&.card-2 {
			@apply top-[25rem];
		}
		&.card-3 {
			@apply top-[43rem];
		}
		&.card-4,
		&.card-5,
		&.card-6 {
			@apply absolute right-0 top-[7rem] pl-[5rem];
			.numberCard {
				@apply left-0 right-auto;
			}
		}
		&.card-5 {
			@apply top-[25rem];
		}
		&.card-6 {
			@apply top-[43rem];
		}
	}
}
</style>
