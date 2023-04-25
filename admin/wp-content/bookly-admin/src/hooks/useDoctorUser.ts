import { doctorService } from "@service/doctor.service";
import { onBeforeUnmount, onMounted, ref } from "vue";
import { EventBus } from "@/providers/event-bus";

export const useDoctorUser = () => {
	const userStore = ref<UserStore>({
		loading: true,
		doctors: [],
	});

	async function fillInitialUserStore() {
		userStore.value.loading = true;
		doctorService.findAll().then((data: Doctor[]) => {
			userStore.value = {
				loading: false,
				doctors: data,
			};
		});
	}

	onMounted(fillInitialUserStore);

	// Delete user and filter
	EventBus.on("deleteUser", async (deleted) => {
		doctorService
			.delete(deleted.id)
			.then((isOk) => {
				if (isOk === false) {
					return alert("Try again");
				}
				return (userStore.value.doctors = userStore.value.doctors.filter((user) => {
					return user.id !== deleted.id;
				}));
			})
			.catch((error) => {
				return alert("Error Found in Server: " + JSON.stringify(error));
			});
	});

	EventBus.on("registerUser", (data) => {});

	EventBus.on("userCreated", async (data) => {
		if (data.status === true) {
			await fillInitialUserStore();
		}
	});

	const updateUser = (data: Doctor) => {
		doctorService.create(data).then((res) => {
			if (res === true) {
				userStore.value = {
					loading: true,
					doctors: userStore.value.doctors.concat(data),
				};
			}
			return alert("Try again");
		});
	};

	onBeforeUnmount(() => {
		EventBus.off("deleteUser");
		EventBus.off("registerUser");
		EventBus.off("updateUser");
	});

	return {
		userStore,
	};
};
