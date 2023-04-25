<script setup lang="ts">
defineProps({
	modelValue: String,
});
</script>

<template>
	<div class="gender-selector-w">
		<span class="labelly">Genero</span>
		<div class="gender-selector t-round">
			<input
				type="radio"
				name="gender"
				id="F"
				value="Femenino"
				:checked="modelValue == 'Femenino'"
				hidden
				class="gender-type"
				@input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
			/>
			<label class="gender-label t-round" for="F">Femenino</label>
			<input
				type="radio"
				name="gender"
				id="M"
				value="Masculino"
				hidden
				:checked="modelValue == 'Masculino'"
				class="gender-type"
				@input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
			/>
			<label class="gender-label t-round" for="M">Maculino</label>
		</div>
	</div>
</template>

<style lang="scss">
.gender-selector-w {
	font: normal 500 var(--ts-font-size) /1 var(--font);
	display: inline-flex;
	flex-direction: column;
	.labelly {
		padding: 0.5em 0;
		color: var(--ts-grey-400);
		font-family: inherit;
	}
}
.gender-selector {
	display: inline-flex;
	padding: 0.4em;
	gap: 0.8em;
	background-color: var(--ts-dark);
}

.gender-label {
	padding: 0.6em 0.9em;
	background-color: var(--ts-grey-700);
	cursor: pointer;
	color: var(--ts-grey-400);
}
.gender-type:checked + .gender-label {
	background-color: var(--ts-cyan);
	box-shadow: 0 1px 3px 0 rgb(0 0 0 / 10%), 0 1px 2px 0 rgb(0 0 0 / 6%);
}
</style>
