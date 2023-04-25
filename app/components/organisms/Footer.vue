<template>
	<footer class="footer">
		<AppContainer class="footer__container">
			<div class="footer__section section1">
				<h3 class="footer__title">{{ polylang.title_lotus }}</h3>
				<p class="footer__text">
					{{ splited(polylang.content_lotus, 0) }} <br />
					{{ splited(polylang.content_lotus, 1) }}
				</p>
			</div>
			<!-- <div class="footer__section section2">
				<h3 class="footer__title">{{ polylang.title_links }}</h3>
				<NuxtLink class="footer__link" to="/">Shipments</NuxtLink>
				<NuxtLink class="footer__link" to="/">Returns</NuxtLink>
				<NuxtLink class="footer__link" to="/">Prices</NuxtLink>
				<NuxtLink class="footer__link" to="/">The losses</NuxtLink>
			</div> -->
			<div class="footer__section section3">
				<h3 class="footer__title">{{ polylang.title_contact_poly }}</h3>
				<ul class="footer__info">
					<li v-if="mail(0)" class="footer__item">
						<div class="footer__icon icon-footer-email"></div>
						<a :href="'mailto:' + mail(0)" class="footer__text--info">{{ mail(0) }}</a>
					</li>
					<!-- <li v-if="mail(1)" class="footer__item">
						<div class="footer__icon icon-footer-email"></div>
						<a :href="'mailto:' + mail(1)" class="footer__text--info">{{ mail(1) }}</a>
					</li> -->
					<li v-if="common.phone" class="footer__item footer__item--phone">
						<div class="footer__icon icon-footer-phone"></div>
						{{ polylang.title_ofi_poly }}
						<a :href="'tel:' + common.phone" class="footer__text--info">{{ common.phone }}</a>
					</li>
					<li v-if="common.cel" class="footer__item footer__item--phone">
						<div class="footer__icon icon-footer-phone"></div>
						{{ polylang.title_cel_poly }}
						<a :href="'tel:' + common.cel" class="footer__text--info">{{ common.cell }}</a>
					</li>
					<li class="footer__item">
						<div class="footer__icon icon-footer-map"></div>
						<a :href="common.address_url_map" target="_blank" class="footer__text--info" v-html="common.address"></a>
					</li>
				</ul>
				<SocialIcons :items="common.social_networks" type="footer" />
			</div>
			<div class="footer__section section4">
				<h3 class="footer__title">{{ polylang.title_hours }}</h3>
				<div>
					<div class="footer__shedule" v-for="(item, index) in polylang.list_hours" :key="index">
						<p class="footer__days">{{ item.day }}</p>
						<p class="footer_hours">{{ item.hour }}</p>
					</div>
				</div>
				<div class="footer__payment">
					<span class="footer_payment-method icon-visa"></span>
					<span class="footer_payment-method icon-paypal"></span>
					<span class="footer_payment-method icon-mastercard"></span>
				</div>
			</div>
			<div class="footer__arrow" @click="goTop">
				<img :src="require('@/assets/img/arrowup.svg')" alt="svg" />
			</div>
		</AppContainer>
		<picture class="footer__bg">
			<img :src="require('@/assets/img/bg-footer.svg')" alt="svg" />
		</picture>
	</footer>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'Footer',
	components: {
		AppContainer: () => import('../globals/AppContainer.vue'),
		SocialIcons: () => import('../atoms/SocialIcons.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		mail() {
			return offset => {
				const email = this.common.email.split('|');
				if (email.length > 1) {
					return email[offset].trim();
				}
				return this.common.email;
			};
		},
		splited() {
			return (str, offset) => {
				return str.split('/')[offset];
			};
		},
	},
	methods: {
		goTop() {
			window.scrollTo(0, 0);
		},
	},
};
</script>

<style lang="postcss">
div.footer__container {
	@apply flex flex-col;
	@media screen(lg) {
		@apply flex-row justify-between max-w-[79%];
	}
}
.footer {
	@apply bg-green relative flex justify-between text-[2.5rem] pt-[1.5em] pb-[1.5em] overflow-hidden;
	@media screen(lg) {
		@apply text-[1.8rem];
	}
	@media screen(xl) {
		@apply text-[1.8rem] pt-[4.9em] pb-[3em];
	}
	@media screen(design) {
		@apply text-[2rem];
	}
	@media screen(monitor) {
		@apply text-[2.5rem];
	}
}

.footer__bg {
	@apply hidden;
	@media screen(xl) {
		content: '';
		@apply flex absolute left-0 bottom-0 pointer-events-none w-[12em];
		img {
			@apply w-full object-cover;
		}
	}
}

.footer__section {
	&.section1 {
		@apply hidden;
	}
	border-bottom: 1px solid white;
	@apply pb-[2rem] mb-[3rem];
	&.section4 {
		@apply border-none mb-0 pb-0;
	}
	@apply flex flex-col;
	.footer__link:not(:last-child) {
		@apply mb-[.8em];
	}
	.footer__item:not(:last-child) {
		@apply mb-[.8em];
	}
	@media screen(lg) {
		@apply border-none mb-0 pb-0;
	}
	@media screen(xl) {
		&.section1 {
			@apply flex;
		}
	}
}

.footer__title {
	font-family: 'Cormorant Garamond';
	@apply text-white text-[22px] mb-[.8em] leading-none font-normal;
	@media (min-width: 1200px) {
		@apply text-[1em];
	}
}

.footer__arrow {
	@apply hidden;
	@media screen(xl) {
		@apply flex w-[3.24em] cursor-pointer self-start;
		img {
			@apply w-full;
		}
	}
}

.footer__text {
	@apply w-[39.5ch] text-[1.6rem] tracking-[0.02em] text-white/80;
}

.footer__text--info {
	@apply text-[16px] text-white/80;
	@media (min-width: 1200px) {
		@apply text-[1em];
	}
}

.footer__item {
	@apply flex text-white/80 text-[.72em];
}

.footer__icon {
	@apply text-[1.1em];
}

.footer__item {
	@apply flex gap-[.6em];
	&--phone {
		@apply uppercase;
		@media (max-width: 1200px) {
			@apply text-[16px];
		}
	}
}

.footer__link {
	@apply text-white/80 flex items-center gap-[.3em] text-[.72em];
	&::before {
		--dot-size: 0.18em;
		content: '';
		@apply block w-[var(--dot-size)] h-[var(--dot-size)] rounded-full bg-white/80;
	}
}

.footer__shedule {
	@apply grid grid-cols-2 gap-x-[1em] mb-[.3em];
}

.footer__shedule:last-child {
	@apply mb-0;
}

.footer__days,
.footer_hours {
	@apply !text-[16px] text-white/80;
	@media (min-width: 1200px) {
		@apply !text-[.72em];
	}
}

.footer_payment-method {
	@apply inline-block text-white/80 text-[1.35em] mr-[.1em] mt-[.5em];
}
</style>
