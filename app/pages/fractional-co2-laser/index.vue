<template>
	<AppLayout>
		<InternalBanner
			:title="acupulse.title_banner"
			:image="acupulse.banner_image"
			:imageMobile="acupulse.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<ArticleGeneral
			class="articleGralPrin"
			:title="acupulse.acupulse_title"
			:text="acupulse.acupulse_content"
			:btnText="polylang.title_contact_poly"
			:onlyImage="acupulse.acupulse_picture"
		/>
		<SolutionsOrBenefits
			:sliderActive="true"
			:title="acupulse.acupulse_benefits_title"
			:listBenefits="acupulse.acupulse_benefits_list"
			:btnText="polylang.title_contact_poly"
		/>
		<CharacteristicsAcupulse
			class="CharAcupulse"
			:title="acupulse.acupulse_caracterist_title"
			:listChar="acupulse.acupulse_caracterist_list"
			:image="acupulse.acupulse_caracterist_picture"
		/>
		<QuestionsTech
			class="questionsTech"
			:title="acupulse.acupulse_question_title"
			:listQuestions="acupulse.acupulse_question_list"
			:image="acupulse.acupulse_question_picture"
		/>
		<AppSeoEngine :meta-seo="acupulse.meta_seo" />
	</AppLayout>
</template>

<script>
import { httpClient } from '@/plugins/http';
import { mapState } from 'vuex';
export default {
	name: 'TechnologyAcupulse',
	components: {
		SolutionsOrBenefits: () => import('~/components/organisms/SolutionsOrBenefits.vue'),
		TechnologiesLegent: () => import('~/components/organisms/TechnologiesLegent.vue'),
		QuestionsTech: () => import('~/components/organisms/QuestionsTech.vue'),
		CharacteristicsAcupulse: () => import('~/components/organisms/CharacteristicsAcupulse.vue'),
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
	},
	async asyncData({ app, redirect }) {
		try {
			const locale = app.i18n.locale;
			const [{ data: acupulse }] = await Promise.all([httpClient.get(`/page?template=acupulse&lang=${locale}&seo=allow`)]);
			return {
				acupulse,
			};
		} catch (error) {
			redirect({ name: '404' });
		}
	},
};
</script>

<style lang="postcss">
.articleGralPrin,
.questionsTech,
.CharAcupulse {
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
