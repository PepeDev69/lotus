<template>
	<AppLayout>
		<InternalBanner
			:image="common.img_cart_checkout"
			:imageMobile="common.img_mob_cart_checkout"
			:title="polylang.title_cart"
			:homeInicio="polylang.menu[0].label"
		/>
		<section class="landing-cart">
			<AppContainer v-if="!isCartEmpty" class="l-cart__section" variant="big">
				<TransitionGroup tag="ul" name="cart-item" class="ps-product-ls">
					<li v-for="service in cart.services" :key="service.id" class="ps-product-ls__item">
						<ProductCartItem
							:id="service.id"
							type="service"
							:name="service.name"
							:qty="Number(service.quantity)"
							:picture="service.picture"
							:price="Number(service.price)"
							:partial="Number(service.partial)"
							:paid="Number(service.paid)"
							:date="{
								from: service.from,
								to: service.to,
							}"
							@update-service="defineCurrentService(service.id, service.from, service.to, service.doctor)"
						/>
					</li>
					<li v-for="product in cart.products" :key="product.id" class="ps-product-ls__item">
						<ProductCartItem
							:id="product.id"
							type="product"
							:name="product.name"
							:price="Number(product.price)"
							:picture="product.picture"
							:qty="product.quantity"
						/>
					</li>
				</TransitionGroup>
				<div>
					<MiniCart :title="polylang.title_order_summary">
						<AppLink :prevent="!withTimeline" @click.native="notDate" class="btn-cart" :to="{ name: 'checkout' }">
							{{ polylang.title_go_to_pay }}
						</AppLink>
					</MiniCart>
				</div>
			</AppContainer>
			<AppContainer v-else>
				<ClientOnly>
					<div class="empty-cart-fx flex items-center">
						<EmptyCart />
						<h3 class="tt-cart-empty">{{ $t('empty-cart') }}</h3>
						<p class="tt-cart-empty-m">{{ $t('empty-cart-message') }}</p>
						<ButtonGeneral class="green empty-btn !rounded-[.5rem]" :path="{ name: 'index' }" :text="$t('return-home')" />
					</div>
				</ClientOnly>
			</AppContainer>
			<AppOverlay :open="calendarOpen" @close="closeOverlay">
				<VueCalendar @update="closeOverlay" @cancel="closeOverlay" :id="currentId" :doctor="currentDoc" :from-date="currentDate" />
			</AppOverlay>
		</section>
	</AppLayout>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import { dateFormatTomorrow } from '~/plugins/utils';
export default {
	name: 'CartTemplate',
	components: {
		ProductCartItem: () => import('@/components/molecules/ProductCartItem.vue'),
		VueCalendar: () => import('~/components/organisms/VueCalendar.vue'),
		AppOverlay: () => import('@/components/globals/AppOverlay.vue'),
		InternalBanner: () => import('@/components/molecules/InternalBanner.vue'),
		DateSelectable: () => import('@/components/molecules/DateSelectable.vue'),
		MiniCart: () => import('@/components/molecules/MiniCart.vue'),
		EmptyCart: () => import('@/components/animation/EmptyCart.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		...mapState('shop', {
			cart: 'shopCart',
		}),
		...mapGetters('shop', {
			withTimeline: 'withServicesDefinedTimeline',
			isCartEmpty: 'isCartEmpty',
		}),
		langActive() {
			return this.$i18n.locale;
		},
	},
	methods: {
		notDate() {
			const element = document.getElementsByClassName('date-selectable');
			for (let i = 0; i < element.length; i++) {
				if (!this.withTimeline) {
					element[i].classList.add('not-active');
				} else {
					element[i].classList.remove('not-active');
				}
			}
			// if (!this.withTimeline) {
			// 	for (let i = 0; i < element.length; i++) {
			// 		element[i].classList.add('not-active');
			// 	}
			// } else {
			// 	for (let i = 0; i < element.length; i++) {
			// 		element[i].classList.remove('not-active');
			// 	}
			// }
		},
		defineCurrentService(id, from, to, doctor) {
			this.calendarOpen = true;
			this.currentId = id;
			this.currentDate = { from, to };
			this.currentDoc = doctor;
			document.querySelector('body').classList.add('active');
		},
		updateProduct(id, qty) {
			this.$store.dispatch('shop/updateProduct', {
				id: id,
				value: qty,
				lang: this.langActive,
			});
		},
		closeOverlay() {
			document.querySelector('body').classList.remove('active');
			this.calendarOpen = false;
		},
	},
	beforeMount() {
		this.$store.dispatch({
			type: 'booking/setBookingSchedule',
			date: dateFormatTomorrow(),
		});
	},
	data: () => ({
		count: 0,
		calendarOpen: false,
		currentId: 0,
		currentDoc: 0,
		currentDate: { from: '', to: '' },
		prueba: false,
	}),
};
</script>

<style lang="postcss">
.ps-product-ls {
	display: flex;
	flex-direction: column;
	&__item:not(:last-child) {
		border-bottom: 1px solid #d0d0d0;
	}
	@media screen(lg) {
		width: 52%;
		&__item:first-child {
			border-top: 1px solid #d0d0d0;
		}
	}
}

/** Langing */
.landing-cart {
	padding-top: 3rem;
	padding-bottom: 5rem;
	@media screen(lg) {
		padding-top: 10vmin;
		padding-bottom: 8vmin;
	}
}
.l-cart__section {
	display: flex;
	flex-direction: column;
	row-gap: 3rem;
	@media screen(lg) {
		flex-direction: row;
		justify-content: space-between;
	}
}

.btn-cart {
	font: calc(var(--p-font-size) - 1px);
	border-radius: 1rem;
	background-color: #377885;
	color: var(--white);
	padding: 0.5em 2em;
}
.empty-cart-fx {
	@apply justify-between flex-col;
	svg {
		@apply w-[50%] pb-2;
	}
	@media screen(lg) {
		@apply px-[10%];
		svg {
			@apply w-[40%];
		}
	}
}

.tt-cart-empty {
	font: normal 500 var(--p-font-size) / 1.3 'Cormorant-Garamond-Bold';
	@apply text-green-two text-[2.5rem] lg:text-[2rem] design:text-[3rem] monitor:text-[4rem] py-[0.4em];
	&-m {
		@apply max-w-[25ch] mx-auto text-center;
	}
}

.empty-btn {
	@apply mt-[2em];
}
</style>
