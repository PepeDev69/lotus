import { flat } from '~/functions/flat';
import { flatMap } from '~/functions/flatMap';

export default {
	getShopCart({ shopCart }) {
		return shopCart;
	},

	getProductById: state => id => {
		return state.shopCart?.products.find(product => {
			return product.id === id;
		});
	},

	getServiceById: state => id => {
		return state.shopCart?.services.find(service => {
			return service.id === id;
		});
	},

	getCartCount({ shopCart }, getters) {
		if (!getters.isCartEmpty) {
			return flat(shopCart).reduce((acc, product) => {
				return acc + parseInt(product.quantity);
			}, 0);
		}
		return 0;
	},

	isCartEmpty({ shopCart }) {
		return flat(shopCart).length <= 0;
	},

	getCartTotalAmount({ shopCart, deliveryAmount }, getters) {
		const defaultAmount = { count: 0, partial: 0, taxes: 0, totalAmount: 0 };
		if (!getters.isCartEmpty) {
			const mergedProducts = flat(shopCart);
			const total = mergedProducts.reduce((acc, product) => {
				return product.paid ? acc + product.paid * product.quantity : acc + product.price * product.quantity;
			}, 0);
			const taxes = total < deliveryAmount.limit ? deliveryAmount.amount : 0;
			return {
				count: getters.getCartCount,
				partial: total,
				taxes,
				totalAmount: total + taxes,
			};
		}
		return defaultAmount;
	},

	getTotalAmountInParts({ shopCart, deliveryAmount }, getters) {
		const defaultAmount = { count: 0, partial: 0, taxes: 0, totalAmount: 0 };
		if (!getters.isCartEmpty) {
			const mergedProducts = flat(shopCart);

			const total = mergedProducts.reduce((acc, product) => {
				return product.paid ? acc + product.paid * product.quantity : acc + product.price * product.quantity;
			}, 0);

			const productsTotal = shopCart.products.reduce((acc, product) => {
				return acc + product.price * product.quantity;
			}, 0);

			const taxes = productsTotal < deliveryAmount.limit ? deliveryAmount.amount : 0;
			const finalTaxes = shopCart.products.length > 0 ? taxes : 0;

			return {
				count: getters.getCartCount,
				partial: total,
				taxes: finalTaxes,
				totalAmount: total + deliveryAmount.amount,
			};
		}
		return defaultAmount;
	},

	getProductForPaypal({ shopCart }, getters) {
		const totalAmount = getters.getTotalAmountInParts;
		const amount = {
			value: Number(totalAmount.totalAmount).toFixed(2),
			currency_code: 'USD',
			breakdown: {
				item_total: {
					value: Number(totalAmount.partial).toFixed(2),
					currency_code: 'USD',
				},
			},
		};

		if (totalAmount.taxes > 0) {
			amount.breakdown.shipping = {
				value: totalAmount.taxes.toFixed(2),
				currency_code: 'USD',
			};
		}

		const products = flatMap(shopCart, product => {
			const price = product.paid ? product.paid : product.price;
			return {
				name: product.name,
				unit_amount: { value: price, currency_code: 'USD' },
				quantity: product.quantity,
			};
		});
		return {
			amount,
			items: products,
		};
	},

	getTotalInformationForPaypal(state, getters, rootState, rootGetters) {
		const shopper = rootGetters['user/formatShopperForPaypal'];
		const products = getters.getProductForPaypal;
		return {
			intent: 'CAPTURE',
			payer: shopper,
			purchase_units: [products],
		};
	},

	withServicesDefinedTimeline(state) {
		return state.shopCart.services.every(item => item.from != null);
	},

	formatProductForCreateOrder(state) {
		const products = state.shopCart.products.map(product => ({
			id: product.id,
			quantity: product.quantity,
		}));
		const services = state.shopCart.services.map(service => ({
			id: service.id,
			quantity: service.quantity,
			doctor: service.doctor,
			from: service.from,
			to: service.to,
		}));
		return { products, services };
	},

	getDataOnPaymentCompleted(state, getters, rootState, rootGetters) {},
};
