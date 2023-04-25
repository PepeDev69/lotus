<template>
	<AppLayout>
		<InternalBanner
			:title="formatLabellyIn('normal')"
			:image="imagesBanner.banner_image"
			:imageMobile="imagesBanner.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
			:termName="term.name"
		/>
		<section class="landing-product-stage">
			<AppContainer variant="big" class="tr-description-wrap">
				<div class="tr-description">
					<h2 class="@md-title term-title">{{ term.name }}</h2>
					<div v-if="term.description" class="tr-content">
						<p>{{ term.description }}</p>
					</div>
				</div>
				<template v-if="$route.params.shop == 'services'">
					<div class="s-alert tr-description-alert" v-if="term.nota">
						<h3 class="s-alert__title">{{ 'Nota' }}</h3>
						<p class="s-title__text">{{ term.nota }}</p>
					</div>
				</template>
			</AppContainer>
			<AppContainer variant="big" class="paginate--division">
				<div class="paginate--division__items">
					<h4 class="paginate--division-arial">{{ results }}</h4>
					<TransitionGroup name="ps-product" tag="ul" class="ps-list">
						<li v-for="product in products.data" :key="product.id" class="ps-product">
							<AppLink :to="makeRouteSlug(product.slug)" :prevent="prevent">
								<FeaturedCard
									:img="product.thumbnail"
									:title="product.name"
									:subtitle="formatLabellyIn('single')"
									:price="Number(product.price)"
									:overlay="true"
									@open="handleAddProduct(product)"
								/>
							</AppLink>
						</li>
					</TransitionGroup>
					<div class="pg-paginate">
						<button @click="prevPaginate" :disabled="!products.prev" class="pg-paginate__btn">
							<svg width="8" height="13" fill="none" viewBox="0 0 8 13">
								<path
									fill="currentColor"
									fill-rule="evenodd"
									d="M7.103 11.718a1 1 0 0 1-1.414-.004L0 5.988 5.726.299a1 1 0 0 1 1.41 1.42L2.827 5.996l4.28 4.307a1 1 0 0 1-.005 1.414Z"
									clip-rule="evenodd"
								/>
							</svg>
						</button>
						<button
							v-for="page in products.pages"
							@click="handlePaginate(page)"
							:key="page"
							class="pg-paginate__number"
							:aria-current="currentPaginate(page)"
						>
							{{ page }}
						</button>
						<button @click="nextPaginate" :disabled="!products.next" class="pg-paginate__btn">
							<svg width="8" height="12" viewBox="0 0 8 12" fill="none">
								<path
									fill="currentColor"
									fill-rule="evenodd"
									clip-rule="evenodd"
									d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.41421 6L1.70711 11.7071C1.31658 12.0976 0.683417 12.0976 0.292893 11.7071C-0.0976311 11.3166 -0.0976311 10.6834 0.292893 10.2929L4.58579 6L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z"
								/>
							</svg>
						</button>
					</div>
				</div>
				<div class="paginate--division__siblings">
					<div class="terms-related">
						<template>
							<h3 v-if="shopActiveTwo === false" class="paginate--division__title">
								{{ polylang.title_categorys }}
							</h3>
							<h3 v-else class="paginate--division__title">
								{{ polylang.title_subcategories }}
							</h3>
						</template>
						<ul class="tr-siblings">
							<li v-for="sibling in term.siblings" :key="sibling.id" class="tr-siblings-it">
								<AppLink :to="makeRoute(sibling.slug)"> {{ sibling.name }} ({{ sibling.count }}) </AppLink>
							</li>
						</ul>
					</div>
					<div class="servcies-related"></div>
				</div>
			</AppContainer>
		</section>
		<FormFooter />
		<!-- <AddCart :isActive="isOpen" @close="closeCart" /> -->
	</AppLayout>
</template>

