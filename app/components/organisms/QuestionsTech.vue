<template>
	<section class="questionsTech">
		<AppContainer class="questionsTech__container">
			<div class="questionsTech__container__info">
				<TitleArticle :title="title" />
				<div class="cardAccordion">
					<div
						class="cardAccordion__item"
						v-for="(faq, index) in listQuestions"
						:key="index"
					>
						<div class="cardAccordion__item__question" @click="toggle(index)">
							<h3>{{ faq.title }}</h3>
						</div>
						<AppTransitionExpand>
							<div v-if="index == currentDrop" class="cardAccordion__item__answer">
								<div class="cardAccordion__item__internal" v-html="faq.content" />
							</div>
						</AppTransitionExpand>
						<div class="cardAccordion__item__icon"></div>
					</div>
				</div>
			</div>
			<div class="questionsTech__container__image">
				<figure class="figureFAQ">
					<img :src="image" alt="" />
				</figure>
			</div>
		</AppContainer>
	</section>
</template>

<script>
export default {
	components: { 
		AppTransitionExpand: () => import('@/components/animation/AppTransitionExpand.vue').then(e => e.default)
	},
	props: {
		title: String,
		listQuestions: Array,
		image: String,
	},
	methods: {
		toggle(index) {
			this.currentDrop = index;
		},
	},
	data() {
		return {
			currentDrop: 0,
		};
	},
};
</script>

<style lang="postcss">
.questionsTech {
	@apply w-full flex items-center justify-center bg-primary/[0.05];
	&__container {
		@apply flex flex-col;
		&__image {
			@apply hidden;
		}
		@media screen(lg) {
			@apply flex-row-reverse items-center justify-center;
			&__info {
				@apply w-[50%];
			}
			&__image {
				@apply flex w-[50%];
			}
			.figureFAQ {
				@apply w-[120%] ml-[-30%] overflow-hidden;
				filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.25));
				border-top-right-radius: 1rem;
				border-bottom-right-radius: 1rem;
				img {
					@apply w-full object-cover;
				}
			}
		}
		@media screen(xl) {
			@apply flex-row-reverse items-center justify-center;
			&__info {
				@apply w-[50%];
			}
			&__image {
				@apply flex w-[50%];
			}
			.figureFAQ {
				@apply w-[130%] ml-[-45%] overflow-hidden;
				filter: drop-shadow(0px 0px 10px rgba(0, 0, 0, 0.25));
				border-top-right-radius: 1rem;
				border-bottom-right-radius: 1rem;
				img {
					@apply w-full object-cover;
				}
			}
		}
	}
}

.cardAccordion {
	@apply w-full flex flex-col gap-[1.5rem] mt-[3rem];
	&__item {
		@apply w-full relative overflow-hidden bg-white;
		&__question {
			@apply py-[2rem] pl-[2.5rem] pr-[4rem] cursor-pointer;
			h3 {
				font-family: Roboto, sans-serif;
				@apply font-normal text-primary text-[1.8rem] max-w-[24ch];
				@media screen(xl) {
					@apply max-w-[95%];
				}
				@media screen(monitor) {
					@apply text-[2rem];
				}
			}
		}
		&__answer {
			@apply relative bg-white w-full px-[2.5rem];
			&__text {
				@apply pb-[2rem];
			}
			ul {
				padding-top: 0.5em;
			}
			p:not(:last-of-child) {
			}
			ul li {
				&::before {
					content: '';
					width: 0.4em;
					height: 2px;
					background-color: #606060;
					display: inline-block;
					vertical-align: middle;
					margin: auto 0.6em;
				}
			}
		}
		&__internal {
			padding-bottom: 2.5rem;
		}
		&__icon {
			@apply absolute right-[2.5rem] top-[2.5rem] w-[2.2rem] h-[2.2rem] bg-primary/[0.15] pointer-events-none;
			transition: background-color 400ms ease-in-out;
			&.active {
				@apply bg-primary;
				transition: background-color 400ms ease-in-out;
				&::after {
					@apply text-white;
					transition: color 400ms ease-in-out;
				}
			}
			&::after {
				content: '+';
				@apply w-full h-full flex items-center justify-center font-bold text-primary text-[2rem];
				transition: color 400ms ease-in-out;
			}
			&.active {
				&::after {
					content: '-';
				}
			}
		}
	}
}

.slide-drop-enter,
.slide-drop-leave-to {
	max-height: 0;
}
</style>
