<template>
	<component :is="tag" :class="[css.section, styleModule]" class="section-ctn">
		<slot />
	</component>
</template>

<script>
export default {
	name: "AppContainer",
	props: {
		variant: {
			type: String,
			default: "",
		},
		tag: {
			type: String,
			default: "div",
		},
	},
	computed: {
		styleModule() {
			return this.variant ? this.css[this.variant] : "";
		},
	},
};
</script>

<style lang="postcss" module="css">
.section {
	@apply px-[3rem] mx-auto w-full;
	@media screen(lg) {
		@apply max-w-[88%] px-0;

	}
	@media screen(xl) {
		@apply max-w-[70%];
		&.big {
			@apply max-w-[80%];
		}
		&.extra {
			max-width: 90%;
		}
	}
	@media screen(xl) {
		@apply max-w-[75%];
		&.big {
			@apply max-w-[85%];
		}
	}
	@media screen(xxlg) {
		@apply max-w-[70%];
		&.big {
			@apply max-w-[80%];
		}
		&.extra {
			max-width: 84%;
		}
	}
}
</style>
