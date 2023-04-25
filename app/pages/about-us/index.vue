<template>
	<AppLayout>
		<InternalBanner
			:title="post.title_banner"
			:image="post.banner_image"
			:imageMobile="post.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<ArticleGeneral
			class="articleGralPrin !bg-white"
			:imageLeft="true"
			:doubleImage="true"
			:bgImageActive="true"
			:title="post.about_first_title"
			:text="post.about_first_content"
			:btnText="polylang.title_contact_poly"
			:listImages="listImages"
		/>
		<ArticleGeneral
			class="articleGralSec !bg-lightblue/[.05]"
			:bgColor="true"
			:title="post.about_second_title"
			:text="post.about_second_content"
			:btnText="polylang.title_contact_poly"
			:listImages="listImagestwo"
		/>
	</AppLayout>
</template>

<script>
import { mapState } from 'vuex';
import { httpClient } from '~/plugins/http';
export default {
	name: 'ContactUsTemplate',
	components: {
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
	},
	computed: {
		...mapState(['polylang']),
	},
	async asyncData({ params, app }) {
		const locale = app.i18n.locale;
		const { data: post } = await httpClient.get(`/page?template=about-us&lang=${locale}&seo=allow`);
		return {
			post,
		};
	},
	data() {
		return {
			listImages: [
				{
					image: 'https://www.linkpicture.com/q/prueba.jpg',
					imageMob: 'https://www.linkpicture.com/q/pruebaMobile.jpg',
				},
				{
					image: 'https://www.linkpicture.com/q/prueba2.jpg',
					imageMob: 'https://www.linkpicture.com/q/pruebaMobile.jpg',
				},
			],
			listImagestwo: [
				{
					image: 'https://www.linkpicture.com/q/0N9A6706-scaled-3.jpg',
					imageMob: 'https://www.linkpicture.com/q/pruebaMobile.jpg',
				},
			],
		};
	},
};
</script>

<style lang="postcss">
.articleGralPrin {
	@apply py-[6rem];
	@media screen(md) {
		@apply py-[8rem];
	}
	@media screen(xl) {
		@apply pt-[6rem] pb-[12rem];
	}
	@media screen(design) {
		@apply pt-[6.5rem] pb-[14rem];
	}
	@media screen(monitor) {
		@apply pt-[8rem] pb-[18rem];
	}
}

.articleGralSec {
	@apply py-[6rem];
	@media screen(md) {
		@apply py-[8rem];
	}
	@media screen(xl) {
		@apply py-[8rem];
	}
	@media screen(monitor) {
		@apply py-[10rem];
	}
}
</style>
