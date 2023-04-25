<script setup lang="ts">
import ViewIcon from './ViewIcon.vue';
defineProps({
	label: String,
	type: {
		type: String,
		default: 'text',
	},
	modelValue: [String, Number],
	error: String,
	placeholder: String,
	custom: Boolean,
	init: Boolean,
	icon: Object,
});
</script>

<template>
	<label :class="[css.field, init && css.init]">
		<div :class="css.labely" v-if="label">
			{{ label }}
		</div>
		<div :class="css.input">
			<!-- <ViewIcon v-if="icon" :class="css.input__icon" :icon="icon" /> -->
			<template v-if="!custom">
				<input
					:type="type"
					:class="css.input__tag"
					:placeholder="placeholder"
					:value="modelValue"
					@input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
					v-bind="$attrs"
				/>
			</template>
			<template v-else>
				<slot />
			</template>
		</div>
		<Transition name="error">
			<div v-if="error" :class="css.error">
				{{ error }}
			</div>
		</Transition>
	</label>
</template>

<style lang="scss" module="css">
.field {
	font: normal 500 calc(var(--ts-font-size) - 1px) / 1.5 var(--font);
	display: inline-flex;
	flex-direction: column;
	width: 100%;
	&:not(.init) {
		margin-bottom: 0.6em;
	}
}
.labely {
	padding: 0.5em 0;
	color: var(--ts-grey-400);
	font-family: inherit;
}
.input {
	display: inline-flex;
	align-items: center;
	column-gap: 0.4em;
	background-color: var(--ts-dark);
	&__tag {
		border-radius: 0.4rem;
		display: inline-block;
		border: none;
		line-height: 1;
		padding: 0.7em 1em;
		color: var(--ts-grey-400);
		background-color: var(--ts-dark);
		width: 100%;
		border-radius: 0.4rem;
		border-bottom: 1px solid transparent;
		transition: 300ms ease-in-out;
		transition-property: border;
		&:active,
		&:focus,
		&:not(:placeholder-shown) {
			border-bottom-color: var(--ts-cyan-light);
		}
	}
	&__icon {
		color: var(--ts-grey-400);
	}
}
.error {
	display: inline-block;
}
</style>
