export interface Product {
	id: number;
	quantity: number;
	name?: string;
}

export interface Service {
	id: number;
	quantity: number;
	name: string
	doctor: number;
	from: string;
	to: string;
}

export interface User {
	name: string;
	last_name: string;
	company: string;
	email: string;
	phone: number;
	address_1: string;
	address_2: string;
	city: string;
	state: string;
	postcode: number;
	country: string;
}


export interface ShopStore {
	shopCart: any[],
	user: User,
}