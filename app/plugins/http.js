import axios from 'axios';
import { uuid, unique } from '@/plugins/utils';

const API_URL =
	process.env.NODE_ENV === 'production'
		? 'https://lotusstetic.amgbusiness.us/index.php/wp-json/api'
		: 'http://localhost/lotus/admin/index.php/wp-json/api';

export const httpClient = axios.create({
	baseURL: API_URL,
	headers: {
		Accept: '*',
	},
});

httpClient.interceptors.request.use(
	config => {
		config.params = { tk: unique() };
		return config;
	},
	error => {
		return Promise.reject(error);
	}
);
