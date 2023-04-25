import types from '@/store/mutation-types';

export const state = () => ({
	shopper: {
		name: '',
		last_name: '',
		// company: '',
		email: '',
		phone: 0,
		// address: '',
		// apartment: '',
		// city: '',
		// state: '',
		// zipcode: 0,
		// country: '',
	},
	validate: {
		name: false,
		last_name: false,
		// address: false,
		// city: false,
		// state: false,
		phone: false,
		email: false,
		// zipcode: false,
	},
	rules: {
		name: {
			valid: false,
			error: '',
		},
		last_name: {
			valid: false,
			error: '',
		},
		// address: {
		// 	valid: false,
		// 	error: '',
		// },
		// city: {
		// 	valid: false,
		// 	error: '',
		// },
		// state: {
		// 	valid: false,
		// 	error: '',
		// },
		phone: {
			valid: false,
			error: '',
		},
		email: {
			valid: false,
			error: '',
		},
		// zipcode: {
		// 	valid: false,
		// 	error: '',
		// },
	},
	payedShopper: {},
});

export const mutations = {
	[types.UPDATE_SHOPPER]: (state, { key = '', value = '' }) => {
		state.shopper[key] = value;
	},

	[types.DELETE_SHOPPER]: state => {
		for (let key in state.shopper) {
			state.shopper[key] = '';
		}
		for (let key in state.validate) {
			state.validate[key] = false;
		}
	},

	[types.VALIDATE_FORM]: (state, { key = '', value = false }) => {
		state.validate[key] = value;
	},

	[types.SET_PAYED_SHOPPER]: (state, payload) => {
		state.payedShopper = payload;
	},
};

export const actions = {
	updateShopper({ commit }, payload) {
		commit(types.UPDATE_SHOPPER, payload);
	},

	deleteShopper({ commit }) {
		commit(types.DELETE_SHOPPER);
	},

	makeValidate({ commit }, payload) {
		commit(types.VALIDATE_FORM, payload);
	},

	setPayedShopper({ commit }, payload) {
		commit(types.SET_PAYED_SHOPPER, payload);
	},
};

export const getters = {
	formatShopperForPaypal({ shopper }) {
		const payer = {
			name: {
				given_name: shopper.name,
				surname: shopper.last_name,
			},
			email_address: shopper.email,
			// address: {
			// 	address_line_1: shopper.address,
			// 	address_line_2: shopper.apartment,
			// 	admin_area_2: shopper.city,
			// 	admin_area_1: shopper.state,
			// 	postal_code: shopper.zipcode,
			// 	country_code: "US",
			// },
			phone: {
				phone_type: 'MOBILE',
				phone_number: {
					national_number: shopper.phone,
				},
			},
		};
		return payer;
	},
	verifyRequiredFormInput(state) {
		return Object.values(state.validate).every(item => item === true);
	},
	getPayerInformation(state) {
		return state.payedShopper;
	},
};
