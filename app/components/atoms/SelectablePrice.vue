<template>
	<div class="@selectable">
		<label class="@selectable-it">
			<input class="@selectable-input" type="radio" :value="valueFirst" v-model="modelComputed" hidden :checked="checkedValue" />
			<span class="@selectable-icon"></span>
			<span>{{ polylang.title_book_appointment }}</span>
			<span>{{ siteMeta.reservation_price | currency }}</span>
		</label>
		<label class="@selectable-it">
			<input class="@selectable-input" type="radio" :value="secondPrice" v-model="modelComputed" hidden />
			<span class="@selectable-icon"></span>
			<span>{{ polylang.title_full_payment }}</span>
			<span>{{ secondPrice | currency }}</span>
		</label>
	</div>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'SelectablePrice',
	props: {
		firstPrice: Number,
		secondPrice: Number,
		value: [Number, String],
	},
	computed: {
		...mapState(['polylang', 'common', 'siteMeta']),
		modelComputed: {
			get() {
				return this.value ? this.value : this.reservedValue;
			},
			set(value) {
				this.$emit('input', value);
			},
		},
		checkedValue() {
			return this.value === 0 ? true : false;
		},
		valueFirst() {
			return this.firstPrice ? this.firstPrice : this.reservedValue;
		},
	},
	data() {
		return {
			reservedValue: 50,
		};
	},
};
</script>

<style lang="postcss">
.\@selectable {
	font: normal 400 var(--p-font-size) / 1.4 'Roboto';
	display: inline-flex;
	flex-direction: column;
	padding: 2rem 0;
	cursor: pointer;
	&-icon {
		width: 20px;
		height: 20px;
		display: inline-block;
		vertical-align: middle;
		border-radius: 50%;
		border: 2px solid var(--primary);
		position: relative;
		cursor: pointer;
		&::after {
			content: '';
			height: 8px;
			width: 8px;
			position: absolute;
			top: 4px;
			left: 4px;
			border-radius: 50%;
			background-color: var(--primary);
			opacity: 0;
			transition: 400ms ease-in-out;
		}
	}
	&-input:checked + &-icon {
		&::after {
			opacity: 1;
		}
	}
	&-it {
		padding: 0.2em 0;
	}
}
</style>
