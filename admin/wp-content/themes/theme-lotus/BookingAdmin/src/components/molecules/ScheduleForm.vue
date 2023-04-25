<script lang="ts" setup>
import { onMounted, ref, watchEffect } from "vue";
// @ts-ignore
import Multiselect from "@vueform/multiselect";
import BaseButton from "../atoms/BaseButton.vue";
import Title from "@component/atoms/Title.vue";
import { doctorService } from "@service/doctor.service";
import { getTomorrow } from "@/instance/date";
import { useMainStore } from "@/stores/main";
import { useOverlayStore } from "@/stores/overlay";
import { useScheduleStore } from "@/stores/schedule";
import { useUserStore } from "@/stores/users";

interface Customer {
	id?: number;
	name: string;
	phone: string;
	email: string;
	address?: string;
	note?: string;
	paid?: number;
}
interface SendSchedule {
	id?: number;
	from: string;
	to: string;
	doctor: number;
	service: number;
	customer: Customer;
}
interface Props {
	values: SendSchedule;
	context?: string;
}

const props = defineProps<Props>();

const main = useMainStore();
const overlay = useOverlayStore();
const scheduleStore = useScheduleStore();
const userStore = useUserStore();

const schedule = ref<SendSchedule>(props.values);
const specialist = ref<Specialist>({
	loading: false,
	values: [],
});
const selectDOM = ref();
const date = ref(scheduleStore.date);
const hour = ref({
	value: "",
	options: main.config.date_range,
});

const labels = ref<Record<any, Record<any, string>>>({
	create: {
		message: "Agregar una nueva cita",
		button: "AGREGAR",
	},
	update: {
		message: "Actualizar informacion",
		button: "ACTUALIZAR",
	},
});

const isEmpty = ref(false);

onMounted(() => {
	if (props.values.from) {
		const [_, minute] = props.values.from.split(" ");
		const data = hour.value.options.find((time) => {
			const [start, _] = time.value.split("|");
			return start === minute;
		});
		hour.value.value = data.value;
	}
	specialist.value.values = userStore.users.map<AbstractSelect>((user) => {
		return { label: user.fullname, value: user.id };
	});
});

const updateTime = (option: string) => {
	const [start, end] = option.split("|");
	schedule.value.from = `${date.value} ${start}`;
	schedule.value.to = `${date.value} ${end}`;
	selectDOM.value.clear();
	specialist.value.loading = true;
	isEmpty.value = false;
	doctorService.searchAvailable(schedule.value.from).then((data) => {
		if (data !== false) {
			specialist.value.values = (data as Doctor[]).map<AbstractSelect>((user) => {
				return { label: user.fullname, value: user.id };
			});
		} else {
			isEmpty.value = true;
		}
		specialist.value.loading = false;
	});
};

const handleFormSchedule = async (event: Event) => {
	if (props.context === "create") {
		const created = await scheduleStore.createSchedule(schedule.value);
		if (created === "success") {
			overlay.changeClose();
		}
	}
	if (props.context === "update") {
		const updated = await scheduleStore.updateSchedule(schedule.value.id, schedule.value);
		if (updated === "success") {
			overlay.changeClose();
		}
	}
};
</script>

<template>
	<div class="form-schedule">
		<form :class="css.form" class="t-box" @submit.prevent="handleFormSchedule">
			<Title :text="labels[context].message" />
			<fieldset class="form-block">
				<legend class="form-block__title">Datos del cliente</legend>
				<div class="group-field">
					<TextField placeholder="Nombres *" type="text" v-model="schedule.customer.name" />
					<TextField placeholder="Telefono *" type="tel" v-model="schedule.customer.phone" />
				</div>
				<div class="group-field">
					<TextField placeholder="Correo electronico *" type="email" v-model="schedule.customer.email" />
					<TextField placeholder="Direccion (opcional)" type="text" v-model="schedule.customer.address" />
				</div>
				<TextField custom>
					<textarea
						placeholder="Nota adicional..."
						class="tx-textarea t-round"
						v-model="schedule.customer.note"
					/>
				</TextField>
			</fieldset>

			<fieldset class="form-block">
				<legend class="form-block__title">Datos del servicio</legend>
				<div class="group-field exact extra">
					<VueDatePicker
						v-model="date"
						:model-config="{
							type: 'string',
							mask: 'YYYY-MM-DD',
						}"
						:masks="{ input: 'YYYY-MM-DD' }"
						:input-debounce="500"
						:min-date="context == 'update' ? new Date() : getTomorrow()"
						:disabled-dates="{ weekdays: [1] }"
						is-dark
						is-required
					>
						<template v-slot="{ inputValue, inputEvents }">
							<input
								:value="inputValue"
								placeholder="Seleccione una fecha"
								v-on="inputEvents"
								class="tx-input"
							/>
						</template>
					</VueDatePicker>
					<Multiselect
						placeholder="--:--  --:--"
						v-model="hour.value"
						@select="updateTime"
						:options="hour.options"
						:searchable="true"
					/>
					<TextField placeholder="Monto pagado" type="number" v-model="schedule.customer.paid" init />
				</div>
				<div class="group-field">
					<Multiselect
						placeholder="Seleccione un especialista"
						v-model="schedule.doctor"
						:options="specialist.values"
						:loading="specialist.loading"
						:disabled="specialist.loading"
						:searchable="true"
						ref="selectDOM"
						noOptionsText="No hay especialistas disponibles"
						:class="{ empty: isEmpty, loading: specialist.loading }"
					/>
					<Multiselect
						placeholder="Selecione un servicio"
						v-model="schedule.service"
						:options="main.services"
						:searchable="true"
					/>
				</div>
			</fieldset>
			<div class="form-actions">
				<BaseButton text="CANCELAR" @click.native="overlay.changeClose" />
				<BaseButton type="submit" :text="labels[context].button" :loading="scheduleStore.loading" />
			</div>
		</form>
	</div>
</template>

<style lang="scss" module="css">
.form {
	font-style: normal;
}
</style>

<style lang="scss">
.form-schedule {
	min-width: 52vw;
}

.group-field {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	column-gap: 1em;
	margin-bottom: 0.6em;
	&.exact {
		grid-template-columns: 0.9fr 1.2fr 1.4fr;
	}
	&.extra {
		margin-bottom: 1em;
	}
}
.form-block {
	margin-bottom: 0.5em;
	&__title {
		font: normal 500 1.8rem / 1.2 var(--font);
		padding: 0.1em 0 0.7em;
		color: var(--ts-cyan-light);
	}
}

.form-actions {
	display: flex;
	gap: 2rem;
	margin-top: 3rem;
}
</style>
