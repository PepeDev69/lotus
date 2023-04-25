import { httpClient } from '@/instance/http';
import { isEmpty } from 'lodash';

export class CommonService {
	public async findServices(): Promise<boolean | AbstractService[]> {
		const { data: services } = await httpClient.get<AbstractService[]>('/services');
		if (!isEmpty(services)) {
			return services;
		}
		return false;
	}

	public async findConfig(): Promise<any> {
		const { data: config } = await httpClient.get('/config');
		if (!isEmpty(config)) {
			return config;
		}
		return false;
	}

	public async findServicesComplete(): Promise<any> {
		const { data: services } = await httpClient.get('/services/all');
		if (!isEmpty(services)) {
			return services;
		}
		return false;
	}
}

export const mainService = new CommonService();
