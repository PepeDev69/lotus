<template>
	<article class="mxp-cart" :class="{ type }">
		<div class="mxp-cart__destroy">
			<button @click="deleteProduct(id)" class="mpx-cart__button">
				<svg width="26" height="31" viewBox="0 0 26 31" fill="none">
					<path
						d="M3.10375 9.60706C3.01624 9.55294 3.00127 9.53567 2.9886 9.53452C1.0703 9.39174 0.652321 8.75153 1.25683 6.91498C1.37197 6.55112 1.48712 6.18611 1.61723 5.82341C1.96267 4.83086 2.52803 4.40828 3.59426 4.39792C5.10957 4.3841 6.62487 4.39792 8.14017 4.39792H8.86789C8.86789 3.89473 8.86789 3.42379 8.86789 2.954C8.87479 1.61948 9.48161 1 10.7943 1C12.2712 1 13.7481 1 15.225 1C16.4997 1 17.1157 1.62754 17.1238 2.91601C17.1238 3.37658 17.1238 3.83716 17.1238 4.35646C17.354 4.36913 17.5578 4.38986 17.7582 4.38986C19.2735 4.38986 20.79 4.38986 22.3053 4.38986C23.4797 4.39561 24.0198 4.79286 24.394 5.8948C24.5329 6.31622 24.6742 6.73573 24.8177 7.15333C25.3094 8.62487 24.8177 9.38828 23.2057 9.561C23.1481 10.1851 23.0813 10.8276 23.0295 11.4666C22.5943 16.8946 22.1602 22.3225 21.7272 27.7504C21.5902 29.4695 20.5182 30.477 18.7945 30.4793C15.0331 30.4839 11.2736 30.4839 7.51609 30.4793C5.74747 30.4793 4.70886 29.4741 4.56839 27.7158C4.13237 22.2503 3.68715 16.7848 3.23271 11.3193C3.1855 10.7435 3.1475 10.1701 3.10375 9.60706ZM4.83092 9.54488C4.93915 10.8506 5.04624 12.0919 5.14641 13.3331C5.53407 18.1485 5.9221 22.9634 6.31052 27.778C6.36234 28.4194 6.70777 28.7464 7.36295 28.7475C11.2172 28.7544 15.0719 28.7544 18.9269 28.7475C19.5717 28.7475 19.9183 28.4228 19.9874 27.7792C20.0484 27.2034 20.0784 26.6277 20.1244 26.0589C20.456 21.9705 20.7877 17.8817 21.1193 13.7926C21.2344 12.3855 21.3369 10.9784 21.4474 9.54488H4.83092ZM2.81128 7.76129H23.1711C23.0554 7.44718 22.9596 7.12605 22.8844 6.79983C22.7889 6.22411 22.4584 6.10896 21.9184 6.11472C18.2153 6.1366 14.5123 6.12624 10.8092 6.12624C8.50633 6.12624 6.20344 6.12048 3.90055 6.1366C3.68868 6.1366 3.36167 6.22756 3.28683 6.3761C3.07957 6.79523 2.97364 7.26502 2.81128 7.76129ZM15.3736 2.77553H10.6411V4.33919H15.3736V2.77553Z"
						fill="#606060"
						stroke="white"
						stroke-width="0.3"
					/>
					<path
						d="M7.46563 19.0961C7.33514 16.6658 7.20502 14.2351 7.07529 11.804C7.05585 11.6513 7.05083 11.4971 7.06032 11.3434C7.12365 10.8656 7.38618 10.5627 7.88591 10.5512C8.38564 10.5397 8.70229 10.8022 8.7495 11.2904C8.83125 12.1483 8.87385 13.0107 8.92106 13.872C9.15826 18.1584 9.39277 22.4456 9.62459 26.7336C9.65914 27.383 9.32407 27.8079 8.79095 27.8252C8.28316 27.8425 7.93888 27.4798 7.90088 26.8453C7.74735 24.2615 7.60074 21.678 7.46103 19.0949L7.46563 19.0961Z"
						fill="#606060"
						stroke="white"
						stroke-width="0.3"
					/>
					<path
						d="M18.5402 19.1168C18.4136 21.6431 18.2869 24.1698 18.1603 26.6968C18.1372 27.1862 18.0348 27.618 17.5051 27.7918C16.942 27.9738 16.4089 27.542 16.4262 26.8856C16.4527 25.8493 16.5114 24.813 16.5655 23.7836C16.7797 19.7075 16.9946 15.6314 17.2103 11.5553C17.2368 11.0441 17.3992 10.6468 17.9588 10.5593C18.5702 10.4637 18.9789 10.9255 18.9398 11.6532C18.8108 14.0643 18.68 16.4754 18.5472 18.8866C18.5472 18.9637 18.5391 19.0397 18.5356 19.1168H18.5402Z"
						fill="#606060"
						stroke="white"
						stroke-width="0.3"
					/>
					<path
						d="M12.1496 19.1353C12.1496 16.6996 12.1496 14.2647 12.1496 11.8305C12.1414 11.6383 12.1494 11.4456 12.1738 11.2548C12.2486 10.823 12.5192 10.5754 12.9556 10.5512C13.392 10.5271 13.7006 10.7309 13.8146 11.1569C13.8648 11.3805 13.8857 11.6096 13.8768 11.8386C13.8768 16.7276 13.8768 21.6166 13.8768 26.5057C13.8768 26.6208 13.8768 26.736 13.8768 26.8511C13.8399 27.4694 13.4899 27.8448 12.9729 27.8252C12.4789 27.8057 12.1554 27.4406 12.1531 26.8407C12.1462 24.273 12.1508 21.7041 12.1496 19.1353Z"
						fill="#606060"
						stroke="white"
						stroke-width="0.3"
					/>
				</svg>
			</button>
		</div>
		<div class="mxp-cart__content ctproduct" :class="type">
			<picture class="ctproduct__image">
				<img :src="withFallbackImage" />
			</picture>
			<div class="ctproduct__content">
				<h3 class="@mod-title @product__name">{{ name }}</h3>
				<template v-if="type === 'product'">
					<div class="@product__price">
						<StepInput :value="qty" @input="asyncUpdateProduct($event, id)" />
						<span class="@price">{{ price | currency }}</span>
					</div>
				</template>
				<template v-else>
					<div class="@product__status">
						<SelectablePrice :first-price="partial" :second-price="price" v-model.number="payed" />
					</div>
				</template>
			</div>
			<template v-if="type == 'service'">
				<DateSelectable
					class="@product__selectable date-selectable"
					:date="{ from: date.from, to: date.to }"
					@click="$emit('update-service')"
				/>
			</template>
		</div>
	</article>
