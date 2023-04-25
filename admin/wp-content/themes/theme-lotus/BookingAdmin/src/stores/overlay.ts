import { defineStore } from "pinia";
import { ref } from "vue";

export const useOverlayStore = defineStore("overlay", () => {
	const isOpen = ref(false);
	const changeClose = () => {
		isOpen.value = false;
	};
	const changeOpen = () => {
		isOpen.value = true;
	}
	return {
		isOpen,
		changeClose,
		changeOpen
	};
});
