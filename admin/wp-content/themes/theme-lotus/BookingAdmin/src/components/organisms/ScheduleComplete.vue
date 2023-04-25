<script lang="ts" async setup>
import ScheduleCard from '@component/molecules/ScheduleCard.vue';
import Loader from '@component/utils/loading.vue';
import FancyButton from '@component/atoms/FancyButton.vue';
import { formatHumanDay, formatHoursAlt } from '@instance/date';
import { useScheduleStore } from '@/stores/schedule';
import { computed } from 'vue';
import { cloneDeep as cloneObject } from 'lodash';

const emit = defineEmits(['create', 'update']);

const schedule = useScheduleStore();

const searchSchedule = async (id: number) => {
	await schedule.findOneSchedule(id);
};

const formatAppointemt = computed(() => (count: number) => {
	return count === 0 ? 'No tienes citas' : `Tienes ${count} cita(s)`;
});
</script>

<template>
	<Transition name="slide-top" mode="out-in">
		<div v-if="!schedule.fetching" :class="{ loading: schedule.fetching }">
			<div class="tit-title">
				<div>
					<h3 class="tit">{{ formatHumanDay(schedule.date) }}</h3>
					<h4>{{ formatAppointemt(schedule.today.count as number) }}</h4>
				</div>
				<div>
					<FancyButton text="Crear cita" @click="emit('create', { date: schedule.date })" />
				</div>
			</div>
			<ul class="schedule-list">
				<li v-for="(date, key, i) in schedule.today.schedules" :key="i" class="dt-li">
					<h5 class="tf-date">
						{{ formatHoursAlt(`${schedule.today.date} ${key}`) }}
					</h5>
					<template v-if="date.length > 0">
						<TransitionGroup class="found-date user-crd-ts" name="user-crd" tag="div">
							<div v-for="doc in date" :key="doc.id" class="date-crd user-crd-it">
								<ScheduleCard
									:id="Number(doc.id)"
									:customer="doc.customer.name"
									:service="doc.service.name"
									:doctor="doc.doctor.name"
									:mutate="schedule.mutateId"
									@view="searchSchedule(doc.id as number)"
									@delete="schedule.deleteSchedule(doc.id as number)"
									@update="emit('update', { doctor: cloneObject(doc) })"
								/>
							</div>
						</TransitionGroup>
					</template>
					<template v-else>
						<div class="t-round t-abs-center new-schedule" />
					</template>
				</li>
			</ul>
		</div>
	</Transition>
	<Loader :loading="schedule.fetching" />
</template>

<style lang="scss">
.tit-title {
	border-bottom: 2px solid var(--ts-cyan-light);
	padding-bottom: 1.5rem;
	color: var(--ts-grey-600);
	display: flex;
	align-items: center;
	justify-content: space-between;
	h4 {
		font-weight: 500;
	}
}
.schedule-list {
	padding: 1em 0;
}

.tit {
	color: var(--ts-grey-400);
	margin-bottom: 0.25em;
	&::first-letter {
		text-transform: uppercase;
	}
}

.new-schedule {
	border-top: 4px solid var(--ts-grey-dark);
}
</style>
