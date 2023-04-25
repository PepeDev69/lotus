<template>
	<AppLayout>
		<InternalBanner
			:title="legend.title_banner"
			:image="legend.banner_image"
			:imageMobile="legend.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<ArticleGeneral
			class="articleGralPrin"
			:title="legend.legend_first_title"
			:text="legend.legend_first_content"
			:btnText="polylang.title_contact_poly"
			:onlyImage="legend.legend_first_picture"
		/>
		<SolutionsOrBenefits
			:sliderActive="false"
			:title="legend.legend_second_title"
			:text="legend.legend_second_content"
			:image="legend.legend_second_picture"
			:btnText="polylang.title_contact_poly"
		/>
		<TechnologiesLegent
			class="technologiesLegent"
			:title="legend.legend_three_tech_title"
			:text="legend.legend_three_tech_description"
			:listTech="legend.legend_three_tech_list"
		/>
		<QuestionsTech
			class="questionsTech"
			:title="legend.legend_question_title"
			:listQuestions="legend.legend_question_list"
			:image="legend.legend_question_picture"
		/>
	</AppLayout>
</template>

<script>
import { httpClient } from '@/plugins/http';
import { mapState } from 'vuex';
export default {
	name: 'TechnologyLegendPro',
	computed: {
		...mapState(['common', 'polylang']),
	},
	components: {
		SolutionsOrBenefits: () => import('~/components/organisms/SolutionsOrBenefits.vue'),
		TechnologiesLegent: () => import('~/components/organisms/TechnologiesLegent.vue'),
		QuestionsTech: () => import('~/components/organisms/QuestionsTech.vue'),
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
	},
	async asyncData({ app, redirect }) {
		try {
			const locale = app.i18n.locale;
			const [{ data: legend }] = await Promise.all([httpClient.get(`/page?template=legend-pro&seo=allow&lang=${locale}`)]);
			return {
				legend,
			};
		} catch (error) {
			redirect({ name: '404' });
		}
	},
};
</script>

<style lang="postcss">
.articleGralPrin,
.technologiesLegent,
.questionsTech {
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
