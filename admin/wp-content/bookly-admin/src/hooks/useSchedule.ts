import { getCurrentDay } from "@/instance/date";
import { scheduleService } from "@/services/schedule.service";
import { ComputedRef, ref } from "vue";

export const useSchedule = () => {
	const date = ref<string>(getCurrentDay(new Date()));
	const today = ref<SampleSchedule>({
		date: date.value,
		count: 0,
		schedules: {},
	});

	const loading  = ref<boolean>(false)
	const fetching = ref<boolean>(true);
	const mutateId = ref<number>(null);

	const fetchSchedule = async (byDate: string) => {
		date.value = byDate;
		fetching.value = true;
		try {
			const data = await scheduleService.findCompleteByDate(byDate);
			today.value = data as SampleSchedule;
			fetching.value = false;
		} catch (error) {
			fetching.value = false;
		} finally {
			fetching.value = false;
		}
	};

	const deleteSchedule = async (id: number) => {
		mutateId.value = id;
		const deleted = await scheduleService.delete(id);
		if (deleted != false) {
			const data = await scheduleService.findCompleteByDate(date.value);
			today.value = data as SampleSchedule;
		}
		mutateId.value = null;
	};

	const updateSchedule = async (id: number, schedule: SendSchedule) => {
		loading.value = true
		scheduleService.update(id, schedule).then((success) => {
			if (success === true) {
			}
		});
		loading.value = false
	};

	const createSchedule = async (schedule: SendSchedule) => {
		loading.value = true
		const created = await scheduleService.create(schedule);
		if (created != false) {
			const data = await scheduleService.findCompleteByDate(date.value);
			today.value = data as SampleSchedule;
			return "success"
		}
		loading.value = false
	};

	return {
		fetchSchedule,
		deleteSchedule,
		updateSchedule,
		createSchedule,
		date,
		today,
		mutateId,
		fetching,
		loading
	};
};
