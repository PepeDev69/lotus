<template>
	<div class="ctnTitleArticle">
		<h3 v-if="subtitle" class="ctnTitleArticle__subtitle">{{ subtitle }}</h3>
		<h2 class="ctnTitleArticle__title">
			{{ title }}
		</h2>
	</div>
</template>

<script>
export default {
	props: {
		title: String,
		subtitle: String,
	},
};
</script>
<style lang="postcss">
.ctnTitleArticle {
	@apply w-full flex flex-col;
	&__title {
		/* font-family: "Cormorant Garamond", serif; */
		@apply font-bold leading-none text-[3rem] text-primary tracking-[0.015em];
	}
	@media screen(xl) {
		&__title {
			@apply text-[2.5rem];
		}
	}
	@media screen(monitor) {
		&__title {
			@apply text-[3.6rem];
		}
	}
}
</style>
