<template>
	<AppLayout>
		<InternalBanner
			class="contact-banner-mobile"
			:title="post.title_banner"
			:image="post.banner_image"
			:imageMobile="post.banner_image_mob"
			:homeInicio="polylang.menu[0].label"
		/>
		<section class="contact-wrap p-contact-pg">
			<figure class="contact-wrap__image">
				<img :src="post.contact_image" :alt="post.contact_title" class="imgResponsive" />
				<iframe
					class="mapa-url"
					src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3155.6933686609027!2d-122.1540414!3d37.7268747!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f8fbd886d2a67%3A0xb4927dd2033a6ab9!2s433%20Callan%20Ave%2C%20San%20Leandro%2C%20CA%2094577%2C%20EE.%20UU.!5e0!3m2!1ses-419!2spe!4v1657562281783!5m2!1ses-419!2spe"
					width="400"
					height="300"
					style="border: 0"
					allowfullscreen=""
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
				></iframe>
			</figure>
			<!-- <div class="contact-wrap__image p-contact-pg__map">
				<iframe
					:src="resolveGoogleMapsUri"
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					class="w-full h-full"
				>
				</iframe>
			</div> -->
			<div class="contact-wrap__ctn p-contact-pg__content">
				<div class="contact-wrap__ctn__info">
					<Information :title="post.contact_title" :text="post.contact_description" />
					<SocialMedia :address="true" />
					<form @submit.prevent="handleSendForm" :class="{ error: failure }" method="POST">
						<div class="contact-wrap__ctn__info__form">
							<TextField
								type="text"
								:placeholder="post.form.v_name.placeholder"
								:name="post.form.v_name.name"
								@send="validateField($event, 'v_name')"
								:error="errors.v_name"
							/>
							<TextField
								type="tel"
								:placeholder="post.form.v_phone.placeholder"
								:name="post.form.v_phone.name"
								@send="validateField($event, 'v_phone', 'phone', 'tel')"
								:error="errors.v_phone"
							/>
							<TextField
								type="email"
								:placeholder="post.form.v_email.placeholder"
								:name="post.form.v_email.name"
								@send="validateField($event, 'v_email', 'email', 'email')"
							/>
							<DropdownField :label="post.form.v_gender.placeholder" @send="validateField($event, 'v_gender')" />
							<TextField :custom="true">
								<textarea :placeholder="post.form.v_message.placeholder" class="input-gral textarea" :name="post.form.v_message.name" />
							</TextField>
						</div>
						<div class="send-wrap">
							<ButtonGeneral class="green" :text="post.form.submit.label" />
							<div class="loader" :class="{ active: sending }"></div>
						</div>
						<div class="feedback-message init" v-if="message" :class="{ failure }">
							{{ message }}
						</div>
					</form>
				</div>
			</div>
		</section>
	</AppLayout>
</template>

