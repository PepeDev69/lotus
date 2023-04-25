export const setupFormData = (object = {}) => {
	const data = new FormData();
	for (let key in object) {
		data.set(String(key), String(object[key]));
	}
	return data;
};

export const TYPE_FIELD = {
	zipcode: /^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/,
	any: /[A-za-z0–9_]/,
	phone: /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3,4})$/,
	phone_alt: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im,
	email: /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/,
};

export const FORM_HEADER = {
	headers: {
		'Content-Type': 'multipart/form-data',
	},
};

export const sanitize = string => {
	return String(string)
		.trim()
		.toLowerCase()
		.replace(/ /g, '-')
		.replace(/[^\w-]+/g, '');
};

export const uuid = () => {
	const randomNumbers = limit => {
		const value = limit * Math.random();
		return value | 0;
	};
	const genAxis = () => {
		const value = randomNumbers(16);
		return value.toString(16);
	};
	const generate = count => {
		let result = '';
		for (let i = 0; i < count; i++) {
			result += genAxis();
		}
		return result;
	};
	const genVariant = () => {
		const value = randomNumbers(16);
		const variant = (value & 0x3) | 0x8;
		return variant.toString(16);
	};
	const variant = genVariant() + generate(3);
	return `${generate(8)}-${generate(4)}-4${generate(3)}-${variant}-${generate(12)}`;
};

export const unique = () => {
	return Date.now().toString(16) + '--' + ((16 * Math.random()) | 0).toString(16);
};

const makeDate = (date = '') => {
	return date
		.replace(/(-|:|\s)/g, ',')
		.split(',')
		.map(i => parseInt(i));
};

export const getTomorrow = (date = '') => {
	const tomorrow = date instanceof Date ? date : new Date();
	tomorrow.setDate(tomorrow.getDate() + 1);
	return new Date(tomorrow);
};

export const dateFormatTomorrow = () => {
	const currentDay = getTomorrow();
	if (currentDay.getDay() === 0) {
		return getTomorrow(new Date(currentDay)).toISOString().split('T')[0];
	}
	return currentDay.toISOString().split('T')[0];
};

export const formatDateString = (locale, date, key) => {
	const time = new Intl.DateTimeFormat(locale, {
		day: '2-digit',
		month: 'short',
	}).formatToParts(new Date(...makeDate(date)));
	const res = time.find(tim => tim.type == key);
	return res.value;
};

/**
 *
 * @param { (...params) => void } func
 * @param { number } wait
 * @returns { void }
 */
export function throttle(func, wait) {
	let waiting = false;
	return function () {
		if (waiting) return;

		waiting = true;
		setTimeout(() => {
			func.apply(this, arguments);
			waiting = false;
		}, wait);
	};
}
