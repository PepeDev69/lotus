<template>
	<AppLayout class="shop-service">
		<InternalBanner
			:title="polylang.shop_caption"
			:image="imagesBanner.banner_image"
			:imageMobile="imagesBanner.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
			:termName="term.name"
			:productName="product.name"
		/>
		<AppContainer class="shop-service__container" variant="big">
			<section class="shop-service__product" :class="type">
				<figure class="shop-service__picture">
					<picture class="p-picture--view p-pic">
						<Transition name="fade" mode="out-in" appear>
							<img
								decoding="sync"
								:onload="(showImage = true)"
								:src="showImage && currentImage ? currentImage : require('~/assets/img/not-found-image.jpg')"
								:key="trigger"
							/>
						</Transition>
					</picture>
					<div class="p-picture--list">
						<picture
							v-for="(image, index) in product.gallery"
							:key="index"
							class="shop-service__image p-pic p-picture--send"
							:class="[{ current: currentSelected(image) }, countImages ? 'only' : '']"
						>
							<img decoding="sync" :src="image" alt="Product Image" @click="selectPicture(image)" />
						</picture>
					</div>
				</figure>
				<div class="shop-service__info">
					<span class="shop-service__slug">
						{{ $route.params.shop == 'services' ? polylang.service_caption : polylang.product_caption }}
					</span>
					<h2 class="shop-service__title">
						<span class="s-tag">{{ product.name }}</span>
						<span v-if="type === 'product'" class="shop-service__status" :class="{ busy: !withStock.enabled }">
							{{ withStock.message }}
						</span>
					</h2>
					<div class="shop-service__rating">
						<span v-for="(item, i) in 5" :key="i" class="shop-service__rating-icon">&#x2605;</span>
					</div>
					<template v-if="isTag2">
						<div class="shop-service__text" v-html="product.content" />
					</template>
					<template v-else>
						<div class="shop-service__text">
							<p>{{ product.content }}</p>
						</div>
					</template>
					<span class="shop-service__price" :class="discountPrice ? 'discountActive' : ''">
						<span :class="[discountPrice ? 'discount' : '']"> {{ product.regular_price | currency }} </span>
						<span v-if="discountPrice"> {{ finalPrice | currency }} </span>
						<span v-if="discountPercent" class="discount-percent"> {{ discountPercent }} </span>
					</span>
					<template v-if="Boolean(product.regular_price)">
						<div class="shop-service__options" v-if="$route.params.shop == 'services'">
							<SelectablePrice
								:first-price="Number(sitemeta.reservation_price)"
								:second-price="Number(finalPrice)"
								v-model.number="reserve"
							/>
						</div>
					</template>
					<div class="shop-service__content__button" :class="type">
						<div class="shop-service__input" v-if="type === 'product'">
							<StepInput v-model="qty" />
						</div>
						<button
							class="shop-service__button"
							@click="handleAddProduct(product)"
							:disabled="!Boolean(product.price)"
							:class="{ 'pointer-events-none': !Boolean(product.price) }"
						>
							<span>{{ loading ? polylang.title_loading : polylang.title_add_cart }}</span>
						</button>
					</div>
					<div class="s-alert" v-if="$route.params.shop == 'services'">
						<h3 class="s-alert__title">{{ polylang.title_reserv_app_product }}</h3>
						<p class="s-alert__text">{{ polylang.content_reserv_app_product }}</p>
					</div>
				</div>
			</section>
			<section class="shop-service__extra" :style="withPadding" v-show="product.title_desc">
				<div class="shop-service__extra-titles" :class="{ jusBet: !product.title_info && !product.title_reviews }">
					<h3 @click="selectTab('description', 'descript')" :class="{ active: checkTab('description') }" class="shop-service__extra-title">
						{{ product.title_desc }}
					</h3>
					<h3
						v-if="product.content_info"
						@click="selectTab('additional info', 'info')"
						:class="{ active: checkTab('additional info') }"
						class="shop-service__extra-title"
					>
						{{ product.title_info }}
					</h3>
					<h3
						v-if="product.content_reviews"
						@click="selectTab('reviews', 'review')"
						:class="{ active: checkTab('reviews') }"
						class="shop-service__extra-title"
					>
						{{ product.title_reviews }}
					</h3>
				</div>
				<div class="shop-service__description pg-content service-tag" :class="{ active: checkTab('description') }" ref="descript">
					<div v-html="product.content_desc" class="inner-content"></div>
				</div>
				<div :class="{ active: checkTab('additional info') }" class="shop-service__information-add pg-content service-tag" ref="info">
					<div v-html="product.content_info" class="inner-content"></div>
				</div>
				<div :class="{ active: checkTab('reviews') }" class="shop-service__reviews pg-content service-tag" ref="review">
					<div v-html="product.content_reviews" class="inner-content"></div>
				</div>
			</section>
		</AppContainer>
		<FeaturedServices
			:titlePrin="withDynamicTitle"
			:products="asidePosts"
			:subtitle="polylang.title_service"
			:shop="$route.params.shop"
			:category="$route.params.category"
			:subcategory="$route.params.subcategory"
		/>
		<FormFooter />
	</AppLayout>
