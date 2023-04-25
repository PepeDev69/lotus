<script lang="ts" setup>
import DoctorCard from '@component/molecules/DoctorCard.vue';
import Loading from '@component/utils/loading.vue';
import { useUserStore } from '@/stores/users';
import { cloneDeep as cloneObject } from 'lodash';

defineEmits(['update', 'register']);
const user = useUserStore();
const fetchSchedule = async (id: number) => {
	await user.fetchScheduleByUser(Number(id));
};
</script>

<template>
	<Transition name="slide-top" mode="out-in">
		<div class="doctor-group" v-if="!user.fetching">
			<TransitionGroup tag="ul" name="user-crd" :class="css.grid">
				<template v-if="user.filteredUsers.length > 0">
					<li v-for="doctor in user.filteredUsers" :key="doctor.id" class="user-crd-it">
						<DoctorCard
							:id="Number(doctor.id)"
							:name="doctor.fullname"
							:type="doctor.position"
							:email="doctor.email"
							:avatar="(doctor.avatar as string)"
							:mutate="(user.mutateId as number)"
							@view="fetchSchedule(doctor.id)"
							@update="$emit('update', { id: doctor.id, doctor: cloneObject(doctor) })"
							@delete="user.deleteUser(Number(doctor.id))"
						/>
					</li>
				</template>
				<template v-else>
					<h1>Empty</h1>
				</template>
			</TransitionGroup>
		</div>
	</Transition>
	<Loading :loading="user.fetching" top />
</template>

<style lang="scss" module="css">
.grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 3rem;
	@media screen and (min-width: 1700px) {
		grid-template-columns: repeat(4, 1fr);
	}
}
.new_icon {
	background-color: var(--ts-grey-900);
	border: 2px dashed var(--ts-orange);
	cursor: pointer;
	svg {
		width: 3.5rem;
		height: 3.5rem;
	}
}
</style>

<style lang="scss">
.a-card-last {
	min-height: 8ch;
	font: normal 500 1.4rem/1 var(--font);
	color: var(--ts-grey-600);
	svg {
		padding-right: 0.4em;
	}
}
</style>