</template>

<script>
export default {
	name: 'ProductCartItem',
	components: {
		StepInput: () => import('@/components/atoms/StepInput.vue'),
		DateSelectable: () => import('~/components/molecules/DateSelectable.vue'),
		SelectablePrice: () => import('~/components/atoms/SelectablePrice.vue'),
	},
	computed: {
		withFallbackImage() {
			return this.picture ? this.picture : require('~/assets/img/product-image-not-found.jpg');
		},
		langActive() {
			return this.$i18n.locale;
		},
	},
	props: {
		id: [String, Number],
		type: String,
		name: String,
		price: Number,
		partial: Number,
		paid: Number,
		qty: Number,
		picture: String,
		date: {
			type: Object,
			default: () => ({ from: '', to: '' }),
		},
	},
	methods: {
		deleteProduct(id) {
			if (this.type == 'product') {
				this.$store.dispatch('shop/deleteProduct', id);
			} else {
				this.$store.dispatch('shop/deleteService', id);
			}
		},
		asyncUpdateProduct(value, id) {
			this.$store.dispatch('shop/updateProduct', {
				id: id,
				value: value,
				lang: this.langActive,
			});
		},
	},
	data() {
		return {
			value: this.qty,
			payed: this.paid || 0,
		};
	},
	watch: {
		payed(value, old) {
			this.$store.dispatch('shop/updatePayedCurrency', {
				id: this.id,
				currency: value,
			});
		},
	},
};
</script>

<style lang="postcss">
.mxp-cart {
	@apply flex w-full relative;
	padding: 2.5rem 0;
	&__destroy {
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 0 3rem;
		@media (min-width: 1025px) {
			padding: 0 5rem;
		}
		border-right: 1px solid #b3b3b3;
		z-index: 10;
	}
	&__button {
		transition: 300ms ease-in-out;
		&:hover {
			color: tomato;
		}
	}
	@media (max-width: 768px) {
		svg {
			@apply w-[1.8rem] z-[10];
		}
	}
	@media (max-width: 767px) {
		&__destroy {
			/*display: none;*/
			@apply absolute top-[1.4rem] right-[1.4rem] border-none px-0;
		}
	}
	@media screen(xl) {
		padding: 0;
		border-bottom: 1px solid #b3b3b3;
	}
	@media screen(monitor) {
	}
}

.ctproduct {
	--width-cart-picture: 8.4rem;
	@apply flex items-center gap-x-[1.8rem] flex-wrap relative w-full;
	@media (min-width: 768px) {
		@apply pl-[3rem];
	}
	&__image {
		width: var(--width-cart-picture);
		height: var(--width-cart-picture);
		flex-shrink: 0;
		img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			object-position: center;
		}
	}
	&__content {
		width: 58%;
	}
	@media screen(xl) {
		--width-cart-picture: 12rem;
		padding: 4rem;
		&.service {
			padding-bottom: 1.5rem;
		}
	}
	@media screen(monitor) {
		--width-cart-picture: 17.5rem;
		@apply gap-x-[3rem];
	}
}
.\@product {
	&__name {
		font-size: 2.1rem;
		@apply lg:text-[2rem] design:text-[2.5rem] monitor:text-[3.2rem];
	}
	&__price {
		display: flex;
		justify-content: space-between;
		padding: 1.8rem 0;
		.\@price {
			font: normal 700 2.8rem / 1 'EBGaramond';
			@apply text-primary;
		}
	}
	&__selectable {
		width: 100%;
		padding-top: 0.5rem;
		@media (min-width: 768px) {
			@apply w-[70%] pt-[1.5rem];
		}
		@media (min-width: 960px) {
			@apply w-full pt-[2.5rem];
		}
	}
	@media (min-width: 1025px) {
		&__name {
			max-width: 24ch;
		}
		&__selectable {
			@apply !py-0;
			position: relative;
			left: calc(var(--width-cart-picture) + 2rem);
			right: 0;
			top: -1rem;
			width: initial;
		}
	}
}
</style>
