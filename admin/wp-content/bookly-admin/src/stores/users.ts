import { scheduleService } from '@/services/schedule.service';
import { doctorService } from '@service/doctor.service';
import { defineStore } from 'pinia';

export type UserRootState = {
	users: Doctor[];
	criteria: string;
	loading: boolean;
	fetching: boolean;
	error: boolean;
	errorMessage: string;
	mutateId: number | null;
	schedules: Schedule[];
};

export const useUserStore = defineStore('user', {
	state: (): UserRootState => ({
		users: [],
		criteria: '',
		loading: false,
		fetching: false,
		error: false,
		errorMessage: '',
		mutateId: null,
		schedules: [],
	}),
	actions: {
		// Fetch initial users and fill store
		async fetchUsers() {
			this.fetching = true;
			try {
				const users = await doctorService.index();
				this.users = users as Doctor[];
			} catch (error) {
				console.log(error);
			}
			this.fetching = false;
		},

		// Upadate user and mutate state
		async updateUser(id: number, user: Doctor) {
			this.mutateId = id;
			this.loading = true;
			try {
				const userFromServer = await doctorService.update(id, user);
				if (userFromServer === false) {
					return (this.errorMessage = 'Hubo un error en la actulaizacion');
				}
				this.users = this.users.map((user: Doctor) => {
					if (user.id == (userFromServer as Doctor).id) {
						user = userFromServer as Doctor;
					}
					return { ...user };
				});
				return 'success';
			} catch (error) {
				console.log(error);
			} finally {
				this.loading = false;
				this.mutateId = null;
			}
		},

		// Create user and mutate state
		async createUser(user: Doctor) {
			this.loading = true;
			try {
				const userFromServer = await doctorService.create(user);
				if (!userFromServer) {
					return (this.errorMessage = 'Hubo un error en la actulaizacion');
				}
				this.users.length > 0
					? this.users.unshift(userFromServer as Doctor)
					: this.users.push({ ...(userFromServer as Doctor) });
				this.loading = false;
				return 'success';
			} catch (error) {
				this.loading = false;
				console.log(error);
			}
		},

		// Delete user and filtered users in store
		async deleteUser(id: number) {
			this.mutateId = id;
			this.loading = true;
			try {
				const deleted = await doctorService.delete(id);
				if (!deleted) {
					return (this.errorMessage = 'Fallo la elimanacion');
				}
				this.users = this.users.filter((user: Doctor) => user.id != deleted);
			} catch (error) {
				console.log(error);
			}
			this.mutateId = null;
			this.loading = false;
		},

		async fetchScheduleByUser(id: number) {
			this.mutateId = id;
			this.loading = true;
			try {
				const schedules = await scheduleService.findCompleteByDoctor(id);
				if (!schedules) {
					return (this.errorMessage = 'Fallo la elimanacion');
				}
				this.schedules = schedules as Schedule[];
			} catch (error) {
				console.log(error);
			}
			this.mutateId = null;
			this.loading = false;
		},

		// Mutate filtered users
		defineFilteredCriteria(criteria: string) {
			setTimeout(() => {
				this.criteria = criteria;
			}, 500);
		},
	},

	getters: {
		filteredUsers: state => {
			return Boolean(state.criteria)
				? state.users.filter(user => user.fullname && user.fullname.toLowerCase().includes(state.criteria))
				: state.users;
		},
	},
});
