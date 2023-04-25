import { httpClient } from '@/instance/http';
import { isEmpty } from '@/instance/utils';
export class AppointmentService {
	public async create(schedule: SendSchedule): Promise<boolean | Schedule> {
		const { data: response, status } = await httpClient.post<any>('schedule/create', schedule);
		if (response.created === true && status === 200) {
			return response.data as Schedule;
		}
		return false;
	}

	public async update(id: number, schedule: SendSchedule): Promise<boolean> {
		const { data: response, status } = await httpClient.put<any>(`schedule/update/${id}`, schedule);
		if (response.updated === true && status === 200) {
			return true;
		}
		return false;
	}

	public async delete(id: number): Promise<boolean> {
		const { data: response, status } = await httpClient.delete<any>(`schedule/delete/${id}`);
		if (response.deleted === true && status === 200) {
			return true;
		}
		return false;
	}

	public async find(id: number): Promise<boolean | Schedule> {
		const { data: schedule, status } = await httpClient.get<Schedule>(`schedule/find/${id}`);
		if (!isEmpty(schedule) && status === 200) {
			return schedule as Schedule;
		}
		return false;
	}

	public async findCompleteByDate(date: string): Promise<boolean | SampleSchedule> {
		const { data: schedule } = await httpClient.get<SampleSchedule>(`schedule/find-by-date/${date}`);
		if (!isEmpty(schedule)) {
			return schedule as SampleSchedule;
		}
		return false;
	}

	public async findCompleteByDoctor(doctor: number): Promise<boolean | Schedule[]> {
		const { data: schedule } = await httpClient.get<Schedule[]>(`schedule/find-by-doctor/${doctor}`);
		if (!isEmpty(schedule)) {
			return schedule as Schedule[];
		}
		return false;
	}

	public async getAll(): Promise<boolean | Schedule[]> {
		const { data: schedules, status } = await httpClient.get<Schedule[]>(`schedule`);
		if (!isEmpty(schedules) && status === 200) {
			return schedules as Schedule[];
		}
		return false;
	}
}

export const appointmentService = new AppointmentService();
