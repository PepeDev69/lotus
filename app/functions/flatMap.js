import { flat } from "~/functions/flat";

export const flatMap = (data, fn) => {
	return flat(data).map((el, index, target) => fn(el, index, target));
};
