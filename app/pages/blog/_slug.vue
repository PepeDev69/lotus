<template>
	<AppLayout>
		<section class="post-wrap">
			<picture class="post-wrap__image">
				<source media="(min-width: 961px)" :srcset="post.banner_image" />
				<img :src="post.banner_image_mob" :alt="post.title" />
			</picture>
			<div class="post-wrap__ctn">
				<AppContainer class="big">
					<div class="post-wrap__ctn__info">
						<h1 class="post-wrap__ctn__title">{{ post.title }}</h1>
						<div class="post-wrap__ctn__post" v-html="post.post_content"></div>
					</div>
					<div class="post-wrap__ctn__lists">
						<AppLink
							class="post-wrap__ctn__lists__item"
							v-for="item in asidePosts"
							:key="item.id"
							:to="{ name: 'blog-slug', params: { slug: item.slug } }"
						>
							<figure class="post-wrap__ctn__lists__item__image">
								<img :src="item.thumbnail" :alt="item.title" />
							</figure>
							<h3 class="post-wrap__ctn__lists__item__title">{{ item.title }}</h3>
							<div v-html="contentSlice(item.post_content)"></div>
							<span class="span-btn">{{ polylang.btn_read_more }}</span>
						</AppLink>
					</div>
				</AppContainer>
			</div>
		</section>
		<FormFooter />
	</AppLayout>
</template>

<script>
import { mapState } from 'vuex';
import { httpClient } from '@/plugins/http';
export default {
	name: 'Post',
	components: {
		FormFooter: () => import('~/components/organisms/FormFooter.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		asidePosts() {
			return this.posts.filter(post => post.id !== this.post.id);
		},
	},
	methods: {
		contentSlice(content) {
			return content.slice(0, 130) + '...';
		},
	},
	async asyncData({ params, app }) {
		const locale = app.i18n.locale;
		const { data: post } = await httpClient.get(`/post?type=post&slug=${params.slug}&seo=allow&lang=${locale}`);
		const { data: posts } = await httpClient.get(`posts?type=post&lang=${locale}`);
		return {
			post,
			posts,
		};
	},
};
</script>

<style lang="postcss">
.post-wrap {
	@apply w-full;
	&__image {
		@apply w-full;
	}
	&__ctn {
		@apply w-full pt-[13.5rem] pb-[21rem];
		.section-ctn {
			@apply flex flex-wrap justify-between items-start;
		}
		&__info {
			@apply w-[60%];
		}

		&__title {
			font-family: 'Cormorant-Garamond-Bold', sans-serif;
			@apply text-[4.5rem] leading-none text-primary mb-[3.5rem];
		}
		&__post {
			h3 {
				font-family: 'Roboto', sans-serif;
				@apply text-[2.1rem] text-primary mb-[0.75em];
			}
			p {
				@apply mb-[2.5rem] last:mb-[0];
			}
			img {
				@apply mb-[6rem] w-full;
			}
		}
		&__lists {
			@apply w-[30%] border-solid border-[1px] border-gray-600;
			&__item {
				transition: all 0.5s ease-in-out;
				@apply p-[2rem] block;
				figure {
					@apply mb-[2.5rem];
				}
				&__title {
					font-family: 'Cormorant-Garamond-Bold', sans-serif;
					@apply leading-[1.25] text-[2.5rem] mb-[1.5rem] text-primary;
				}
				p {
					@apply text-[1.7rem] text-gray;
				}
				span {
					font-family: 'Work-Sans', sans-serif;
					@apply mt-[3rem] text-primary text-[1.7rem] inline-block;
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
						box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
						.span-btn {
							&::before {
								@apply opacity-100;
								transition: opacity 350ms ease-in-out;
							}
						}
					}
				}
			}
		}
	}
	@screen laptop {
		&__ctn {
			@apply pt-[10rem] pb-[18rem];
			&__post {
				h3 {
					@apply mb-[2.5rem] text-[2rem];
				}
				img {
					@apply mb-[5rem];
				}
			}
			&__title {
				@apply text-[3.5rem];
			}
			&__lists {
				&__item {
					@apply p-[1.5rem];
					&__title {
						@apply text-[2rem] mb-[1rem];
					}
					p {
						@apply text-[1.5rem];
					}
					span {
						@apply text-[1.5rem] mt-[2rem];
					}
				}
			}
		}
	}
	@screen tablet {
		&__ctn {
			@apply pt-[7.5rem] pb-[14rem];
			&__info {
				@apply w-full max-w-[80%] mx-auto;
			}
			&__post {
				h3 {
					@apply mb-[2rem] text-[1.9rem];
				}
				img {
					@apply mb-[4rem];
				}
			}
			&__title {
				@apply text-[3.2rem];
			}
			&__lists {
				@apply hidden;
			}
		}
	}
	@screen tabletver {
		&__ctn {
			&__info {
				@apply max-w-[inherit];
			}
		}
	}
	@screen mobile {
		&__ctn {
			@apply pt-[4rem] pb-[10rem];
			&__title {
				@apply text-[2.8rem];
			}
		}
	}
}

.post-wrap__ctn__post {
	ol {
		@apply flex flex-col items-start gap-[1em] list-decimal mb-[1em] pl-[2em];
	}
	p,
	li {
		@apply text-justify;
	}
}
</style>
