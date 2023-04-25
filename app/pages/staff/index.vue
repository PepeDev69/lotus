<template>
	<AppLayout class="sec-staff">
		<div class="sec-staff__information">
			<h1 class="sec-staff__information__title">{{ polylang.title_staff }}</h1>
			<p class="sec-staff__information__text">{{ polylang.text_staff }}</p>
		</div>
		<div class="sec-staff__cards">
			<article class="sec-staff__card" v-for="(item, index) in staff" :key="index">
				<figure class="sec-staff__card__figure">
					<img :src="item.image" :alt="item.name" />
				</figure>
				<div>
					<h2 class="sec-staff__card__name">{{ item.name }}</h2>
					<h3 class="sec-staff__card__specialist">{{ item.specialist }}</h3>
				</div>
			</article>
		</div>
		<img class="sec-staff__down" src="~/assets/img/staff_down.png" />
		<img class="sec-staff__left" src="~/assets/img/staff_left.png" />
		<img class="sec-staff__right" src="~/assets/img/staff_right.png" />
	</AppLayout>
</template>

<script>
import { httpClient } from '@/plugins/http';
import { mapState } from 'vuex';
export default {
	name: 'Staff',
	components: {},
	computed: {
		...mapState(['common', 'polylang']),
	},
	async asyncData({ app, error }) {
		try {
			const locale = app.i18n.locale;
			const [{ data: staff }] = await Promise.all([httpClient.get(`/posts?type=staff&seo=allow&lang=${locale}`)]);
			return {
				staff,
			};
		} catch (er) {
			error({ statusCode: 404, message: 'Post not found' });
		}
	},
};
</script>

<style lang="postcss">
.sec-staff {
	@apply w-full flex flex-col items-center justify-center bg-[#3aa1b4]/[0.15] pb-[8rem] pt-[10rem] gap-[4rem] px-[3rem] relative;
	&__information {
		@apply flex flex-col items-center justify-center;
		&__title {
			@apply w-auto font-medium text-[3rem] text-primary relative text-center leading-[1] mb-[1.5rem];
			&::before {
				content: '';
				@apply w-[6px] h-[6px] rounded-full bg-primary absolute left-[-1.5rem] top-[50%];
				transform: translateY(-50%);
			}
			&::after {
				content: '';
				@apply w-[6px] h-[6px] rounded-full bg-primary absolute right-[-1.5rem] top-[50%];
				transform: translateY(-50%);
			}
			font-family: 'Cormorant-Garamond-SemiBold', sans-serif;
		}
		&__text {
			@apply w-auto max-w-[36ch] text-center;
		}
	}
	&__cards {
		@apply flex flex-col items-center justify-center gap-[6rem];
	}
	&__card {
		@apply w-full flex flex-col items-center justify-center;
		&__figure {
			@apply w-[24rem] h-[24rem] rounded-full overflow-hidden flex items-center justify-center;
			@apply border-[1.5px] border-solid border-primary p-[.5rem] mb-[4rem];
			img {
				@apply w-full h-full object-cover rounded-full;
			}
		}
		&__name {
			@apply w-auto font-medium text-[2.8rem] text-primary relative text-center leading-[1] mb-[1rem];
			font-family: 'Cormorant-Garamond-SemiBold', sans-serif;
			&::before {
				content: '';
				@apply w-[2.7rem] h-[2px] bg-primary absolute top-[-1.5rem] left-[50%];
				transform: translateX(-50%);
			}
		}
		&__specialist {
			@apply w-auto font-light text-[2.2rem] text-primary text-center tracking-[-0.02em] leading-[1];
			font-family: 'Cormorant-Garamond-SemiBold', sans-serif;
		}
	}
	&__down,
	&__left,
	&__right {
		@apply hidden;
	}
	@media (min-width: 768px) {
		&__information {
			&__text {
				@apply max-w-[60ch];
			}
		}
		&__cards {
			@apply grid grid-cols-2 grid-flow-row gap-[10rem];
		}
	}
	@media (min-width: 960px) {
		&__cards {
			@apply gap-[8rem];
		}
		&__card {
			@apply flex-row gap-[3rem] justify-start;
			&__figure {
				@apply mb-0 w-[22rem] h-[22rem];
			}
			&__name {
				@apply text-left;
				&::before {
					@apply left-0 top-[-2rem];
					transform: none;
				}
			}
			&__specialist {
				@apply text-left;
			}
		}
	}
	@media (min-width: 1200px) {
		@apply pt-[8rem] pb-[15rem] gap-[5rem];
		&__information {
			&__title {
				@apply text-[3.4rem];
			}
			&__text {
				@apply max-w-[75ch];
			}
		}
		&__cards {
			@apply gap-x-[12rem] gap-y-[6rem];
		}
		&__card {
			&__name {
				@apply text-[2.4rem];
				&::before {
					@apply w-[2.2rem];
				}
			}
			&__specialist {
				@apply text-[1.9rem];
			}
		}
		&__down,
		&__left,
		&__right {
			@apply flex absolute;
		}
		&__down {
			@apply right-0 bottom-0 w-[32rem];
		}
		&__left {
			@apply left-[7rem] top-[38rem] w-[9rem];
		}
		&__right {
			@apply top-[7rem] right-[10rem] w-[14rem];
		}
	}
	@media (min-width: 1400px) {
		@apply pt-[10rem];
		&__information {
			&__title {
				@apply text-[3.9rem];
			}
		}
		&__cards {
			@apply gap-x-[16rem] gap-y-[8rem];
		}
		&__card {
			&__figure {
				@apply w-[24rem] h-[24rem];
			}
			&__name {
				@apply text-[2.6rem];
				&::before {
					@apply h-[1.5px];
				}
			}
			&__specialist {
				@apply text-[2.1rem];
			}
		}
		&__down {
			@apply w-[33rem];
		}
		&__left {
			@apply w-[9.5rem] top-[40rem];
		}
		&__right {
			@apply w-[16rem];
		}
	}
	@media (min-width: 1700px) {
		@apply gap-[10rem] pt-[12rem];
		&__information {
			&__title {
				@apply text-[5rem];
			}
		}
		&__cards {
			@apply gap-x-[20rem];
		}
		&__card {
			@apply gap-[5rem];
			&__figure {
				@apply w-[28rem] h-[28rem];
			}
			&__name {
				@apply text-[3.3rem];
				&::before {
					@apply h-[2px] w-[2.5rem];
				}
			}
			&__specialist {
				@apply text-[2.7rem];
			}
		}
		&__down {
			@apply w-[44rem];
		}
		&__left {
			@apply w-[12rem] top-[49rem] left-[11rem];
		}
		&__right {
			@apply w-[20rem] right-[15rem];
		}
	}
}
</style>