<script>
import { httpClient } from '@/plugins/http';
import axios from 'axios';
import { setupFormData, TYPE_FIELD, FORM_HEADER } from '@/plugins/utils.js';
import { mapState } from 'vuex';
export default {
	name: 'Contact',
	components: {
		Information: () => import('~/components/molecules/Information.vue'),
		TextField: () => import('~/components/atoms/TextFIeld.vue'),
		DropdownField: () => import('~/components/atoms/DropdownField.vue'),
		InternalBanner: () => import('~/components/molecules/InternalBanner.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		// ...mapState(['polylang'], {
		// 	common: state => state.common,
		// }),
		resolveGoogleMapsUri() {
			return (
				this.common.address_url_map_embed ||
				'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3155.6931887329915!2d-122.15404138504628!3d37.72687892268735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f8fbd886d2a67%3A0xb4927dd2033a6ab9!2s433%20Callan%20Ave%2C%20San%20Leandro%2C%20CA%2094577%2C%20EE.%20UU.!5e0!3m2!1ses!2spe!4v1656634611883!5m2!1ses!2spe'
			);
		},
	},
	methods: {
		validateField(value, type, valid = 'any', valid_by = 'required') {
			if (!String(value).trim()) {
				this.errors[type] = this.post.form.messages.invalid_required;
			} else if (!TYPE_FIELD[valid].test(value)) {
				this.errors[type] = this.post.form.messages[`invalid_${valid_by}`];
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
					this.errors[key] = this.post.form.messages.invalid_required;
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
			// const FORM_URL = this.post.form.submit.url;
			const FORM_URL = 'https://lotusstetic.amgbusiness.us/index.php/wp-json/contact-form-7/v1/contact-forms/15/feedback';
			try {
				this.message = '';
				this.sending = true;
				const { data, status } = await axios.post(FORM_URL, response, FORM_HEADER);
				this.message = data.message;

				setTimeout(() => {
					this.message = '';
				}, 5000);

				if (data.status == 'mail_sent' && data.invalid_fields.length == 0) {
					event.target.reset();
					this.clearResponses();
					this.failure = false;
				} else {
					this.failure = true;
					this.setErrors();
				}
			} catch (error) {
				return console.log(error);
			}

			this.sending = false;
		},
	},
	async asyncData({ app, redirect }) {
		try {
			const locale = app.i18n.locale;
			const { data: post } = await httpClient.get(`/page?template=contact-us&seo=allow&lang=${locale}`);
			return {
				post,
			};
		} catch (error) {
			redirect({ name: '404' });
		}
	},
	data() {
		return {
			data: {
				v_name: '',
				v_phone: '',
				v_email: '',
				v_message: '',
				v_gender: '',
			},
			message: '',
			errors: {
				v_name: '',
				v_phone: '',
				v_email: '',
				v_gender: '',
			},
			sending: false,
			failure: false,
		};
	},
};
</script>

<style lang="postcss">
.contact-banner-mobile {
	@media (min-width: 1200px) {
		@apply !hidden;
	}
}

.contact-wrap {
	@apply w-full flex flex-wrap;
	&__image {
		@apply w-[43.2%] min-h-full max-h-[105vh] relative;
		@media (min-width: 1200px) {
			@apply max-h-[123vh];
		}
		@media (min-width: 1400px) {
			@apply max-h-[118vh];
		}
		@media (min-width: 1700px) {
			@apply max-h-[110vh];
		}
		/* z-index: -1; */
		.mapa-url {
			@apply absolute right-0 bottom-0 z-[20] w-[40%] h-[40%];
		}
	}
	&__ctn {
		@apply w-[56.8%] h-full py-[7.5rem] px-[9.5rem] flex items-center;
		&__info {
			@apply w-full max-w-[73%];
			.title-general {
				font-family: 'Cormorant-Garamond-Bold', sans-serif;
				@apply text-[4.5rem];
			}
			.ctn-info {
				p {
					@apply text-[1.8rem] first:mt-[1.5rem];
				}
			}
			.items-socials {
				@apply flex flex-wrap mt-[3rem] items-start;
				li {
					width: calc(50% - 1.5rem);
					@apply mr-[3rem] mb-0 leading-[1.5];
					&:nth-child(even) {
						@apply mr-[0];
					}
				}
				&__adress {
					@apply order-1;
				}
				&__mail {
					@apply order-2;
				}
				&__tel {
					@apply order-3 mt-[-2.3rem];
					margin-left: calc(50% - 1.5rem);
				}
				&__cel {
					@apply hidden;
				}
				span i {
					@apply hidden;
				}
				a {
					@apply text-gray-700;
				}
				em {
					@apply mt-[4px];
				}
			}
			form {
				@apply mt-[4rem] w-full relative;
				.btn-gral.green {
					@apply rounded-[5px] px-[5rem];
				}
			}
			&__form {
				@apply w-full mb-[2.5rem];
				.textField {
					@apply w-full mb-[2.5rem]  last:mb-[0] block;
				}
				.inline-full {
					@apply block;
				}
				.input-gral {
					font-family: 'Roboto', sans-serif;
					@apply w-full h-[4.5rem] rounded-[5px] text-[1.7rem] block border-gray-600 border-[1px] border-solid px-[2.5rem] text-gray-600;
					&::placeholder {
						@apply text-gray-600;
					}
					&.textarea {
						@apply pt-[1.5rem] h-[17.5rem];
					}
				}
			}
		}
	}
	@screen laptop {
		&__ctn {
			@apply px-[6rem];
			&__info {
				@apply max-w-[90%];
				.ctn-info {
					.title-general {
						@apply text-[3.8rem];
					}
					p {
						@apply text-[1.6rem] first:mt-[1rem];
					}
				}
				form {
					@apply mt-[3rem];
					.input-gral {
						@apply h-[4rem];
						&.textarea {
							@apply h-[17rem];
						}
					}
					.textField {
						@apply mb-[2rem];
					}
					.btn-gral.green {
						@apply px-[4rem];
					}
				}
				.items-socials {
					em {
						@apply mt-[2px];
					}
				}
			}
		}
	}
	@screen tablet {
		@apply pt-[4.5rem] pb-[7rem] h-[auto];
		&__image {
			@apply hidden;
		}
		&__ctn {
			@apply w-full px-[3rem] pt-0 pb-0;
			align-items: initial;
			&__info {
				@apply max-w-[inherit];
			}
		}
	}
	@screen mobile {
		&__ctn {
			&__info {
				.ctn-info {
					.title-general {
						@apply text-[3rem];
					}
					p {
						@apply text-[1.7rem];
					}
				}
				.items-socials {
					align-items: initial;
					li {
						@apply w-full mr-0 mb-[1.25rem];
					}
				}
				.items-socials__tel {
					@apply ml-0 mt-0;
					margin-bottom: 0 !important;
				}
			}
		}
	}
}
</style>