</template>

<script>
import { httpClient } from '~/plugins/http';
import { mapState } from 'vuex';
import './__slug.pcss';
import state from '~/store/shop/state';

export default {
	name: 'ProductTemplate',
	components: {
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
		FeaturedServices: () => import('@/components/organisms/FeaturedServices.vue'),
		FormFooter: () => import('@/components/organisms/FormFooter.vue'),
		StepInput: () => import('@/components/atoms/StepInput.vue'),
		SelectablePrice: () => import('~/components/atoms/SelectablePrice.vue'),
	},
	computed: {
		...mapState(['polylang']),
		...mapState('shop', {
			loading: 'loading',
		}),
		...mapState({
			sitemeta: state => state.siteMeta,
		}),
		asidePosts() {
			return this.products ? this.products.filter(product => product.id !== this.product.id) : [];
		},
		withPadding() {
			return {
				'padding-bottom': `${this.padding + 50}px`,
			};
		},
		withDynamicTitle() {
			return this.$route.params.shop == 'services'
				? this.polylang.title_relation_services || 'Servicios Relacionados'
				: this.polylang.title_relation_products || 'Productos Relacionados';
		},
		currentSelected() {
			return image => image === this.currentImage;
		},
		withStock() {
			// console.log(this.product.stock);
			if (Number(this.product.stock) > 0) {
				return {
					enabled: true,
					message: this.$t('available'),
				};
			} else {
				return {
					enabled: false,
					message: this.$t('not-available'),
				};
			}
		},
		type() {
			return this.$route.params.shop.slice(0, -1);
		},
		isTag() {
			return this.product.content.includes('<li>');
		},
		isTag2() {
			return this.product.content.includes('<p>');
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
		discountPrice() {
			return Number(this.$route.query.disc);
		},
		discountPercent() {
			return this.$route.query.disc ? `-${this.$route.query.disc}%` : '';
		},
		finalPrice() {
			if (this.$route.query.disc === this.sitemeta.discount_banner_home) {
				return Number(this.product.regular_price) - (this.discountPrice * Number(this.product.regular_price)) / 100;
			} else {
				return Number(this.product.regular_price);
			}
		},
		countImages() {
			if (this.product.gallery.length === 1) {
				return true;
			} else {
				return false;
			}
		},
		langActive() {
			return this.$i18n.locale;
		},
	},
	methods: {
		selectPicture(image) {
			this.trigger = !this.trigger;
			this.currentImage = image;
		},
		selectTab(tab, extra = '') {
			if (extra) {
				this.padding = this.$refs[extra].scrollHeight;
			}
			this.currentTab = tab;
		},
		checkTab(tab) {
			return tab === this.currentTab;
		},
		handleAddProduct(product) {
			if (this.$route.params.shop == 'services') {
				this.$store.dispatch('shop/addService', {
					id: product.id,
					name: product.name,
					paid: this.reserve,
					price: this.finalPrice,
					partial: product.partial_price,
					quantity: 1,
					picture: product.picture,
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
					// price: product.price,
					price: this.finalPrice,
					quantity: this.qty,
					picture: product.picture,
					lang: this.langActive,
				});
			}
		},
	},
	mounted() {
		// console.log(this.withStock.enabled);
		this.padding = this.$refs.descript.scrollHeight;
		if (this.type === 'service') {
			this.reserve = parseInt(this.sitemeta.reservation_price || 0);
		}
		if (!Boolean(this.product.gallery[0])) {
			this.product.gallery[0] = require('~/assets/img/product-image-not-found.jpg');
		}
		this.currentImage = this.product.gallery[0];
	},
	async asyncData({ params, app, error }) {
		const withShopType = params.shop == 'services' ? 'service' : 'product';
		const lang = app.i18n.locale;
		const category = params.shop === 'products' ? params.category : params.subcategory;
		const subcategory = params.shop === 'services' ? 'true' : 'false';
		try {
			const [{ data: product }, { data: products }, { data: term }, { data: services }] = await Promise.all([
				httpClient.get(`/shop/${withShopType}?slug=${params.slug}&lang=${lang}&seo=allow`),
				httpClient.get(`/shop/${params.shop}?limit=8&category=${params.category}&lang=${lang}`),
				httpClient.get(`/shop/category?type=${params.shop}&slug=${category}&lang=${lang}&subcategory=${subcategory}`),
				httpClient.get(`/terms?category=${params.shop}&lang=${lang}`),
			]);
			return {
				product,
				products,
				term,
				services,
			};
		} catch (err) {
			error({ statusCode: 404, message: `${withShopType} not found` });
		}
	},
	data: () => ({
		currentImage: null,
		isReserved: false,
		hasFullPayment: false,
		currentTab: 'description',
		trigger: false,
		reserve: 0,
		qty: 1,
		padding: 0,
		showImage: false,
	}),
};
</script>
