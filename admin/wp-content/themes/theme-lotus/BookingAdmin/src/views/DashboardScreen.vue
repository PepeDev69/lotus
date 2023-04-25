<script setup>
import ScheduleComplete from '@/components/molecules/ScheduleComplete.vue';

</script>

<template>
	<div class="ds-layout">
		<ScheduleComplete 
			id="1"
			from="from"
			to="to"
			:customer="{
				name: 'hola',
			}"
			:doctor="{
				hola: 'muno'
			}"
			:service="{
				type: 'Object'
			}"
		/>
		<div class="ds-layout__settings">
			<h3>Configuacion</h3>
		</div>
	</div>
</template>

<style lang="scss">
.ds-layout {
	display: flex;
	justify-content: space-between;
	min-height: 100vh;
	&__settings {
		background-color: var(--ts-grey-900);
	}
}
</style>