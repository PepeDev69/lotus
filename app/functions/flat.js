/**
 *
 * @param { object } data
 * @returns { any[] }
 */
export const flat = (data) => {
	return typeof Array.prototype.flat !== "function"
		? Object.values(data).reduce((acc, el) => acc.concat(el))
		: Object.values(data).flat();
};

export const flatMap = (data, fn) => {
	return flat(data).map((el, index, target) => fn(el, index, target));
};
