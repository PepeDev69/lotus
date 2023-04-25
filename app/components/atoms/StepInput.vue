<template>
	<label :class="[css.input, css[variant]]">
		<input ref="input" type="number" v-model="updateCount" min="1" />
		<div :class="css.buttons_step">
			<button :class="css.btn" @click="updateNumberCount('up')">
				<svg viewBox="0 0 14 14" fill="none">
					<path
						d="M6.80005 2.20001V12.6"
						stroke="#395D64"
						stroke-width="2.5"
						stroke-linecap="round"
					/>
					<path
						d="M12 7.39999L1.6 7.39999"
						stroke="#395D64"
						stroke-width="2.5"
						stroke-linecap="round"
					/>
				</svg>
			</button>
			<button :class="css.btn" @click="updateNumberCount('down')">
				<svg viewBox="0 0 14 3" fill="none">
					<path
						d="M12 1.34283L2 1.34283"
						stroke="#395D64"
						stroke-width="2.5"
						stroke-linecap="round"
					/>
				</svg>
			</button>
		</div>
	</label>
</template>

<script>
export default {
	name: "InputNumber",
	props: {
		value: [String, Number],
		variant: {
			type: String,
			default: "normal",
		},
	},
	computed: {
		updateCount: {
			get() {
				return this.value;
			},
			set(value) {
				this.$emit("input", value);
			},
		},
	},
	methods: {
		updateNumberCount(action) {
			if (action == "up") {
				this.$refs.input.stepUp();
			}
			if (action == "down") {
				this.$refs.input.stepDown();
			}
			this.$emit("input", this.$refs.input.value);
		},
	},
};
</script>

<style lang="postcss" module="css">
.input {
	font: normal 400 calc(var(--p-font-size) + 1px) / 1 "Roboto";
	border: none;
	@apply inline-flex items-center;
	input {
		@apply w-[3.5ch] h-[3.5ch] text-center text-[1em] bg-white;
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
		border-radius: 50%;

	}
}
.btn {
	@apply p-[0.2em];
	svg {
		width: 0.75em;
		height: 0.75em;
	}
}
.buttons_step {
	display: inline-flex;
	flex-direction: column;
	align-items: center;
	padding-left: 0.5rem;
}
</style>
