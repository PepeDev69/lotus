<template>
	<AppLink :to="{ name: 'shop-cart' }" class="xt-shop-cart">
		<span class="xt-shop-cart__label">{{ polylang.header_cart || 'Carrito' }}</span>
		<span class="icon-header-shop xt-shop-cart__icon">
			<span class="@count">{{ count }}</span>
		</span>
	</AppLink>
</template>

<script>
import { mapGetters, mapState } from 'vuex';
export default {
	name: 'ShopCartCount',
	computed: {
		...mapGetters('shop', {
			count: 'getCartCount',
		}),
		...mapState(['polylang'])
	},
};
</script>

<style lang="postcss">
.xt-shop-cart {
	position: relative;
	.\@count {
		position: absolute;
		top: 0;
		right: -0.8em;
		font-size: 10px;
		width: 1.5em;
		height: 1.5em;
		border-radius: 50%;
		background-color: #FCEBE5;
		color: #A3A3A3;
		display: inline-flex;
		justify-content: center;
		align-items: center;
		line-height: 1.5;
	}
	&__label {
		font: normal 500 calc(var(--p-font-size) - 1px) /1 "Work-Sans", serif;
		text-transform: uppercase;
	}
}
</style>
