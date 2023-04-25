<template>
	<section class="form">
		<h1 :class="css.title">{{ polylang.title_checkout }}</h1>
		<form method="POST">
			<fieldset :class="css.group">
				<BaseInput
					:label="polylang.name_form.label"
					:placeholder="polylang.name_form.placeholder"
					type="text"
					@input="validateFieldWithType('name', $event)"
					:error="errors.name"
				/>
				<BaseInput
					:label="polylang.last_name_form.label"
					:placeholder="polylang.last_name_form.placeholder"
					type="text"
					@input="validateFieldWithType('last_name', $event)"
					:error="errors.last_name"
				/>
			</fieldset>
			<!-- <BaseInput
				label="Company Name"
				placeholder="Company Name"
				type="text"
				@input="validateFieldWithType('company', $event, false)"
			/> -->
			<!-- <BaseInput :group="true" label="Street Address">
				<BaseInput
					placeholder="House number and street name *"
					type="text"
					@input="validateFieldWithType('address', $event)"
					:error="errors.address"
				/>
				<BaseInput
					placeholder="Apartment, suite, unit, etc (optional)"
					type="text"
					@input="validateFieldWithType('apartment', $event, false)"
				/>
			</BaseInput> -->
			<!-- <BaseInput
				label="Town / City *"
				placeholder="Houston"
				type="text"
				@input="validateFieldWithType('city', $event)"
				:error="errors.city"
			/> -->
			<!-- <BaseInput
				label="State / Country *"
				placeholder="Texas - USA"
				type="text"
				@input="validateFieldWithType('state', $event)"
				:error="errors.state"
			/> -->
			<!-- <BaseInput
				label="Zip Code *"
				placeholder="9056-9074"
				type="text"
				@input="validateFieldWithType('zipcode', $event, true, 'zipcode')"
				:error="errors.zipcode"
			/> -->
			<BaseInput
				:label="polylang.phone_form.label"
				:placeholder="polylang.phone_form.placeholder"
				type="tel"
				@input="validateFieldWithType('phone', $event, true, 'phone')"
				:error="errors.phone"
			/>
			<BaseInput
				:label="polylang.email_form.label"
				:placeholder="polylang.email_form.placeholder"
				type="email"
				@input="validateFieldWithType('email', $event, true, 'email')"
				:error="errors.email"
			/>
		</form>
	</section>
</template>

<script>
import { TYPE_FIELD } from '@/plugins/utils';
import { mapState } from 'vuex';
export default {
	name: 'PaymentCheckout',
	methods: {
		validateFieldWithType(type, value, required = true, val = 'any') {
			let withValidation = false;
			if (String(value).trim() === '' && required) {
				this.errors[type] = 'Input Required';
				withValidation = false;
			} else if (!TYPE_FIELD[val].test(value)) {
				this.errors[type] = 'Invalid Value';
				withValidation = false;
			} else {
				this.errors[type] = '';
				withValidation = true;
			}
			this.$store.dispatch('user/makeValidate', {
				key: type,
				value: withValidation,
			});
			this.$store.dispatch('user/updateShopper', {
				key: type,
				value: value,
			});
		},
	},
	computed: {
		...mapState(['common', 'polylang']),
	},
	watch: {
		'$route.path': {
			immediate: true,
			handler(route) {
				this.$store.dispatch('user/deleteShopper');
			},
		},
	},
	data: () => ({
		errors: {
			name: '',
			last_name: '',
			// address: '',
			// city: '',
			// state: '',
			// zipcode: '',
			phone: '',
			email: '',
		},
	}),
};
</script>

<style lang="postcss" module="css">
.title {
	font: normal 700 2.8rem / 1.2 'Cormorant-Garamond-Bold', serif;
	color: #395d64;
	margin-bottom: 0.6em;
}
.group {
	@apply text-white grid grid-cols-2 gap-10;
}
.column {
	@apply text-white flex flex-col;
}
</style>
