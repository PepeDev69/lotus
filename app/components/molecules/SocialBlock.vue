<template>
	<ul class="sc-social-b">
		<template v-for="(social, index) in items">
			<li :key="index" :title="social.url ? social.type : 'Coming Soon'" class="sc-social-b__item">
				<a
					class="icon"
					:class="['icon-' + type + '-' + social.type, social.url ? 'pointer-events-auto' : 'pointer-events-none']"
					:href="social.url ? social.url : '#'"
					:target="social.url ? '_blank' : ''"
				/>
			</li>
		</template>
		<li class="switch-lang">
			<SwitchLanguage />
		</li>
		<li class="sc-social-b__item sc-cart">
			<ShopCartCounter :count="count" :label="cartLabel" />
		</li>
	</ul>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
export default {
	name: 'SocialBlock',
	components: {
		ShopCartCounter: () => import('@/components/molecules/ShopCartCounter.vue').then(e => e.default),
		SwitchLanguage: () => import('../atoms/SwitchLanguage.vue'),
	},
	props: {
		type: {
			type: String,
			default: '',
		},
	},
	computed: {
		...mapState({
			items: state => state.common.social_networks,
			cartLabel: state => state.polylang.header_cart,
		}),
		...mapGetters('shop', {
			count: 'getCartCount',
		}),
	},
};
</script>

<style lang="postcss">
.switch-lang {
	@apply mx-[.9em];
}
.sc-social-b {
	li:first-child {
		@apply mr-[.6em];
	}
}
.sc-social-b {
	display: flex;
	font-size: 2rem;
	align-items: center;
	color: var(--primary);
	/* column-gap: 1em; */
	&__item:not(.sc-cart) {
		display: inline-flex;
	}
	@media (min-width: 1025px) {
		font-size: var(--p-font-size);
	}
	@media (max-width: 1024px) {
		&__item.sc-cart span {
			display: none;
		}
	}
}
</style>
