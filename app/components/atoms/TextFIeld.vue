<template>
	<label v-if="custom" :class="['textField', classModule, valid]">
		<span class="inline-full">
			<slot />
		</span>
		<span v-if="errorComputed" class="v-error inline-full" aria-live="polite">{{ error }} </span>
	</label>
	<label v-else :class="['textField', classModule]">
		<span class="inline-full">
			<input :name="name" :type="type" :placeholder="placeholder" @input="$emit('send', $event.target.value)" class="input-gral" />
		</span>
		<span v-if="errorComputed" class="v-error inline-full" aria-live="polite">{{ error }} </span>
	</label>
</template>

<script>
export default {
	props: {
		placeholder: {
			type: String,
			default: '',
		},
		type: {
			type: String,
			default: '',
		},
		error: {
			type: String,
			default: '',
		},
		variant: String,
		custom: Boolean,
		name: String,
	},
	computed: {
		modelComputed: {
			get() {
				return this.value;
			},
			set(newValue) {
				this.$emit('input', newValue);
			},
		},
		classModule() {
			return this[this.variant];
		},
		valid() {
			return this.error.includes('true') ? 'valid' : '';
		},
		errorComputed() {
			return !this.error.includes('true') || !this.error === '';
		},
	},
};
</script>

<style lang="postcss">
.inline-full,
.input-gral {
	@apply w-full block;
}
.textField {
	@apply relative;
}
</style>
