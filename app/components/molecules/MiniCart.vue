<template>
	<article class="crt-resume" :class="{ init }">
		<h3 class="@mod-title crt-title">{{ polylang.title_minicart }}</h3>
		<section class="crt-body">
			<div class="crt-item">
				<span>{{ total.count }} {{ textProducts || 'products' }}</span>
				<span>{{ total.partial | currency }}</span>
			</div>
			<div class="crt-item" v-if="sitemeta.delivery_amount !== '0'">
				<span>{{ polylang.delivery_minicart || 'Delivery' }}</span>
				<span>{{ sitemeta.delivery_amount | currency }}</span>
			</div>
			<div class="crt-item">
				<span>{{ polylang.subtotal_minicart || 'Total' }}</span>
				<span>{{ total.totalAmount | currency }}</span>
			</div>
			<div class="crt-item separate-line">
				<span>{{ polylang.total_minicart || 'Total' }}</span>
				<span>{{ total.totalAmount | currency }}</span>
			</div>
			<div class="crt-item separate action">
				<slot></slot>
			</div>
		</section>
	</article>
</template>
<script>
import { mapState, mapGetters } from 'vuex';
export default {
	name: 'MiniCartResume',
	props: {
		title: {
			type: String,
			default: 'Cart Details',
		},
		init: Boolean,
	},
	computed: {
		...mapState({
			polylang: state => state.polylang,
			sitemeta: state => state.siteMeta,
		}),
		...mapGetters({
			total: 'shop/getTotalAmountInParts',
		}),
		textProducts() {
			const count = this.total.count;
			const lang = this.$i18n.locale;
			if (count > 1 && lang === 'es') {
				return 'productos';
			}
			if (count === 1 && lang === 'es') {
				return 'producto';
			}
			if (count > 1 && lang === 'en') {
				return 'products';
			}
			if (count === 1 && lang === 'en') {
				return 'product';
			}
		},
	},
};
</script>

<style lang="postcss">
.crt-resume:not(.init) {
	@apply bg-cyan-light p-[2rem];
	@media screen(lg) {
		padding: 3rem;
	}
	@media screen(design) {
		padding: 4rem;
	}
	@media screen(monitor) {
		padding: 5rem;
	}
}
.crt-title {
	font-size: 2.7rem;
	padding: 0.5em 0;
}
.crt-item {
	display: flex;
	justify-content: space-between;
	font-size: calc(var(--p-font-size) + 1px);
	&.action {
		padding-top: 3rem;
	}
	&.separate-line {
		border-top: 1px solid grey;
		padding-top: 1rem;
		margin-top: 1rem;
	}
	@media screen(lg) {
		width: 38ch;
	}
}
</style>
