import types, { cartSymbol } from '@/store/mutation-types';
import { sessionStorageManager } from '~/plugins/Storage';
import { shopService } from '~/services/shop.service';

export default {
	// Common Actions
	shopCartMount({ commit }) {
		const shopCart = sessionStorageManager.getItem(cartSymbol);
		if (Boolean(shopCart) !== false) {
			commit(types.FILL_SHOP_CART, shopCart);
		}
	},

	deleteShopCart({ commit }) {
		commit(types.DELETE_SHOP_CART);
	},

	updateCartExpirationTime({ commit }, payload) {
		commit(types.UPDATE_CART_EXPIRATION);
	},

	// Product Actions
	async addProduct({ commit, dispatch }, { id, name, price, quantity, picture, lang }) {
		try {
			commit('START_FETCHING');
			const response = await shopService.verifyProduct(id, quantity);
			if (response !== true) {
				commit('FINISH_FETCHING');
				return dispatch('event/triggerWarningEvent', response, { root: true });
			}
			const products = sessionStorageManager.getItem(cartSymbol, 'products') || [];
			const productFound = products.find(product => product.id == id);
			if (!productFound) {
				const newProduct = {
					id: id,
					name: name,
					price: price,
					quantity: quantity,
					picture: picture,
				};
				products.push(newProduct);
			} else {
				productFound.quantity += parseInt(quantity);
			}
			commit('FINISH_FETCHING');
			commit(types.ADD_PRODUCT, products);
			if (lang === 'es') {
				dispatch('event/triggerSuccessEvent', 'Producto agregado satisfactoriamente', { root: true });
			}
			if (lang === 'en') {
				dispatch('event/triggerSuccessEvent', 'Product successfully added', { root: true });
			}
		} catch (error) {
			dispatch('event/triggerErrorEvent', 'Error in Server', { root: true });
		}
	},

	async updateProduct({ commit, dispatch, state }, { id, value, lang }) {
		try {
			commit('START_FETCHING');
			const message = await shopService.verifyProduct(id, value);
			if (message !== true) {
				commit('FINISH_FETCHING');
				return dispatch('event/triggerWarningEvent', message, { root: true });
			}
			commit('FINISH_FETCHING');
			commit(types.UPDATE_PRODUCT, { id, value });

			if (lang === 'es') {
				dispatch('event/triggerSuccessEvent', 'Producto actualizado satisfactoriamente', { root: true });
			}
			if (lang === 'en') {
				dispatch('event/triggerSuccessEvent', 'Product succesfuly upgraded', { root: true });
			}
		} catch (error) {
			dispatch('event/triggerErrorEvent', 'Error in Server', { root: true });
		}
	},

	deleteProduct({ commit, state }, id) {
		const newState = state.shopCart?.products.filter(product => {
			return product.id !== id;
		});
		commit(types.DELETE_PRODUCT, newState);
	},

	// Services Actions
	addService({ commit, dispatch }, { id, name, paid, price, partial, quantity, picture, from, to, doctor, lang }) {
		const services = sessionStorageManager.getItem(cartSymbol, 'services') || [];
		const serviceFound = services.find(service => service.id == id);
		if (!serviceFound) {
			const newService = {
				id: id,
				name: name,
				paid: paid,
				price: price,
				partial: partial,
				quantity: quantity,
				picture: picture,
				from: from,
				to: to,
				doctor: doctor,
			};
			services.push(newService);
			if (lang === 'es') {
				dispatch('event/triggerSuccessEvent', 'Servicio agregado satisfactoriamente', { root: true });
			}
			if (lang === 'en') {
				dispatch('event/triggerSuccessEvent', 'Service successfully added', { root: true });
			}
		} else {
			if (lang === 'en') {
				return dispatch('event/triggerWarningEvent', 'Service already added to cart', { root: true });
			}
			if (lang === 'es') {
				return dispatch('event/triggerWarningEvent', 'El servicio ya fue agregado al carrito', { root: true });
			}
		}
		commit(types.ADD_SERVICE, services);
	},

	// * @see bookingService
	async updateService({ commit, dispatch }, payload) {
		commit(types.UPDATE_SERVICE, payload);
		dispatch('event/triggerSuccessEvent', 'Update Service Successfuly', { root: true });
	},

	deleteService({ commit, state }, id) {
		const newState = state.shopCart?.services.filter(service => {
			return service.id != id;
		});
		commit(types.DELETE_SERVICE, newState);
	},

	updatePayedCurrency({ commit, state }, { id, currency }) {
		commit(types.UPDATE_SERVICE_PAID, { id, currency });
	},
};
