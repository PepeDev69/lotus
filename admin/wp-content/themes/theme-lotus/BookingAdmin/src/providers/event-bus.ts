import mitt from "mitt";

export type FinishBus = {
	status: boolean,
	id?: number
}

export type FinishEvents = {
	userCreated: FinishBus,
	userDeleted: FinishBus,
	userUpdated: FinishBus,
}

export type ScheduleEvents = {
	scheduleCreated: FinishBus,
	scheduleDeleted: FinishBus,
	scheduleUpdated: FinishBus,
}

export type ProcessBus = {
	data?: any,
	id?: number
}

export type ProcessEvents = {
	updateUser: ProcessBus,
	registerUser: any,
	deleteUser: ProcessBus
}

export type ModalProcess = {
	open: boolean
}

export type UIEvents = {
	modal: ModalProcess,
}



export type DomainEvents = ProcessEvents & FinishEvents & UIEvents & ScheduleEvents;
export type GenericBus = FinishBus | ProcessBus;

export const EventBus = mitt<DomainEvents>();

export const emitt = (type: keyof DomainEvents, value: GenericBus | any) => {
	EventBus.emit(type, value);
}
