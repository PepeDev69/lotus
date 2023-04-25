<template>
	<AppLayout>
		<InternalBanner
			:title="post.title_banner"
			:image="post.banner_image"
			:imageMobile="post.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<section class="blog-wrap">
			<AppContainer class="big blog-wrap__container">
				<div v-for="blog in posts" :key="blog.id" class="blog-wrap__item">
					<AppLink :to="{ name: 'blog-slug', params: { slug: blog.slug } }">
						<figure>
							<img :src="blog.thumbnail" :alt="blog.title" />
						</figure>
						<div class="blog-wrap__item__ctn">
							<Titles :title="blog.title" />
							<div v-html="contentSlice(blog.post_content)"></div>
							<span class="span-btn">{{ polylang.btn_read_more }}</span>
						</div>
						<div class="blog-wrap__item__date">
							<span>{{ formatDate(blog.post_date, 'day') }}</span>
							<span>{{ formatDate(blog.post_date, 'month') }}</span>
						</div>
					</AppLink>
				</div>
			</AppContainer>
		</section>
		<FormFooter />
	</AppLayout>
</template>

<script>
import { httpClient } from '@/plugins/http';
import { mapState } from 'vuex';
import { formatDateString } from '@/plugins/utils';
export default {
	name: 'BlogTemplate',
	components: {
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
		Information: () => import('~/components/molecules/Information.vue'),
		FormFooter: () => import('~/components/organisms/FormFooter.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		formatDate() {
			const locale = this.$i18n.locale;
			return (date, type) => {
				return formatDateString(locale, date, type);
			};
		},
	},
	methods: {
		contentSlice(content) {
			return content.slice(0, 150) + '...';
		},
	},
	async asyncData({ app }) {
		const locale = app.i18n.locale;
		const [{ data: post }, { data: posts }] = await Promise.all([
			httpClient.get(`/page?template=blog&seo=allow&lang=${locale}`),
			httpClient.get(`/posts?type=post&lang=${locale}`),
		]);
		return {
			post,
			posts,
		};
	},
};
</script>

<style lang="postcss">
.blog-wrap {
	@apply w-full py-[16rem];
	@media (min-width: 1200px) {
		&__container {
			@apply max-w-[78%];
		}
	}
	.section-ctn {
		@apply grid grid-cols-2 gap-x-[10.5rem] gap-y-[8.5rem];
	}
	&__item {
		@apply relative bg-white;
		box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
		transition: all 0.5s ease-in-out;
		a {
			@apply relative block w-full h-full;
		}
		figure {
			@apply overflow-hidden flex items-center justify-center max-h-[21rem];
			@media (min-width: 1200px) {
				@apply max-h-[32rem];
			}
			@media (min-width: 1400px) {
				@apply max-h-[36rem];
			}
			@media (min-width: 1700px) {
				@apply max-h-[44rem];
			}
			img {
				transition: all 0.5s ease-in-out;
			}
		}
		&__ctn {
			transition: all 0.5s ease-in-out;
			@apply bg-white py-[5rem] px-[3.3rem] flex flex-col items-start justify-center;
			.title-general {
				@apply text-[3rem] leading-[1.25];
			}
			p {
				@apply text-gray mt-[1rem];
			}
			span {
				font-family: 'Work-Sans', sans-serif;
				@apply text-[1.9rem] mt-[3rem] text-primary relative px-[3px] inline-block;
				/* &::before {
					content: '';
					background: rgba(57, 93, 100, 0.2);
					transition: all 0.5s ease-in-out;
					@apply absolute bottom-0 left-0 w-full h-[1.2rem] opacity-0;
				} */
			}
		}
		&__date {
			transition: all 0.5s ease-in-out;
			@apply absolute top-0 right-0 opacity-0 text-[1.8rem] bg-primary px-[2.3rem] py-[1.6rem] text-white flex flex-col gap-y-[3px];
			span {
				font-family: 'Rubik-Medium', sans-serif;
				@apply leading-none text-right;
			}
		}
		.span-btn {
			@apply relative;
			&::before {
				content: '';
				@apply absolute left-0 right-0 bottom-0 w-full h-[1.2rem] bg-primary/[.2] opacity-0;
				transition: opacity 350ms ease-in-out;
			}
		}
		@screen lg {
			&:hover {
				box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
				figure {
					img {
						transform: scale(1.1);
					}
				}
				.blog-wrap__item__ctn {
					a:before {
						@apply opacity-100;
					}
				}
				.blog-wrap__item__date {
					@apply opacity-100;
				}
				.span-btn {
					&::before {
						@apply opacity-100;
						transition: opacity 350ms ease-in-out;
					}
				}
			}
		}
	}
	@screen laptop {
		@apply py-[12rem];
		.section-ctn {
			@apply gap-x-[7rem] gap-y-[6rem];
		}
		&__item {
			&__ctn {
				@apply p-[3rem];
				.title-general {
					@apply text-[2.2rem];
					@media (min-width: 1400px) {
						@apply text-[2.3rem];
					}
				}
				span {
					@apply text-[1.6rem];
				}
			}
			&__date {
				@apply px-[1.8rem] py-[1rem] text-[1.6rem];
			}
		}
	}
	@screen tablet {
		@apply pt-[5rem] pb-[10rem];
		&__item {
			&__date {
				@apply opacity-100;
			}
		}
	}
	@screen tabletver {
		.section-ctn {
			@apply gap-x-[3rem] gap-y-[5rem];
		}
		&__item {
			&__ctn {
				@apply p-[2.5rem];
				.title-general {
					@apply text-[2.5rem];
				}
			}
		}
	}
	@screen mobile {
		@apply pb-[8rem];
		.section-ctn {
			@apply grid-cols-1;
		}
		&__item {
			&__ctn {
				@apply p-[2rem];
			}
		}
	}
}
</style>
