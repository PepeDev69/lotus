<template>
	<h1>Redirect...</h1>
</template>

//
<script>
import { httpClient } from '~/plugins/http';
export default {
	async asyncData({ params, app, redirect }) {
		const lang = app.i18n.locale;
		const { data: first } = await httpClient.get(`/terms/first?slug=${params.shop}&lang=${lang}`);
		return redirect(
			app.localePath({
				name: 'shop-category',
				params: {
					category: first.slug,
				},
			})
		);
	},
};
</script>
