import { mainService } from "@service/common.service";
import { defineStore } from "pinia";
import { readonly, ref } from "vue";

export const useMainStore = defineStore("main", () => {
	const services = ref<any>([]);
	const config = ref({
		date_range: []
	});

	// Update schedule
	const fetchConfig = async () => {
		try {
			const fetchedConfig = await mainService.findConfig();
			config.value = fetchedConfig;
		} catch (error) {
			console.log(error);
		}
	};

	const fetchServices = async () => {
		try {
			const fetchedServices = await mainService.findServices();
			services.value = (fetchedServices as AbstractService[]).map((service) => ({
				value: service.id,
				label: service.name,
				disabled: false,
			}));
		} catch (error) {
			console.log(error);
		}
	};

	const mainFetch = async () => {
		const [fServices, fConfig] = await Promise.all([mainService.findServices(), mainService.findConfig()]);
		services.value = (fServices as AbstractService[]).map((service) => ({
			value: service.id,
			label: service.name,
		}));
		config.value = fConfig;
	};

	return {
		services,
		config,
		mainFetch,
		fetchConfig,
		fetchServices,
	};
});
