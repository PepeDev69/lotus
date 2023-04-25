<template>
	<AppLayout>
		<BannerPrin :slider="post.slider_banner_home" :label="post.label_banner_home" :labelTwo="polylang.title_contact_poly" />
		<ServicesHome :title="post.title_services_home" :text="post.content_services_home" :services="services" />
		<ProductsHome
			:title="post.title_featured_home"
			:text="post.content_featured_home"
			:products="products"
			:label="polylang.btn_see_more"
		/>
		<HomeAbout :slider="post.list_about_home" :title="post.title_about_home" :text="post.content_about_home" />
		<Reviews :title="post.title_reviews_home" :reviews="post.slider_reviews_home" />
		<BannerStatic :image="post.image_static_home" :title="post.title_static_home" />
		<OurTecnology :title="post.tech_home_title" :description="post.tech_home_description" :cards="tech" :newList="listTech" />
		<!-- <BioHome
			:title="post.title_staff_home"
			:subTitle="post.name_staff_home"
			:text="post.content_staff_home"
			:image="post.image_staff_home"
			:imageMob="post.image_mob_staff_home"
		/> -->
		<Promotions
			:image="post.promocion_image"
			:imageMob="post.promocion_image_mob"
			:category="post.category_promo"
			:nameCategory="post.name_category_promo"
			:slug="post.slug_promo"
			:discount="post.discount_promo"
		/>
		<FormFooter class="mt-[2em]" />
	</AppLayout>
</template>

<script>
import { httpClient } from '@/plugins/http';
import { mapState } from 'vuex';
export default {
	name: 'Home',
	components: {
		BannerPrin: () => import('~/components/organisms/BannerPrin.vue'),
		ServicesHome: () => import('~/components/organisms/ServicesHome.vue'),
		ProductsHome: () => import('~/components/organisms/ProductsHome.vue'),
		HomeAbout: () => import('~/components/organisms/HomeAbout.vue'),
		Reviews: () => import('~/components/organisms/Reviews.vue'),
		BannerStatic: () => import('~/components/organisms/BannerStatic.vue'),
		OurTecnology: () => import('~/components/organisms/OurTecnology.vue'),
		Promotions: () => import('~/components/molecules/Promotions.vue'),
		FormFooter: () => import('~/components/organisms/FormFooter.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		listTech() {
			if (this.locale === 'en') {
				return this.tech.slice().reverse();
			}
			if (this.locale === 'es') {
				return this.tech;
			}
		},
	},
	async asyncData({ app, error }) {
		try {
			const locale = app.i18n.locale;
			const [{ data: post }, { data: services }, { data: products }, { data: tech }] = await Promise.all([
				httpClient.get(`/page?template=home&seo=allow&lang=${locale}`),
				httpClient.get(`/terms?category=services&lang=${locale}`),
				httpClient.get(`/terms?category=products&lang=${locale}`),
				httpClient.get(`/post-tech?lang=${locale}`),
			]);

			return {
				post,
				services,
				products,
				tech,
				locale,
			};
		} catch (er) {
			error({ statusCode: 404, message: 'Post not found' });
		}
	},
};
</script>
