<template>
	<label v-if="!group" :class="css.wrap" :data-error="error ? true : false">
		<span :class="css.label" v-if="label">{{ label }}</span>
		<span :class="css.input">
			<input @input="$emit('input', $event.target.value)" :type="type" :placeholder="placeholder" />
		</span>
		<Transition name="scale-in" mode="out-in">
			<span :class="css.error" v-if="error">
				{{ error }}
			</span>
		</Transition>
	</label>
	<fieldset v-else :class="[css.wrap, css.group]">
		<legend :class="css.label" v-if="label">{{ label }}</legend>
		<slot />
	</fieldset>
</template>

<script>
export default {
	name: "TextField",
	props: {
		label: String,
		placeholder: String,
		type: String,
		error: String,
		value: String,
		group: Boolean,
	},
	computed: {
		computeModel: {
			set(newValue) {
				this.$emit("input", newValue);
			},
			get() {
				return this.value;
			},
		},
	},
};
</script>

<style lang="postcss" module="css">
.wrap {
	font: normal 400 calc(var(--p-font-size) - 1px) / 1 var(--font-rubik);
	@apply inline-flex flex-col w-full mt-[1em];
	&.group {
		label:first-of-type {
			@apply mt-0;
		}
	}
}
.label {
	@apply text-slate-800 py-[0.5em];
}
.input {
	@apply text-slate-700 text-[0.92em] leading-none;
	input {
		@apply p-[0.8em] bg-white rounded-lg w-full inline-block
            leading-none border-[1px] border-solid border-slate-300 transition-colors duration-300;
		&:focus,
		&:active {
			@apply border-slate-300;
		}
		&::placeholder {
			@apply text-slate-500;
		}
	}
	[data-error] & input {
		@apply border-rose-500;
	}
}
.error {
	@apply text-rose-500 text-[0.9em] leading-relaxed font-normal inline-block;
}
</style>

<style lang="postcss">
.scale-in-enter,
.scale-in-leave-to {
	transform: translate3d(-2rem, 0, 0);
	opacity: 0;
	height: 0;
}
.scale-in-enter-active,
.scale-in-leave-active {
	transition: all 500ms;
}
</style>
