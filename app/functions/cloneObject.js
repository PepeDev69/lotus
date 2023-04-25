export const cloneObject = (target) => {
	if (target === null || typeof target !== "object") {
		return target;
	}
	if (target instanceof Date) {
		return new Date(target.getTime());
	}
	if (Array.isArray(target)) {
		let clonedArray = [];
		target.forEach((el) => clonedArray.push(cloneObject(el)));
		return clonedArray;
	}
	let clonedObjet = new target.constructor();
	for (let prop in target) {
		if (target.hasOwnProperty(prop)) {
			cloneObject[prop] = cloneObject(target[prop]);
		}
	}
	return clonedObjet;
};
