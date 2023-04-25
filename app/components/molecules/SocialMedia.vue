<template>
	<ul class="items-socials">
		<li class="items-socials__mail">
			<em class="icon-footer-email"></em>
			<span>
				<a :href="'mailto:' + mail(0)">{{ mail(0) }}</a>
			</span>
		</li>
		<!-- <li class="items-socials__mail">
			<em class="icon-footer-email"></em>
			<span>
				<a :href="'mailto:' + mail(1)">{{ mail(1) }}</a>
			</span>
		</li> -->
		<li class="items-socials__tel" v-if="common.phone">
			<em class="icon-footer-phone"></em>
			<span
				><i>{{ polylang.title_ofi_poly }}</i> <a :href="'tel:' + common.phone">{{ common.phone }}</a></span
			>
		</li>
		<li class="items-socials__cel" v-if="common.cell">
			<em class="icon-footer-phone"></em>
			<span
				><i>{{ polylang.title_cel_poly }}</i> <a :href="'tel:' + common.cell">{{ common.cell }}</a></span
			>
		</li>
		<li v-if="address" class="items-socials__adress">
			<em class="icon-footer-map"></em>
			<span><a :href="common.address_url_map" target="_blank" v-html="common.address"></a></span>
		</li>
	</ul>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'SocialMedia',
	props: {
		address: Boolean,
	},
	computed: {
		...mapState(['common', 'polylang']),
		mail() {
			return function (offset) {
				const email = this.common.email.split('|');
				if (email.length > 1) {
					return email[offset].trim();
				}
				return this.common.email;
			};
		},
	},
};
</script>

<style lang="postcss">
.items-socials {
	li {
		@apply leading-[1.2] text-[1.8rem] mb-[1.5rem] tracking-[0.03em] last:mb-0 flex items-start;
	}
	em {
		@apply text-[2rem] mr-[1rem] w-[2.2rem];
	}
	i {
		@apply not-italic uppercase;
	}
	a {
		@apply text-gray;
	}
	&.white {
		li,
		a {
			@apply text-white;
		}
	}
	@screen laptop {
		li {
			@apply text-[1.6rem] leading-[1] items-center;
			@media (min-width: 1200px) {
				@apply text-[1.4rem];
			}
			@media (min-width: 1400px) {
				@apply text-[1.6rem];
			}
		}
		em {
			@apply text-[1.8rem] mr-[.7rem] w-[2rem];
		}
	}
}
</style>
