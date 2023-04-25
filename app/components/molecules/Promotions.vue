<template>
	<AppLink :to="makeRoute" class="ctn-promotions">
		<picture class="promotions-picture">
			<source media="(min-width: 960px)" :srcset="image" />
			<img class="promotions-picture__image" :src="imageMob" alt="" />
		</picture>
	</AppLink>
</template>

<script>
import { store } from '~/store/index.js';
export default {
	props: {
		image: String,
		imageMob: String,
		category: String,
		nameCategory: String,
		slug: String,
		discount: String,
	},
	computed: {
		// makeRoute: () => (item, subitem, child) => {
		// 	return {
		// 		name: 'shop-category-slug',
		// 		params: {
		// 			shop: item.child_ref,
		// 			category: subitem.child_ref,
		// 			slug: child.slug,
		// 		},
		// 	};
		// },
		makeRoute() {
			return {
				name: 'service-category-slug',
				params: {
					shop: 'services',
					category: this.category,
					subcategory: this.nameCategory,
					slug: this.slug,
				},
				query: {
					disc: this.discount,
				},
			};
		},
	},
};
</script>

<style lang="postcss">
.ctn-promotions {
	@apply w-full h-auto bg-pink flex items-center justify-center;
	@media (min-width: 960px) {
		@apply h-[40vh];
	}
	@media (min-width: 1200px) {
		@apply h-[45vh];
	}
}

.promotions-picture {
	@apply w-full overflow-hidden h-full;
	@media (min-width: 768px) {
		@apply w-[75%];
	}
	@media (min-width: 960px) {
		@apply w-full;
	}
	&__image {
		@apply w-full h-full object-cover;
	}
}
</style>
