import { httpClient } from '@/plugins/http';
import types, { cartSymbol } from '@/store/mutation-types';
import { sessionStorageManager } from '@/plugins/Storage';

const localStorageManager = store => {
	store.subscribe((mutation, { shop }) => {
		if (process.client) {
			sessionStorageManager.setItem(cartSymbol, shop.shopCart);
		}
	});
};

export const plugins = [localStorageManager];

export const state = () => ({
	common: {},
	polylang: {},
	siteMeta: {},
});

export const getters = {
	getOption(state) {
		return state.common;
	},
	getPolylangCommon(state) {
		return state.polylang;
	},
	getSiteMetadata(state) {
		return state.siteMeta;
	},
};

export const mutations = {
	[types.SET_COMMON_OPTION]: (state, payload) => {
		state.common = payload;
		state.siteMeta.GOOGLE_ANALITICS = payload.cell;
	},
	[types.SET_POLYLANG_COMMON]: (state, payload) => {
		state.polylang = payload;
	},
	[types.SET_SITE_METADATA]: (state, payload) => {
		state.siteMeta = payload;
	},
	[types.SET_DELIVERY_AMOUNT]: (state, payload) => {
		state.shop.deliveryAmount = payload;
	},
};

export const actions = {
	async nuxtServerInit({ commit }) {
		const [{ data: common }, { data: polylang }, { data: meta }] = await Promise.all([
			httpClient.get(`/common`),
			httpClient.get(`/common?lang=${this.$i18n.locale}`),
			httpClient.get(`/site-meta`),
		]);
		commit(types.SET_COMMON_OPTION, common);
		commit(types.SET_POLYLANG_COMMON, polylang);
		commit(types.SET_SITE_METADATA, meta);
		commit(types.SET_DELIVERY_AMOUNT, { limit: Number(meta.delivery_limit), amount: Number(meta.delivery_amount) });
	},
	updateCommonOptions({ commit }, payload) {
		commit(types.SET_POLYLANG_COMMON, payload);
	},
};
