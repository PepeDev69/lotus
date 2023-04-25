<template>
	<section class="fs-section-container">
		<AppContainer class="fs-container">
			<h2 class="fs-title">{{ titlePrin }}</h2>
			<Swiper :options="swiperOptions" :cleanup-styles-on-destroy="false">
				<SwiperSlide v-for="product in products" :key="product.id">
					<AppLink
						:to="
							shop === 'services'
								? {
										name: 'service-category-slug',
										params: { shop: shop, category: category, subcategory: subcategory, slug: product.slug },
								  }
								: { name: 'product-category-slug', params: { shop: shop, category: category, slug: product.slug } }
						"
					>
						<FeaturedCard
							:img="product.picture ? product.picture : product.thumbnail"
							:subtitle="subtitle"
							:title="product.name"
							:price="Number(product.price)"
							:overlay="true"
							:related="true"
						/>
					</AppLink>
				</SwiperSlide>
			</Swiper>
		</AppContainer>
	</section>
</template>

<script>
export default {
	name: 'FeaturedServices',
	components: {
		FeaturedCard: () => import('../molecules/FeaturedCard.vue'),
	},
	props: {
		titlePrin: String,
		products: Array,
		subtitle: String,
		shop: String,
		category: String,
		subcategory: String,
	},
	data() {
		return {
			/** @type import('swiper').SwiperOptions */
			swiperOptions: {
				slidesPerView: 2,
				spaceBetween: 20,
				loop: true,
				breakpoints: {
					992: {
						slidesPerView: 3,
						spaceBetween: 25,
					},
					1340: {
						slidesPerView: 4,
						spaceBetween: 40,
					},
					1600: {
						slidesPerView: 4,
						spaceBetween: 50,
					},
				},
			},
		};
	},
};
</script>

<style lang="postcss">
.fs-section-container {
	@apply py-[4rem];
	background-color: #e4f1f4;
	@media screen(lg) {
		@apply py-[10vmin];
	}
}

.fs-container {
	@apply w-full;
	@media screen(xl) {
		@apply max-w-[75%];
	}
}

.fs-title {
	@apply text-[3.3rem] leading-none font-semibold text-primary mb-[1.15em] text-center
		md:text-[3.2rem] lg:text-[3.5rem] design:text-[4rem] monitor:text-[5rem] lg:text-left;
}
</style>
