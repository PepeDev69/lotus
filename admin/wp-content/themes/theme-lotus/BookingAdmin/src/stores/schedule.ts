import { getCurrentDay } from '@/instance/date';
import { appointmentService } from '@/services/schedule.service';
import { defineStore } from 'pinia';
import { reactive, ref, toRefs } from 'vue';

export const useScheduleStore = defineStore('schedule', () => {
	const date = ref<string>(getCurrentDay(new Date()));
	const state = reactive({
		today: {
			date: date.value,
			count: 0,
			schedules: {},
		} as SampleSchedule,
		loading: false,
		fetching: true,
		mutateId: null,
		schedule: {} as Schedule,
		openSide: false,
	});

	const fetchSchedule = async (byDate: string) => {
		date.value = byDate;
		state.fetching = true;
		try {
			const data = await appointmentService.findCompleteByDate(byDate);
			state.today = data as SampleSchedule;
			state.fetching = false;
		} catch (error) {
			state.fetching = false;
		} finally {
			state.fetching = false;
		}
	};

	const deleteSchedule = async (id: number) => {
		state.mutateId = id;
		const deleted = await appointmentService.delete(id);
		if (deleted != false) {
			const data = await appointmentService.findCompleteByDate(date.value);
			state.today = data as SampleSchedule;
		}
		state.mutateId = null;
	};

	const updateSchedule = async (id: number, schedule: SendSchedule) => {
		state.loading = true;
		const created = await appointmentService.update(id, schedule);
		if (created != false) {
			const data = await appointmentService.findCompleteByDate(state.today.date);
			state.today = data as SampleSchedule;
			state.loading = false;
			return 'success';
		}
		state.loading = false;
	};

	const createSchedule = async (schedule: SendSchedule) => {
		state.loading = true;
		const created = await appointmentService.create(schedule);
		if (created != false) {
			const data = await appointmentService.findCompleteByDate(state.today.date);
			state.today = data as SampleSchedule;
			state.loading = false;
			return 'success';
		}
		state.loading = false;
	};

	const findOneSchedule = async (id: number) => {
		state.loading = true;
		const scheduled = await appointmentService.find(id);
		state.schedule = scheduled as Schedule;
		state.loading = false;
		state.openSide = true;
	};

	const closeSideCard = () => void (state.openSide = false);

	return {
		date,
		...toRefs(state),
		fetchSchedule,
		deleteSchedule,
		updateSchedule,
		createSchedule,
		findOneSchedule,
		closeSideCard,
	};
});
