import { httpClient } from "@/instance/http";
import { isEmpty } from "@/instance/utils";
import { setupFormData } from "@/providers/form";

export default class DoctorService {
	public async create(doctor: any): Promise<boolean | Doctor> {
		const factoryDoctor = setupFormData(doctor);
		const { data: response, status } = await httpClient.post<any>("doctor/create", factoryDoctor, {
			headers: {
				"Content-Type": "multipart/form-data",
			},
		});

		if (response.created === true && status === 200) {
			return response.data as Doctor;
		}
		return false;
	}

	public async update(id: number, doctor: Doctor): Promise<boolean | Doctor> {
		const factoryDoctor = setupFormData(doctor);
		const { data: response, status } = await httpClient.post<any>(`doctor/update/${id}`, factoryDoctor, {
			headers: {
				"Content-Type": "multipart/form-data",
			},
		});

		if (response.updated === true && status === 200) {
			return response.data as Doctor;
		}
		return false;
	}

	public async delete(id: number): Promise<boolean | number> {
		const { data: response, status } = await httpClient.delete<any>(`doctor/delete/${id}`);
		if (response.deleted !== false && status === 200) {
			return response.deleted as number;
		}
		return false;
	}

	public async find(id: number): Promise<boolean | Doctor> {
		const { data: doctor, status } = await httpClient.get<Doctor>(`doctor/find/${id}`);
		if (!isEmpty(doctor) && status === 200) {
			return doctor as Doctor;
		}
		return false;
	}

	public async findAll(): Promise<Boolean | Doctor[]> {
		const { data: doctors, status } = await httpClient.get<Doctor[]>(`doctor`);
		if (!isEmpty(doctors) && status === 200) {
			return doctors as Doctor[];
		}
		return false;
	}

	public async index(): Promise<Boolean | Doctor[]> {
		const { data: doctors, status } = await httpClient.get<Doctor[]>(`doctor`);
		if (!isEmpty(doctors) && status === 200) {
			return doctors as Doctor[];
		}
		return false;
	}

	public async searchAvailable(date: string): Promise<Boolean | Doctor[]> {
		const { data: doctors, status } = await httpClient.get<Doctor[]>(`doctor/availables/${date}`);
		if (!isEmpty(doctors) && status === 200) {
			return doctors as Doctor[];
		}
		return false;
	}
}

export const doctorService = new DoctorService();
