<template>
	<AppLayout class="main-checkout">
		<section class="p-checkout">
			<AppContainer class="p-checkout__section" variant="big">
				<PaymentCheckout class="p-cart-form" />
				<section class="p-cart-check">
					<div class="p-variant-resume">
						<MiniCart :init="true" />
						<div class="mt-8" id="paypal-button" ref="paypalDOM" />
					</div>
				</section>
			</AppContainer>
		</section>
		<PaymentProccessLoader :open="paymentProccess" />
	</AppLayout>
</template>

<script>
import './__checkout.pcss';
import { mapState, mapGetters } from 'vuex';
import { shopService } from '~/services/shop.service';

export default {
	name: 'PaymentTemplate',
	middleware: 'auth',
	components: {
		PaymentCheckout: () => import('@/components/organisms/PaymentCheckout.vue'),
		MiniCart: () => import('@/components/molecules/MiniCart.vue'),
		PaymentProccessLoader: () => import('@/components/animation/PaymentProccessLoader.vue'),
	},
	computed: {
		...mapState({
			common: state => state.common,
			user: state => state.user.shopper,
		}),
		...mapGetters('user', {
			validityForm: 'verifyRequiredFormInput',
		}),
		...mapGetters('shop', {
			paypalObject: 'getTotalInformationForPaypal',
			isCartEmpty: 'isCartEmpty',
			cart: 'getShopCart',
		}),
		langActive() {
			return this.$i18n.locale;
		},
	},
	methods: {
		openAnimation() {
			this.paymentProccess = true;
			document.body.classList.add('active');
			setTimeout(() => {
				document.body.classList.remove('active');
			}, 6000);
		},
		onPaypalClick(data, actions) {
			const vm = this;
			if (!this.validityForm) {
				if (this.langActive === 'es') {
					vm.$store.dispatch('event/triggerWarningEvent', 'Por favor, completar el formulario');
				} else {
					vm.$store.dispatch('event/triggerWarningEvent', 'Please fill out the form below');
				}
				return actions.reject();
			} else if (vm.isCartEmpty) {
				if (this.langActive === 'es') {
					vm.$store.dispatch('event/triggerWarningEvent', 'Selecciona un producto para continuar');
				} else {
					vm.$store.dispatch('event/triggerWarningEvent', 'Select a product to continue');
				}
				return actions.reject();
			} else {
				return shopService.verifyAllProducts(vm.cart.products, vm.cart.services).then(status => {
					if (status == true) {
						return actions.resolve();
					}
					vm.$store.dispatch('event/triggerErrorEvent', 'Error in server founded with intent create order');
					return actions.reject();
				});
			}
		},
		onPaypalApprove(data, actions) {
			const vm = this;
			return actions.order.capture().then(function (detail) {
				vm.openAnimation();
				shopService.createOrder(vm.user, vm.cart.products, vm.cart.services).then(status => {
					// console.log(status);
					if (status != false) {
						vm.$store.dispatch({
							type: 'shop/deleteShopCart',
						});
						vm.$store.dispatch('user/setPayedShopper', {
							...detail,
							...status,
						});
						// console.log('Paypal complted');
						vm.$router.push(vm.localePath({ name: 'checkout-complete' }));
					}
				});
			});
		},
		onPaypalCancel(data, actions) {
			console.log(data, 'action', actions);
		},
		onPaypalError(data, actions) {
			console.log(data, 'action', actions);
		},
	},
	mounted() {
		const vm = this;
		this.$nextTick(() => {
			if (this.$refs.paypalDOM) {
				paypal
					.Buttons({
						onClick: this.onPaypalClick,
						createOrder(data, actions) {
							return actions.order.create(vm.paypalObject);
						},
						onApprove: this.onPaypalApprove,
						onCancel: this.onPaypalCancel,
						onError: this.onPaypalError,
					})
					.render('#paypal-button');
			}
		});
		this.$store.dispatch({ type: 'shop/updateCartExpirationTime' });
	},
	data: () => ({
		paymentProccess: false,
	}),
};
</script>
