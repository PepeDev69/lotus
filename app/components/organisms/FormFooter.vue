<template>
	<section class="message-footer">
		<AppContainer class="landing-message-fo message-footer__container">
			<div class="message-footer__info">
				<Information :title="polylang.title_contact_two_poly" :text="polylang.content_contact_poly" />
				<SocialMedia />
			</div>
			<div class="message-footer__form">
				<Titles :title="polylang.title_contact_poly" />
				<form @submit.prevent="handleSendForm" :class="{ error: failure }" method="POST">
					<div class="message-footer__form__ctn">
						<TextField
							type="text"
							:placeholder="form.v_name.placeholder"
							:name="form.v_name.name"
							@send="validateField($event, 'v_name')"
							:error="errors.v_name"
						/>
						<TextField
							type="tel"
							:placeholder="form.v_phone.placeholder"
							:name="form.v_phone.name"
							@send="validateField($event, 'v_phone', 'phone', 'tel')"
							:error="errors.v_phone"
						/>
						<TextField
							type="email"
							:placeholder="form.v_email.placeholder"
							:name="form.v_email.name"
							@send="validateField($event, 'v_email', 'email', 'email')"
							:error="errors.v_email"
						/>
						<TextField :custom="true">
							<textarea :placeholder="form.v_message.placeholder" class="input-gral textarea" :name="form.v_message.name" />
						</TextField>
					</div>
					<div class="send-wrap">
						<ButtonGeneral class="border" :text="form.submit.label" />
						<div class="loader" :class="{ active: sending }"></div>
					</div>
					<div class="feedback-message init" v-if="message" :class="{ failure }">
						{{ message }}
					</div>
				</form>
			</div>
		</AppContainer>
	</section>
</template>

<script>
import { mapState } from 'vuex';
import axios from 'axios';
import { setupFormData, TYPE_FIELD, FORM_HEADER } from '@/plugins/utils.js';
export default {
	name: 'FormFooter',
	components: {
		Information: () => import('@/components/molecules/Information.vue'),
		TextField: () => import('@/components/atoms/TextFIeld.vue'),
	},
	computed: {
		...mapState({
			common: state => state.common,
			polylang: state => state.polylang,
			form: state => state.polylang.form,
		}),
	},
	data() {
		return {
			data: {
				v_name: '',
				v_phone: '',
				v_email: '',
				v_message: '',
				v_gender: '...',
			},
			message: '',
			errors: {
				v_name: '',
				v_phone: '',
				v_email: '',
				v_message: '',
				v_gender: '',
			},
			sending: false,
			failure: false,
		};
	},
	methods: {
		validateField(value, type, valid = 'any', valid_by = 'required') {
			if (!String(value).trim()) {
				this.errors[type] = this.form.messages.invalid_required;
			} else if (!TYPE_FIELD[valid].test(value)) {
				this.errors[type] = this.form.messages[`invalid_${valid_by}`];
			} else {
				this.errors[type] = 'true';
				this.data[type] = value;
			}
		},
		setErrors() {
			Object.keys(this.errors).forEach(key => {
				if (this.data[key] === '') {
					this.errors[key] = 'This field is required';
					setTimeout(() => {
						this.errors[key] = '';
					}, 5000);
				}
			});
		},
		rebuildErrorMessages() {
			for (let key in this.error) {
				if (this.errors[key] == '' || !this.errors[key].includes('true')) {
					this.errors[key] = this.form.messages.invalid_required;
				}
			}
		},
		clearResponses() {
			for (let key in this.data) {
				this.data[key] = '';
			}
			this.currentService = '';
		},
		async handleSendForm(event) {
			const response = setupFormData(this.data);
			const FORM_URL = this.form.submit.url;
			try {
				this.message = '';
				this.sending = true;
				const { data, status } = await axios.post(FORM_URL, response, FORM_HEADER);
				this.message = data.message;

				setTimeout(() => {
					this.message = '';
				}, 5000);

				if (status == 200 && data.invalid_fields.length == 0) {
					event.target.reset();
					this.clearResponses();
					this.failure = false;
				} else {
					this.failure = true;
					this.setErrors();
				}
			} catch (error) {
				return alert(error);
			}

			this.sending = false;
		},
	},
};
</script>

<style lang="postcss">
.landing-message-fo {
	display: flex;
	flex-direction: column;
	@media screen(lg) {
		flex-direction: row;
	}
}
.message-footer {
	@apply w-full py-[6rem] bg-cream relative;
	@media (min-width: 1200px) {
		&__container {
			@apply max-w-[80%];
		}
	}
	.items-socials {
		@apply mt-[2rem];
	}
	.title-general {
		@apply text-[3rem];
	}
	.section-ctn {
		@apply flex flex-wrap justify-between items-center;
	}
	&__info {
		padding-bottom: 3rem;
	}
	&__form {
		@media (min-width: 1200px) {
			@apply mr-[7rem];
		}
		form {
			@apply mt-[4rem] relative;
		}
		&__ctn {
			@apply flex flex-wrap mb-[3rem];
		}
		.textField {
			@apply w-full mb-[3.5rem] last:mb-0;
			@media (min-width: 1200px) {
				@apply mb-[2.5rem];
			}
			@media (min-width: 1400px) {
				@apply mb-[3rem];
			}
			&:nth-child(2),
			&:nth-child(3) {
				width: calc(50% - 1rem);
				@apply mr-[2rem];
			}
			&:nth-child(3) {
				@apply mr-0;
			}
		}
		.input-gral {
			border-bottom: 1px solid;
			font-family: 'Roboto-Light', sans-serif;
			color: rgba(96, 96, 96, 0.7);
			@apply border-gray-three h-[3rem] text-[1.9rem];
			@media (min-width: 1200px) {
				@apply text-[1.5rem];
			}
			@media (min-width: 1400px) {
				@apply text-[1.7rem];
			}
			@media (min-width: 1700px) {
				@apply text-[1.9rem];
			}
			&::placeholder {
				color: rgba(96, 96, 96, 0.7);
			}
			&.textarea {
				@apply h-[9rem];
			}
		}
	}
	&:before {
		content: '';
		background: url('~/assets/img/bg-form-footer.png') no-repeat center;
		background-size: cover;
		@apply absolute right-[2.7%] h-[65%] w-[10%] bottom-0;
	}
	@media screen(lg) {
		.title-general {
			font-size: 3rem;
		}
		&__info {
			@apply w-[47.5%];
		}
		&__form {
			@apply w-[40%];
		}
	}
	@media screen(monitor) {
		.title-general {
			font-size: 4rem;
		}
	}
	@screen tablet {
		@apply hidden;
	}
}
</style>
