<script lang="ts" setup>
defineProps({
	id: String,
	from: String,
	to: String,
	customer: {
		type: Object,
	},
	doctor: {
		type: Object,
	},
	service: {
		type: Object
	}
})

</script>

<template>
	<article :class="css.card">
		<h4>{{ customer.name }}</h4>
	</article>	
</template>

<style lang="scss" module="css">
.card {
	display: flex;
}
</style>