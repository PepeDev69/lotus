<template>
	<AppOverlay :open="withOpen">
		<article class="ts-card-added">
			<div class="trs-card__content">
				<h3>{{ polylang.title_cart_successfully }}</h3>
			</div>
			<div class="ts-card__resume">
				<div class="resume--card">
					<h5>{{ polylang.title_your_cart }}</h5>
				</div>
			</div>
		</article>
	</AppOverlay>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
	name: "AddToCart",
	props: {
		open: {
			type: Boolean,
			default: false,
		},
		picture: String,
		name: String,
		type: String,
	},
	computed: {
		...mapState(["common", "polylang"]),
		...mapGetters("shop", {
			total: "getTotalAmountInParts",
		}),
	},
	data: () => ({
		withOpen: false,
	}),
	watch: {
		open(newValue, oldValue) {
			this.withOpen = newValue;
		},
	},
};
</script>

<style lang="postcss">
.ts-card-added {
}
</style>
