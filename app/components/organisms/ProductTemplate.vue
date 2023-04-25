<template>
	<AppLayout class="shop-service">
		<InternalBanner
			:title="title"
			:image="product.banner_image"
			:imageMobile="product.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<AppContainer class="shop-service__container">
			<section class="shop-service__product">
				<figure class="shop-service__figure">
					<img
						v-for="(img, index) in product.gallery"
						:key="index"
						:src="img"
						alt="image active"
						class="shop-service__image"
						@click="setActiveImg(index)"
					/>
					<picture>
						<Transition name="fade" mode="out-in">
							<img :key="trigger" class="shop-service__image shop-service__image--active" :src="activeImg" alt="image active" />
						</Transition>
					</picture>
				</figure>
				<div class="shop-service__info">
					<span class="shop-service__slug">{{ titleDetail }}</span>
					<h2 class="shop-service__title">{{ product.name }}</h2>
					<div class="shop-service__rating">
						<span v-for="(item, i) in 5" :key="i" class="shop-service__rating-icon"></span>
					</div>
					<div class="shop-service__text" v-html="product.content"></div>
					<p class="shop-service__price">{{ product.regular_price | currency }}</p>
					<ul class="shop-service__options" v-if="titleBook && titleFull">
						<li @click="isReserved = !isReserved" class="shop-service__option">
							<span :class="{ active: isReserved }" class="shop-service__select"></span>
							<p class="shop-service__option-title">{{ titleBook }}</p>
							<p class="shop-service__option-price">{{ product.partial_price | currency }}</p>
						</li>
						<li @click="hasFullPayment = !hasFullPayment" class="shop-service__option">
							<span :class="{ active: hasFullPayment }" class="shop-service__select"></span>
							<p class="shop-service__option-title">{{ titleFull }}</p>
							<p class="shop-service__option-price shop-service__option-price--discount">
								{{ product.regular_price | currency }}
							</p>
							<p class="shop-service__option-price">{{ product.sale_price | currency }}</p>
						</li>
					</ul>
					<div class="shop-service__content__button">
						<div class="shop-service__input" v-if="inputContent">
							<input type="number" placeholder="1" />
							<div>
								<button class="shop-service__input__plus">+</button>
								<button class="shop-service__input__minus">-</button>
							</div>
						</div>
						<button class="shop-service__button">
							<span>{{ titleCart }}</span>
						</button>
					</div>
					<div class="s-alert" v-if="titleReservProduct">
						<h3 class="s-alert__title">{{ titleReservProduct }}</h3>
						<p class="s-alert__text">{{ titleContentProduct }}</p>
					</div>
				</div>
			</section>
			<section class="shop-service__extra">
				<div class="shop-service__extra-titles">
					<h3 @click="selectTab('description')" :class="{ active: checkTab('description') }" class="shop-service__extra-title">
						{{ product.title_desc }}
					</h3>
					<h3
						v-if="product.list_info"
						@click="selectTab('additional info')"
						:class="{ active: checkTab('additional info') }"
						class="shop-service__extra-title"
					>
						{{ product.title_info }}
					</h3>
					<h3
						v-if="product.content_reviews"
						@click="selectTab('reviews')"
						:class="{ active: checkTab('reviews') }"
						class="shop-service__extra-title"
					>
						{{ product.title_reviews }}
					</h3>
				</div>
				<div :class="{ active: checkTab('description') }" class="shop-service__description" v-html="product.content_desc"></div>
				<div :class="{ active: checkTab('additional info') }" class="shop-service__additional-info">
					<div v-for="(i, index) in product.list_info" :key="index" class="shop-service__additional-info-item">
						<img :src="i.image" :alt="i.title" />
						<p>{{ i.title }}</p>
					</div>
				</div>
				<div :class="{ active: checkTab('reviews') }" class="shop-service__reviews">
					<img class="image" :src="product.image_reviews" :alt="product.name_reviews" />
					<div>
						<h3 class="service">{{ product.title_reviews }}</h3>
						<div class="stars">
							<span class="icon-star" v-for="(item, i) in 5" :key="i"></span>
						</div>
						<h4 class="customer">
							{{ product.name_reviews }} <span> - {{ product.date_reviews }}</span>
						</h4>
						<p class="comment">{{ product.content_reviews }}</p>
					</div>
				</div>
			</section>
		</AppContainer>
		<FeaturedServices :titlePrin="titleRelation" :products="asidePosts" :subtitle="titleDetail" />
		<FormFooter />
	</AppLayout>
</template>

<script>
import './../../assets/pcss/product.pcss';
import { mapState } from 'vuex';
export default {
	name: 'ProductTemplate',
	components: {
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
		FeaturedServices: () => import('@/components/organisms/FeaturedServices.vue'),
		FormFooter: () => import('@/components/organisms/FormFooter.vue'),
	},
	props: {
		inputContent: Boolean,
		lang: String,
		product: Object,
		products: Array,
		title: String,
		titleDetail: String,
		titleBook: String,
		titleFull: String,
		titleCart: String,
		titleReservProduct: String,
		titleContentProduct: String,
		titleRelation: String,
	},
	computed: {
		...mapState(['polylang', 'common']),
		asidePosts() {
			return this.products.filter(product => product.id !== this.product.id);
		},
	},
	methods: {
		setActiveImg(index) {
			this.trigger = !this.trigger;
			return index ? (this.activeImg = this.product.gallery[index]) : (this.activeImg = this.product.gallery[0]);
		},
		selectTab(tab) {
			this.currentTab = tab;
		},
		checkTab(tab) {
			return tab === this.currentTab;
		},
	},
	created() {
		this.setActiveImg();
	},
	data: () => ({
		activeImg: '',
		isReserved: false,
		hasFullPayment: false,
		currentTab: 'description',
		trigger: false,
	}),
};
</script>