<script>
import './index.pcss';
import { httpClient } from '@/plugins/http';
import { mapState } from 'vuex';
export default {
	name: 'Services',
	components: {
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
		FeaturedCard: () => import('~/components/molecules/FeaturedCard.vue'),
		FormFooter: () => import('@/components/organisms/FormFooter.vue'),
		AddCart: () => import('@/components/organisms/AddCart.vue'),
	},
	computed: {
		...mapState(['polylang', 'common']),
		formatLabellyIn() {
			const type = this.$route.params.shop;
			return function (format) {
				if (format == 'single') {
					return type == 'services' ? this.polylang.service_caption : this.polylang.product_caption;
				}
				return type == 'services' ? `${this.polylang.service_caption}s` : `${this.polylang.product_caption}s`;
			};
		},
		makeRouteSlug() {
			const category = this.$route.params.category;
			const subCategory = this.$route.params.subcategory;
			if (this.$route.params.shop == 'products') {
				return slug => ({
					name: 'product-category-slug',
					params: {
						shop: 'products',
						category: category,
						slug: slug,
					},
				});
			}
			return slug => ({
				name: 'service-category-slug',
				params: {
					shop: 'services',
					category: category,
					subcategory: subCategory,
					slug: slug,
				},
			});
		},
		makeRoute() {
			const category = this.$route.params.category;
			if (this.$route.params.shop === 'products') {
				return slug => ({
					name: 'product-category',
					params: {
						shop: 'products',
						category: slug,
					},
				});
			}
			return slug => ({
				name: 'service-category',
				params: {
					shop: 'services',
					category: category,
					subcategory: slug,
				},
			});
		},
		currentPaginate() {
			return function (page) {
				if (!this.$route.query.page) return page == 1;
				return page == this.$route.query?.page;
			};
		},
		results() {
			const [show, off, results] = this.polylang.title_showing.split('/');
			const { count, from, to } = this.products;
			return `${show} ${from}-${to} ${off} ${count} ${results}`;
		},
		shopActiveTwo() {
			// return this.$route.params.shop === 'services' ? true : false;
			if (this.$route.params.shop === 'services') return true;
			if (this.$route.params.shop === 'products') return false;
		},
		imagesBanner() {
			const category = this.$route.params.category;
			if (category === 'permanent-hair-removal' || category === 'daily-routine') {
				return this.services[0];
			}
			if (category === 'skin-care' || category === 'treatments') {
				return this.services[1];
			}
			if (category === 'body-wellness' || category === 'comprehensive-wellness') {
				return this.services[2];
			}
		},
		langActive() {
			return this.$i18n.locale;
		},
	},
	methods: {
		prevPaginate() {
			this.$router.push({
				path: this.$route.path,
				query: { page: parseInt(this.products.prev) },
			});
		},
		nextPaginate() {
			this.$router.push({
				path: this.$route.path,
				query: { page: parseInt(this.products.next) },
			});
		},
		handlePaginate(page) {
			this.$router.push({
				path: this.$route.path,
				query: { page: parseInt(page) },
			});
		},
		handleAddProduct(product) {
			this.prevent = true;
			if (this.$route.params.shop == 'services') {
				this.$store.dispatch('shop/addService', {
					id: product.id,
					name: product.name,
					paid: 50,
					partial: product.partial,
					price: product.price,
					quantity: 1,
					picture: product.thumbnail,
					from: null,
					to: null,
					doctor: null,
					lang: this.langActive,
				});
			}
			if (this.$route.params.shop == 'products') {
				this.$store.dispatch('shop/addProduct', {
					id: product.id,
					name: product.name,
					price: product.price,
					quantity: 1,
					picture: product.thumbnail,
					lang: this.langActive,
				});
			}
			setTimeout(() => {
				this.prevent = false;
			}, 500);
			// this.$nuxt.$emit("overflow", { type: "open" });
		},
		closeCart() {
			this.isOpen = false;
			this.$nuxt.$emit('overflow', { type: 'close' });
		},
	},
	mounted() {
		if (this.$route.params.shop === 'services') {
			this.shopActive = true;
		} else {
			this.shopActive = false;
		}
	},
	async fetch() {
		const page = parseInt(this.$route.query?.page) || 1;
		const locale = this.$i18n.locale;
		const shop = this.$route.params.shop;
		const category = this.$route.params.shop == 'products' ? this.$route.params.category : this.$route.params.subcategory;
		// const category = this.$route.params.category;
		const { data: post } = await httpClient.get(
			`/shop/product/paginate?type=${shop}&category=${category}&lang=${locale}&step=9&page=${page}`
		);
		this.products = post;
	},
	watch: {
		'$route.query.page': {
			async handler(query) {
				await this.$fetch();
			},
		},
	},
	async asyncData({ params, app }) {
		const category = params.shop === 'products' ? params.category : params.subcategory;
		const subcategory = params.shop === 'services' ? 'true' : 'false';
		const lang = app.i18n.locale;
		const [{ data: term }, { data: services }] = await Promise.all([
			httpClient.get(`/shop/category?type=${params.shop}&slug=${category}&lang=${lang}&subcategory=${subcategory}`),
			httpClient.get(`/terms?category=${params.shop}&lang=${lang}`),
		]);
		return {
			term,
			services,
		};
	},
	data: () => ({
		products: {},
		isOpen: false,
		prevent: null,
		shopActive: false,
	}),
};
</script>
