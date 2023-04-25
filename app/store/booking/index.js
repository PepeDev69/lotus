import types from "@/store/mutation-types";
import { bookingService } from "~/services/booking.service";

export const state = () => ({
	date: "",
	loading: false,
	users: [],
	times: {
		AM: [],
		PM: [],
	},
});

export const mutations = {
	[types.SET_DATE_BOOKING]: (state, payload) => {
		state.date = payload;
	},
	[types.SET_AVAILABLE_USERS]: (state, payload) => {
		state.users = payload;
	},
	[types.SET_BOOKING_SCHEDULE]: (state, { times, date }) => {
		state.times = times;
		state.date = date;
	},
	[types.BOOKING_FETCH_STATUS]: (state, payload) => {
		state.loading = true;
	},
	[types.BOOKING_FETCH_SUCCESS]: (state, payload) => {
		state.loading = false;
	},
};

export const actions = {
	setBookingDate({ commit }, date) {
		commit(types.SET_DATE_BOOKING, date);
	},
	async setBookingTime({ commit }, { time }) {
		try {
			commit(types.BOOKING_FETCH_STATUS);
			const users = await bookingService.findAvailableSpecialists(time);
			commit(types.SET_AVAILABLE_USERS, users);
			commit(types.BOOKING_FETCH_SUCCESS);
		} catch (error) {
			commit(types.ERROR_EVENT, {
				open: true,
			});
		}
	},
	async setBookingSchedule({ commit }, { date }) {
		try {
			commit(types.BOOKING_FETCH_STATUS);
			const times = await bookingService.findTimeRange(date);
			commit(types.BOOKING_FETCH_SUCCESS);
			commit(types.SET_BOOKING_SCHEDULE, { times, date });
		} catch (error) {
			commit(types.ERROR_EVENT, {
				open: true,
			});
		}
	},
};

export const getters = {
	getAvailableSpecialist(store) {
		return store.availables;
	},
};
