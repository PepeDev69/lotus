<script lang="ts" setup>
import { IconTime, IconCalendar } from '@component/icons';
import { computed, onBeforeMount, onBeforeUnmount, ref } from 'vue';

const timer = ref(null);
const date = ref(new Date());
const time = computed(() => {
	const status = date.value.getHours() > 12 ? 'PM' : 'AM';
	let hour = date.value.getHours();
	let minute = date.value.getMinutes();
	let second = date.value.getSeconds();
	let current = new Intl.DateTimeFormat('es', { day: '2-digit', year: 'numeric', month: 'long' }).format(date.value);
	if (hour === 0) {
		hour = 12;
	}
	if (hour > 12) {
		hour = hour - 12;
	}
	return {
		hours: hour < 10 ? '0' + hour : hour,
		minutes: minute < 10 ? '0' + minute : minute,
		seconds: second < 10 ? '0' + second : second,
		status,
		current,
	};
});

const updateTimer = () => {
	date.value = new Date();
};

onBeforeMount(() => {
	timer.value = setInterval(updateTimer, 1000);
});
onBeforeUnmount(() => {
	clearInterval(timer.value);
});
</script>

<template>
	<div class="top-banner">
		<div></div>
		<div class="ban-item ban-calendar">
			<IconCalendar></IconCalendar>
			<h4>{{ time.current }}</h4>
		</div>
		<div class="ban-item ban-timer">
			<IconTime></IconTime>
			<h4>{{ time.hours }}: {{ time.minutes }}: {{ time.seconds }} {{ time.status }}</h4>
		</div>
	</div>
</template>

<style lang="scss">
.top-banner {
	border-bottom: 1px solid var(--ts-grey-800);
	padding: 1.4rem 4rem;
	display: flex;
	width: 100%;
	align-items: center;
	justify-content: flex-end;
	background-color: var(--ts-grey-900);
}
.ban-item {
	display: inline-flex;
	align-items: center;
	color: var(--ts-grey-500);
	padding: 0 1.4rem;
	gap: 0.75rem;
	h4 {
		font-weight: 500;
	}
}
</style>
