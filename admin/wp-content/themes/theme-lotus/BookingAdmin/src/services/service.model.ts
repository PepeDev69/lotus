type Gender = 'Masculino' | 'Femenino';
interface Doctor {
	id?: number;
	first_name: string;
	last_name: string;
	fullname?: string;
	gender: Gender;
	email: string;
	avatar: File | string;
	position: string;
}

interface UserStore {
	loading: boolean;
	doctors: Doctor[];
}

interface SimpleDoctor {
	id: number;
	name: string;
}

interface Service {
	id?: number;
	name: string;
	paid: number;
}

interface Customer {
	id?: number;
	name: string;
	phone: string;
	email: string;
	address?: string;
	note?: string;
	paid?: number;
}
interface Schedule {
	id?: number;
	from: string;
	to: string;
	doctor: SimpleDoctor;
	service: Service;
	customer: Customer;
}

interface SendSchedule {
	id?: number;
	from: string;
	to: string;
	doctor: number;
	service: number;
	customer: Customer;
}

interface SelectSchedule {
	date: string;
	schedules: Schedule[];
}

interface SampleSchedule {
	date?: string;
	count?: number;
	schedules?: Record<string, Schedule[] | []>;
}

interface AbstractService {
	id: number;
	name: string;
	slug: string;
	price: number;
	partial: number;
}

// ============================

interface AbstractSelect {
	value: any;
	label: any;
}
interface Specialist {
	loading: boolean;
	values: AbstractSelect[];
}

// =============================  ENTITIES ===================

// ? DOCTOR ENTITY
interface DoctorEntity {
	id?: number;
	first_name: string;
	last_name: string;
	fullname?: string;
	gender: Gender;
	email: string;
	avatar: File | string;
	position: string;
}

interface SimpleDoctorEntity {
	id: number;
	name: string;
}

// ? CUSTOMER ENTITY
interface CustomerEntity {
	id?: number;
	name: string;
	phone: string;
	email: string;
	address?: string;
	note?: string;
	paid?: number;
}

//? SERVICE ENTITY
interface ServiceEntity {
	id?: number;
	name: string;
	slug?: string;
	price: number;
}

// ? SCHEDULE ENTITY
interface ScheduleEntity {
	id?: number;
	from: string;
	to: string;
	doctor: SimpleDoctorEntity;
	service: ServiceEntity;
	customer: CustomerEntity;
}

//

interface ServiceComplete {
	id: number;
	date: string;
	slug: string;
	name: string;
	price: number;
	partial: number;
	picture: string;
}
