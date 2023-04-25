<template>
	<div class="resumen-order">
		<h4>
			{{ title }}
			<strong v-if="titleArticle">(1 {{ titleArticle }})</strong>
		</h4>
		<ul>
			<li>
				<span>{{ titleReserv }}</span>
				<span>$50.00</span>
			</li>
			<li>
				<span>Subtotal</span>
				<span>$50.00</span>
			</li>
			<li>
				<span>Total</span>
				<span>$50.00</span>
			</li>
		</ul>
		<div>
			<ButtonGeneral :path="{ name: linkButton }" :text="label" class="blue" />
			<ButtonGeneral v-if="labelTwo" :text="labelTwo" class="blue" @click.native="$emit('close')" />
		</div>
	</div>
</template>

<script>
export default {
	name: "Resumen",
	props: {
		title: String,
		titleArticle: String,
		titleReserv: String,
		linkButton: String,
		label: String,
		labelTwo: String,
	},
};
</script>
