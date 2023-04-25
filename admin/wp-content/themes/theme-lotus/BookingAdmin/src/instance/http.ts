import axios, { AxiosInstance } from 'axios';

export const httpClient: AxiosInstance = axios.create({
	baseURL: import.meta.env.VITE_REST_URL,
	headers: {
		'Content-Type': 'application/json',
	},
});
