import types, { cartSymbol } from '@/store/mutation-types';
import { sessionStorageManager } from '~/plugins/Storage';

export default {
	[types.FILL_SHOP_CART]: (state, payload) => {
		state.shopCart = payload;
	},

	[types.DELETE_SHOP_CART]: state => {
		state.shopCart = { products: [], services: [] };
	},

	[types.UPDATE_CART_EXPIRATION]: state => {
		sessionStorageManager.updateExpirationTime(cartSymbol);
	},

	[types.ADD_PRODUCT]: (state, products) => {
		state.shopCart.products = products;
	},

	[types.UPDATE_PRODUCT]: (state, { id, value }) => {
		state.shopCart.products = state.shopCart?.products.map(product => {
			if (product.id === id) {
				product.quantity = parseInt(value);
			}
			return { ...product };
		});
	},

	[types.DELETE_PRODUCT]: (state, products) => {
		state.shopCart.products = products;
	},

	[types.ADD_SERVICE]: (state, services) => {
		state.shopCart.services = services;
	},

	[types.UPDATE_SERVICE]: (state, { id, from, to, doctor }) => {
		state.shopCart.services = state.shopCart?.services.map(service => {
			if (service.id === id) {
				service.from = from;
				service.to = to;
				service.doctor = doctor;
			}
			return { ...service };
		});
	},

	[types.UPDATE_SERVICE_PAID]: (state, { id, currency }) => {
		state.shopCart.services = state.shopCart?.services.map(service => {
			if (service.id === id) {
				service.paid = currency;
			}
			return { ...service };
		});
	},

	[types.DELETE_SERVICE]: (state, services) => {
		state.shopCart.services = services;
	},

	START_FETCHING: state => {
		state.loading = true;
	},

	FINISH_FETCHING: state => {
		state.loading = false;
	},
};
