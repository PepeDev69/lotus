export const isEmpty = (obj: object | any) => Object.entries(obj).length === 0;

export const makeEmpty = (target: any, omit?: string) => {
	for (let key in target) {
		if (typeof target[key] === "object") {
			makeEmpty(target[key], omit);
		}
		if (target[omit]) {
			continue;
		} else target[key] = "";
	}
	return target;
};
