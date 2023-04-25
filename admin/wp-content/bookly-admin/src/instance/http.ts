import axios, { AxiosInstance } from 'axios';

export const httpClient: AxiosInstance = axios.create({
	baseURL: /* import.meta.env.VITE_REST_URI */ 'http://localhost/lotus/admin/index.php/wp-json/api/bookly',
	headers: {
		'Content-Type': 'application/json',
	},
});
