export const setupFormData = (data: Record<any, any>): FormData => {
	const values = new FormData();
	for (const key in data) {
		values.append(String(key), data[key])
	}
	return values;
}