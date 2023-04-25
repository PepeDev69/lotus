/**
 * Polyfill for padstart
 *
 * @private
 * @param target {string}
 * @param length
 * @param pad
 * @return string
 */
const padStart = (target: string, length: number, pad: string) => {
	length = length >> 0;
	pad = String(pad || ' ');
	if (target.length > length) {
		return String(target);
	} else {
		length = length - target.length;
		if (length > pad.length) {
			pad += pad.repeat(length / pad.length);
		}
		return pad.slice(0, length) + String(target);
	}
};

const padTwoDigits = (num: number): string => {
	return padStart(num.toString(), 2, '0');
};

const isValidDate = (date: Date): boolean => {
	return date instanceof Date && !isNaN(Number(date));
};

export const dateFormat = (_date: string | Date): string => {
	if (!isValidDate(new Date(_date))) {
		console.warn('Invalid Date passed with parameter');
		return '';
	}
	const date: Date = new Date(_date);
	const currentDate: string = [
		date.getFullYear(),
		padTwoDigits(date.getMonth() + 1),
		padTwoDigits(date.getDate()),
	].join('-');

	const currentMinutes: string = [
		padTwoDigits(date.getHours()),
		padTwoDigits(date.getMinutes()),
		padTwoDigits(date.getSeconds()),
	].join(':');

	return `${currentDate} ${currentMinutes}`;
};

export const getCurrentMinutes = (_date?: string | Date): string => {
	const date: Date = new Date(_date || Date.now());
	return [padTwoDigits(date.getHours()), padTwoDigits(date.getMinutes()), padTwoDigits(date.getSeconds())].join(':');
};

export const getCurrentDay = (_date?: string | Date): string => {
	const final = typeof _date === 'string' && _date.split(' ')[0] ? `${_date} ${getCurrentMinutes()}` : _date;
	const date = new Date(final || Date.now());
	return [date.getFullYear(), padTwoDigits(date.getMonth() + 1), padTwoDigits(date.getDate())].join('-');
};

export const dateRange = (start: string, end: string) => {
	const date = [];
	let current = new Date(start);
	while (current <= new Date(end)) {
		date.push(dateFormat(current));
		current.setUTCHours(current.getUTCHours() + 1);
	}
	return date;
};

export const formatHours = (date: string) => {
	return new Date(date).toLocaleString([], {
		hour: '2-digit',
		minute: '2-digit',
	});
};

export const formatHoursAlt = (date: string) => {
	return new Date(date)
		.toLocaleString([], {
			hour: '2-digit',
			minute: '2-digit',
			hour12: true,
		})
		.toUpperCase();
};

export const getCurrentDayByDate = (_date: string) => {
	const minutes = getCurrentMinutes();
	const day = getCurrentDay(_date);
	return `${day} ${minutes}`;
};

export const genReturnDate = (date: string) => {
	return new Date(getCurrentDayByDate(date as string));
};

export const formatHumanDay = (date: Date | string) => {
	return new Date(getCurrentDayByDate(date as string)).toLocaleDateString('es-ES', {
		weekday: 'long',
		year: 'numeric',
		month: 'long',
		day: 'numeric',
	});
};

export const getTomorrow = (date?: string | Date) => {
	const tomorrow = date instanceof Date ? date : new Date();
	tomorrow.setDate(tomorrow.getDate() + 1);
	return tomorrow;
};

const dt = new Intl.DateTimeFormat('es', { day: '2-digit', year: 'numeric', month: 'numeric' })
	.formatToParts(new Date())
	.filter(el => el.value !== '/')
	.map(el => ({ [el.type]: el.value }))
	.reduce((acc, curr) => Object.assign({}, { ...curr, ...acc }), {});
