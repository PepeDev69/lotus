<template>
	<AppLayout>
		<InternalBanner
			:title="title"
			:image="term.banner_image"
			:imageMobile="term.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<section class="shop-category">
			<AppContainer class="shop-category__container">
				<div class="shop-category__header">
					<Information class="shop-category__info" :title="term.name" :text="term.description" />
					<div class="s-alert" v-if="term.nota">
						<h3 class="s-alert__title">{{ titleNote }}</h3>
						<p class="s-title__text">{{ term.nota }}</p>
					</div>
				</div>
				<p>{{ results }}</p>
				<div class="shop-category__body">
					<section class="shop-category__services">
						<AppLink
							class="shop-category__service"
							v-for="product in products"
							:to="{
								name: `${catSlug}-category-slug`,
								params: { category: category, slug: product.slug },
							}"
							:key="product.id"
							:prevent="isOpen"
						>
							<FeaturedCard
								:price="Number(product.price)"
								:title="product.name"
								:subtitle="titleDetail"
								:img="product.thumbnail"
								:overlay="true"
								@open="addProduct(product)"
							/>
						</AppLink>
						<div class="shop-category__pagination">
							<p class="shop-category__pagination-number active">1</p>
							<p class="shop-category__pagination-number">2</p>
							<p class="shop-category__pagination-number">3</p>
							<span class="shop-category__pagination-arrow icon-angle"></span>
						</div>
					</section>
					<aside class="shop-category__aside">
						<article class="shop-category__categories">
							<h3 class="shop-category__aside-title">{{ titleCategory }}</h3>
							<AppLink
								v-for="(service, index) in asideServices"
								class="shop-category__category"
								:key="index"
								:to="{
									name: `${catSlug}-category`,
									params: { category: service.slug },
								}"
							>
								{{ service.name }} ({{ service.count }})
							</AppLink>
						</article>
						<article class="shop-category__last-services">
							<h3 class="shop-category__aside-title shop-category__aside-title--2">
								{{ titleLast }}
							</h3>
							<template v-for="(product, i) in products">
								<NuxtLink
									class="shop-category__last-service"
									:to="
										localePath({
											name: `${catSlug}-category-slug`,
											params: { category: category, slug: product.slug },
										})
									"
									event="click"
									v-if="i < 3"
									:key="i"
								>
									<picture class="shop-category__last-service-picture">
										<img :src="product.thumbnail" :alt="product.name" />
									</picture>
									<div>
										<h4 class="shop-category__last-service-title">{{ product.name }}</h4>
										<p class="shop-category__last-service-price">
											{{ product.price | currency }}
										</p>
									</div>
								</NuxtLink>
							</template>
						</article>
					</aside>
				</div>
			</AppContainer>
		</section>
		<FormFooter />
		<AddCart :isActive="isOpen" @close="closeCart" />
	</AppLayout>
</template>

<script>
import './../../assets/pcss/service.pcss';
import { mapState } from 'vuex';
export default {
	name: 'CategoryTemplate',
	components: {
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
		FeaturedCard: () => import('@/components/molecules/FeaturedCard.vue'),
		FormFooter: () => import('@/components/organisms/FormFooter.vue'),
		AddCart: () => import('@/components/organisms/AddCart.vue'),
	},
	props: {
		term: Object,
		products: Array,
		services: Array,
		title: String,
		titleNote: String,
		titleDetail: String,
		titleCategory: String,
		titleShowing: String,
		titleLast: String,
		catSlug: String,
	},
	methods: {
		addProduct(product) {
			this.isOpen = true;
			this.$nuxt.$emit('overflow', { type: 'open' });
		},
		closeCart() {
			this.isOpen = false;
			this.$nuxt.$emit('overflow', { type: 'close' });
		},
	},
	computed: {
		...mapState(['polylang', 'common']),
		results() {
			const titles = this.titleShowing.split('/');
			const count = this.term.count;
			return `${titles[0]} 1-9 ${titles[1]} ${count} ${titles[2]}`;
		},
		asideServices() {
			return this.services.filter(term => term.term_id !== this.term.term_id);
		},
		category() {
			return this.$route.params.category;
		},
	},
	data: () => ({
		isOpen: false,
	}),
};
</script>
