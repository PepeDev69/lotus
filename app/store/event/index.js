import types from '@/store/mutation-types';

export const state = () => ({
	type: 'safe',
	open: false,
	message: '',
});

export const mutations = {
	[types.ERROR_EVENT]: (state, { open, message }) => {
		state.type = 'error';
		state.open = true;
		state.message = message;
	},

	[types.WARNING_EVENT]: (state, { open, message }) => {
		state.type = 'warning';
		state.open = true;
		state.message = message;
	},

	[types.SUCCESS_EVENT]: (state, message) => {
		state.type = 'safe';
		state.open = true;
		state.message = message;
	},
	[types.GENERIC_EVENT]: (state, { type, message }) => {
		state.type = type;
		state.open = true;
		state.message = message;
	},
	[types.REMOVE_EVENT]: state => {
		state.open = false;
		state.message = '';
	},
};

export const actions = {
	resetEvent() {},
	triggerEvent({ commit }, { type, message }) {
		commit(types.GENERIC_EVENT, { type, message });
		setTimeout(() => {
			commit(types.REMOVE_EVENT);
		}, 4000);
	},
	triggerSuccessEvent({ dispatch }, message) {
		if (
			message === 'Servicio agregado satisfactoriamente' ||
			message === 'Producto agregado satisfactoriamente' ||
			message === 'Producto actualizado satisfactoriamente'
		) {
			dispatch('triggerEvent', { type: 'proceso exitoso', message });
		} else {
			dispatch('triggerEvent', { type: 'successful process', message });
		}
	},
	triggerWarningEvent({ dispatch }, message) {
		console.log(message);
		if (
			message === 'Por favor, completar el formulario' ||
			message === 'Seleccione fecha y hora' ||
			message === 'Selecione un especialista que lo atendera'
		) {
			dispatch('triggerEvent', { type: 'aviso', message });
		} else {
			dispatch('triggerEvent', { type: 'warning', message });
		}
	},
	triggerErrorEvent({ dispatch }, message) {
		dispatch('triggerEvent', { type: 'error', message });
	},
	hideEventMessage({ commit }, value = true) {
		commit(types.REMOVE_EVENT);
	},
};
