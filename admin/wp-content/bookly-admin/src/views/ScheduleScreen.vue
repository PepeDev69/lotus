<script lang="ts" async setup>
import { reactive, ref, watchEffect } from "vue";
import ScheduleComplete from "@/components/organisms/ScheduleComplete.vue";
import ScheduleForm from "@/components/molecules/ScheduleForm.vue";
import ScheduleModal from "@/components/organisms/ScheduleModal.vue";
import { useOverlayStore } from "@/stores/overlay";
import { getCurrentDay } from "@/instance/date";
import { useScheduleStore } from "@/stores/schedule";
import { useUserStore } from "@/stores/users";

const overlay = useOverlayStore();
const scheduleStore = useScheduleStore();
const userStore = useUserStore();

const reactSchedule = reactive({
	from: "",
	to: "",
	doctor: null,
	service: null,
	customer: {
		id: null,
		name: "",
		phone: "",
		email: "",
		address: "",
		note: "",
		paid: null,
	},
}) as SendSchedule;
const schedule = ref<SendSchedule>(reactSchedule);
const day = ref(new Date());
const context = ref("create");

const handleCreate = () => {
	context.value = "create";
	schedule.value = reactSchedule;
	overlay.changeOpen();
};

const handleUpdate = ({ doctor }) => {
	context.value = "update";
	schedule.value = {
		id: doctor.id,
		from: doctor.from,
		to: doctor.to,
		customer: doctor.customer,
		doctor: doctor.doctor.id,
		service: doctor.service.id,
	};
	overlay.changeOpen();
};

watchEffect(async () => {
	await Promise.all([scheduleStore.fetchSchedule(getCurrentDay(day.value)), userStore.fetchUsers()]);
});

</script>

<template>
	<div class="cal-board">
		<section class="ts-cal__days">
			<h2 class="vts-title">Calendario</h2>
			<div class="vts-calendar">
				<VueDatePicker
					is-dark
					color="indigo"
					:rows="3"
					:step="3"
					title-position="left"
					v-model="day"
					:min-date="new Date()"
					:disabled-dates="{ weekdays: [1] }"
					locale="es"
					:is-required="true"
				/>
			</div>
		</section>
		<section class="ts-cal__view">
			<Suspense timeout="0">
				<ScheduleComplete @create="handleCreate" @update="handleUpdate" />
			</Suspense>
		</section>
		<ModuleOverlay>
			<ScheduleForm :values="schedule" :context="context" />
		</ModuleOverlay>
		<ScheduleModal />
	</div>
</template>

<style lang="scss">
.cal-board {
	display: flex;
	min-height: 100vh;
}

.ts-cal {
	&__days {
		background-color: var(--ts-grey-900);
		border-right: 1px solid var(--ts-grey-800);
		.vts-title {
			font: normal 500 1.8rem /1 var(--font);
			padding: 0.9em 1em;
			border-bottom: 1px solid var(--ts-grey-800);
			color: var(--ts-cyan-light);
		}
		.vts-calendar {
			padding: 0 0.8rem;
		}
	}
	&__view {
		padding: 3.2rem;
		width: 100%;
		position: relative;
	}
}

.date-crd {
	&:not(:last-child) {
		padding-bottom: 1.6rem;
	}
}

.tf-date {
	font: normal 600 1.3rem/1.5 var(--font);
	padding: 0.5em 0;
	color: var(--ts-grey-500);
}

.dt-li {
	padding-bottom: 10px;
}

.vts-calendar .vc-container {
	border: none;
	background-color: transparent !important;
	border-radius: 0;
	font-family: var(--font) !important;
	--font-bold: 600;
	--font-semibold: 500;
	.vc-pane {
		border-bottom: 1px solid var(--ts-grey-700);
	}
	.vc-header .vc-title {
		text-transform: capitalize;
	}
}
</style>
