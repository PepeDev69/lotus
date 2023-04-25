// === VUEX SHOP MODULE ===
/** @returns { import('./../../services/x-models').ShopStore } */

export default () => ({
	shopCart: {
		products: [],
		services: [],
	},
	deliveryAmount: {
		limit: 600,
		amount: 10,
	},
	loading: false,
});
