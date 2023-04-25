<template>
	<AppLayout class="finish-payment">
		<section class="banner--finish relative">
			<AppContainer v-if="response.message" class="py-32 finish-layer">
				<div class="extra-head">
					<AppLink :to="{ name: 'index' }"> RETURN TO HOME </AppLink>
				</div>
				<article class="payer-detail">
					<h1 class="finish-title">{{ response.message }}</h1>
					<ul class="f-cart-finish">
						<li class="f-cart--item">
							<span class="f-title">NUMBER OF ORDER:</span>
							<span class="f-cont">{{ response.order }}</span>
						</li>
						<li class="f-cart--item">
							<span class="f-title">DATE:</span>
							<span class="f-cont">{{ response.create_time | date }}</span>
						</li>
						<li class="f-cart--item">
							<span class="f-title">EMAIL:</span>
							<span class="f-cont">{{ response.email }}</span>
						</li>
						<li class="f-cart--item">
							<span class="f-title">TOTAL:</span>
							<span class="f-cont">
								{{ totalPrice | currency }}
							</span>
						</li>
						<li class="f-cart--item">
							<span class="f-title">PAYMENT EMAIL:</span>
							<span class="f-cont">{{ response.payer.email_address }}</span>
						</li>
						<li class="f-cart--item">
							<span class="f-title">PAYMENT METHOD:</span>
							<span class="f-cont">PayPal</span>
						</li>
					</ul>
				</article>
				<article class="order-table">
					<h2 class="finish-title">Order details</h2>
					<table class="product--finish-list">
						<thead>
							<tr>
								<td>Product</td>
								<td>Total</td>
							</tr>
						</thead>
						<tbody>
							<tr v-for="item in response.purchase_units[0].items" :key="item.id">
								<td>
									<span class="text-gray-five">{{ item.name }}</span>
									<span class="font-semibold text-orange-p">x</span>
									<span class="font-semibold text-green-dark">{{ item.quantity }}</span>
								</td>
								<td>{{ item.unit_amount.value | currency }}</td>
							</tr>
							<tr>
								<td><strong> Delivery: </strong></td>
								<td>{{ response.purchase_units[0].amount.breakdown.shipping.value | currency }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td><strong>Payment method:</strong></td>
								<td><strong>Paypal</strong></td>
							</tr>
							<tr>
								<td class="last"><strong>Total:</strong></td>
								<td class="last">
									<strong>
										{{ totalPrice | currency }}
									</strong>
								</td>
							</tr>
						</tfoot>
					</table>
				</article>
			</AppContainer>
		</section>
	</AppLayout>
</template>

<script>
import './__complete.pcss';
import { mapGetters, mapState } from 'vuex';
export default {
	name: 'PaymentComplete',
	computed: {
		...mapGetters('user', {
			response: 'getPayerInformation',
		}),
		...mapState({
			common: state => state.common,
		}),
		totalPrice() {
			return (
				Number(this.response.purchase_units[0].amount.breakdown.item_total.value) +
				Number(this.response.purchase_units[0].amount.breakdown.shipping.value)
			);
		},
	},
	data() {
		return {
			// response: {
			// 	id: "24T67140H5996572R",
			// 	intent: "CAPTURE",
			// 	status: "success",
			// 	purchase_units: [
			// 		{
			// 			reference_id: "default",
			// 			amount: {
			// 				currency_code: "USD",
			// 				value: "530.00",
			// 				breakdown: {
			// 					item_total: { currency_code: "USD", value: "230.00" },
			// 					shipping: { currency_code: "USD", value: "300.00" },
			// 					handling: { currency_code: "USD", value: "0.00" },
			// 					insurance: { currency_code: "USD", value: "0.00" },
			// 					shipping_discount: { currency_code: "USD", value: "0.00" },
			// 				},
			// 			},
			// 			payee: {
			// 				email_address: "sb-wvurc6396079@business.example.com",
			// 				merchant_id: "MENFPKFJBSG66",
			// 			},
			// 			description: "Crema de Aloe Vera",
			// 			items: [
			// 				{
			// 					name: "Crema de Aloe Vera",
			// 					unit_amount: { currency_code: "USD", value: "230.00" },
			// 					tax: { currency_code: "USD", value: "0.00" },
			// 					quantity: "1",
			// 				},
			// 			],
			// 			shipping: {
			// 				name: { full_name: "John Doe" },
			// 				address: {
			// 					address_line_1: "1 Main St",
			// 					admin_area_2: "San Jose",
			// 					admin_area_1: "CA",
			// 					postal_code: "95131",
			// 					country_code: "US",
			// 				},
			// 			},
			// 			payments: {
			// 				captures: [
			// 					{
			// 						id: "7GN19390W5969810E",
			// 						status: "COMPLETED",
			// 						amount: { currency_code: "USD", value: "530.00" },
			// 						final_capture: true,
			// 						seller_protection: {
			// 							status: "ELIGIBLE",
			// 							dispute_categories: ["ITEM_NOT_RECEIVED", "UNAUTHORIZED_TRANSACTION"],
			// 						},
			// 						create_time: "2022-06-08T15:58:44Z",
			// 						update_time: "2022-06-08T15:58:44Z",
			// 					},
			// 				],
			// 			},
			// 		},
			// 	],
			// 	payer: {
			// 		name: { given_name: "John", surname: "Doe" },
			// 		email_address: "tai@amg.com",
			// 		payer_id: "9GCFSHTBMA8TY",
			// 		address: {
			// 			address_line_1: "Jr. Enrique Nerine 995 - San Luis",
			// 			address_line_2: "Mi apartamento",
			// 			admin_area_2: "San Luis",
			// 			admin_area_1: "Perú",
			// 			postal_code: "15022",
			// 			country_code: "US",
			// 		},
			// 	},
			// 	create_time: "2022-06-08T15:58:28Z",
			// 	update_time: "2022-06-08T15:58:44Z",
			// 	links: [
			// 		{
			// 			href: "https://api.sandbox.paypal.com/v2/checkout/orders/24T67140H5996572R",
			// 			rel: "self",
			// 			method: "GET",
			// 		},
			// 	],
			// 	message: "Thank you. Your order has been received.",
			// 	order: "480",
			// 	date: { date: "2022-06-08 15:58:49.000000", timezone_type: 1, timezone: "+00:00" },
			// 	email: "email@address.com",
			// },
		};
	},
};
</script>
