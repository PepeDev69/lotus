<template>
	<AppLink :to="{ name: 'shop-cart' }" class="xt-shop-cart">
		<span class="xt-shop-cart__label">{{ label }}</span>
		<svg width="28" height="25" fill="none" viewBox="0 0 28 25">
			<path
				fill="#395D64"
				d="M13.15 7.308h2.081c.642.003.916.248.967.887.297 3.689.592 7.377.885 11.065.082 1.025.19 2.049.246 3.075.076 1.41-.788 2.293-2.207 2.294-4.302.002-8.604.002-12.905 0-1.439 0-2.311-.889-2.209-2.33.187-2.65.418-5.298.63-7.946.16-1.965.329-3.93.476-5.895.072-.963.247-1.15 1.195-1.15h1.876c.024-1.55.587-2.825 1.824-3.756a4.325 4.325 0 0 1 2.973-.874c1.986.134 4.11 1.713 4.169 4.63ZM2.635 8.858c-.021.217-.041.399-.056.582l-.299 3.714-.734 9.14c-.053.676.078.796.772.796h12.346c1.169 0 1.2-.042 1.105-1.215a11047.5 11047.5 0 0 1-.939-11.573c-.039-.48-.087-.958-.13-1.434h-1.571v3.57c0 .627-.278.968-.776.962-.497-.005-.76-.348-.761-.98V8.872H5.745c0 1.226.003 2.424 0 3.622 0 .562-.286.895-.752.905-.487.01-.783-.328-.785-.912-.003-1.071 0-2.143 0-3.215v-.417l-1.574.003Zm8.96-1.57c-.004-1.214-.478-2.13-1.496-2.7-1.034-.582-2.09-.535-3.076.13-.89.601-1.303 1.466-1.277 2.57h5.85Z"
			/>
			<g>
				<circle cx="20" cy="8" r="8" fill="#FCEBE5" />
				<text
					text-anchor="middle"
					x="20"
					y="12"
					width="20"
					style="fill: var(--primary); font-size: 10px"
				>
					{{ count }}
				</text>
			</g>
		</svg>
	</AppLink>
</template>

<script>
export default {
	name: 'ShopCartCount',
	props: {
		count: [Number, String],
		label: String,
	},
};
</script>

<style lang="postcss">
.xt-shop-cart {
	position: relative;
	display: flex;
	font-size: calc(var(--p-font-size) - 1px);
	column-gap: 1em;
	align-items: center;
	.\@count {
		position: absolute;
		top: 0;
		right: -0.8em;
		font-size: 10px;
		width: 1.5em;
		height: 1.5em;
		border-radius: 50%;
		background-color: #fcebe5;
		color: #a3a3a3;
		display: inline-flex;
		justify-content: center;
		align-items: center;
		line-height: 1.5;
	}
	&__label {
		font: normal 500 1em / 1 var(--font-work), serif;
		text-transform: uppercase;
	}
}
</style>
