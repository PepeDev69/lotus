<template>
	<div class="drop-m" v-click-outside="closeDropdown">
		<div class="drop-m__head" @click="toggleDrodown">
			<span>{{ currentSelect || label }}</span>
			<svg width="11" height="6" fill="none" viewBox="0 0 11 6">
				<path stroke="#606060" stroke-linecap="round" d="m1 1 4.5 4L10 1" />
			</svg>
		</div>
		<Transition name="dropdown">
			<div v-if="isOpen" class="drop-ls">
				<template v-for="(gender, idx) in gender.genders">
					<span class="drop-ls__item" @click="openOther" :key="idx">
						<span>{{ gender }}</span>
					</span>
				</template>
				<span class="drop-ls__item" @click="openOther($event, 'other')">
					<span>{{ gender.other }}</span>
				</span>
				<Transition name="show-input">
					<label v-show="isOther" class="drop-ls__item-custom">
						<input
							type="text"
							name="gender-text"
							ref="input"
							@input="setValueOfOther"
							:placeholder="polylang.other_gender_placeholder"
						/>
						<svg fill="none" viewBox="0 0 24 24" class="d-icon" @click="closeDropdown">
							<path d="M4 10.571 10.222 18 20 6" />
						</svg>
					</label>
				</Transition>
			</div>
		</Transition>
	</div>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'SimpleDropdown',
	props: {
		label: {
			type: String,
			default: 'Genero',
		},
	},
	computed: {
		...mapState(['polylang']),
		gender() {
			const genders = this.polylang.gender_options.split('|');
			return {
				genders,
				other: genders.pop()
			}
		},
	},
	methods: {
		toggleDrodown() {
			this.isOpen = !this.isOpen;
		},
		openDrodown() {
			this.isOpen = true;
		},
		closeDropdown() {
			this.isOpen = false;
		},
		openOther(event, type) {
			if (type === 'other' && this.isOther === false) {
				this.isOther = true;
				this.$refs.input.focus();
			} else {
				this.isOther = false;
				this.currentSelect = String(event.target.textContent).trim();
				this.$emit('send', this.currentSelect);
				this.isOpen = false;
			}
		},
		setValueOfOther(event) {
			this.currentSelect = String(event.target.value).trim();
			this.$emit('send', this.currentSelect);
		},
	},
	data: () => ({
		isOpen: false,
		isOther: false,
		currentSelect: null,
	}),
};
</script>

<style lang="postcss">
.drop-m {
	font: normal 400 1.5rem /1 'Roboto';
	margin-bottom: 1.6em;
	position: relative;
	&__head {
		display: flex;
		align-items: center;
		justify-content: space-between;
		border-radius: 0.5rem;
		border: 1px solid rgb(158, 158, 158);
		padding: 0.8em 1.2em;
		color: rgb(158, 158, 158);
	}
	@media screen(design) {
		font-size: calc(var(--p-font-size) - 2px);
	}
}
.drop-ls {
	display: flex;
	flex-direction: column;
	position: absolute;
	top: 120%;
	left: 0;
	right: 0;
	background-color: #f4f4f4;
	z-index: 1;
	box-shadow: 0px 0px 6px 0px rgb(18 18 18 / 40%);
	border-radius: 0.5rem;
	&__item {
		padding: 0.5em 1em;
		&:hover {
			background-color: var(--gray-1000);
		}
		&-custom {
			display: inline-flex;
			width: 100%;
			position: relative;
			color: var(--white);
			padding: 0 1rem;
			input {
				width: 100%;
				padding: 0.5em 1em;
				background-color: var(--olive);
			}
			input::placeholder {
				color: var(--gray-800);
				font-weight: 300;
			}
		}
		&-custom .d-icon {
			position: absolute;
			top: 0;
			bottom: 0;
			right: 1rem;
			background-color: var(--primary);
			height: 100%;
			padding: 0.25em 0.5em;
		}
		&-custom path {
			stroke: var(--gray-800);
			stroke-linecap: round;
			stroke-linejoin: round;
			stroke-width: 2;
		}
	}
}
.drop-ls {
	padding: 1rem 0;
}
.drop-ls,
.drop-ls__item-custom {
	transform-origin: top;
	transition: 500ms ease-in-out;
	transition-property: opacity, transform;
	overflow: hidden;
}

.dropdown-enter,
.dropdown-leave-to {
	transform: translateY(2rem);
	opacity: 0;
}

.show-input-enter,
.show-input-leave-to {
	opacity: 0;
}
</style>
