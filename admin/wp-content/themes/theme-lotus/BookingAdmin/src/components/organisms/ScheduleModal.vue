<script lang="ts" setup>
import { useScheduleStore } from '@/stores/schedule';
import { storeToRefs } from 'pinia';
const scheduleStore = useScheduleStore();
const { schedule, openSide } = storeToRefs(scheduleStore);
</script>

<template>
	<Transition :duration="{ enter: 500, leave: 700 }" name="dialog" appear>
		<div v-if="openSide" :class="css.overlay" class="inset">
			<div class="inner modally" role="dialog" :class="css.dialog" v-click-outside="scheduleStore.closeSideCard">
				<h2>{{ schedule.doctor.name }}</h2>
			</div>
		</div>
	</Transition>
</template>

<style lang="scss" module="css">
.overlay, .dialog {
	transition: 400ms ease-in-out;
	transition-property: opacity, transform;
}
.overlay {
	position: fixed;
	background-color: #11141740;
	cursor: pointer;
	z-index: 2;
}
.dialog {
	position: fixed;
	right: 0;
	top: 0;
	bottom: 0;
	background-color: var(--ts-dark-soft);
}
</style>

<style>
.dialog-leave-active {
	transition-delay: 300ms;
}

.dialog-enter-from,
.dialog-leave-to {
	opacity: 0;
}

.dialog-enter-active .inner {
	transition-delay: 300ms;
}

.dialog-enter-from .inner,
.dialog-leave-to .inner {
	transform: translateX(2.5rem);
	opacity: 0.001;
}

</style>
