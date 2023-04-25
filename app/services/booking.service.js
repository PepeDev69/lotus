import { httpClient } from '~/plugins/http';

export class BookingService {
	async findAvailableSpecialists(date) {
		try {
			const { data: specialists } = await httpClient.get(`/bookly/doctor/availables/${date}`);
			return specialists;
		} catch (error) {
			throw error;
		}
	}

	async findTimeRange(date) {
		try {
			const { data: times } = await httpClient.get(`/bookly/schedule/date-range/${date}`);
			return times;
		} catch (error) {
			throw error;
		}
	}
}

export const bookingService = new BookingService();
