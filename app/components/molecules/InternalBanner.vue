<template>
	<section class="inter-banner">
		<picture class="p-picture" v-if="image || imageMobile">
			<source media="(min-width: 62em)" :srcset="image" />
			<img :src="imageMobile" :alt="title" />
		</picture>
		<div v-else class="p-picture" />
		<AppContainer class="inter-content" variant="big">
			<h1 class="@mod-title inter-title">
				{{ title }}
			</h1>
			<Breadcrumbs :home="homeInicio" :titlePrin="title" :termName="termName" :productName="productName" />
		</AppContainer>
	</section>
</template>

<script>
export default {
	name: 'InternalBanner',
	components: {
		Breadcrumbs: () => import('@/components/atoms/Breadcrumbs.vue'),
	},
	props: {
		image: {
			type: [String, Boolean],
			default: '',
		},
		imageMobile: {
			type: [String, Boolean],
			default: '',
		},
		title: {
			type: String,
			default: '',
		},
		homeInicio: String,
		termName: String,
		productName: String,
	},
};
</script>

<style lang="postcss">
.inter-banner {
	@apply w-full flex items-end relative;
	height: var(--t-banner-height);
	.p-picture {
		@apply absolute top-0 left-0 w-full h-full overflow-hidden;
		img {
			@apply h-full object-cover w-full;
		}
		&:before {
			content: '';
			background: rgba(252, 235, 229, 0.8);
			@apply absolute inset-0;
		}
	}
	.inter-title {
		padding: 0.4rem 0;
		@apply lg:text-[4.3rem] design:text-[5.3rem] monitor:text-[6.5rem];
	}
}
.inter-content {
	@apply relative;
	z-index: 2;
	padding-bottom: 2rem;
	@media screen(lg) {
		padding-bottom: 2.1rem;
	}
	@media screen(design) {
		padding-bottom: 3.6rem;
	}
	@media screen(monitor) {
		padding-bottom: 4.5rem;
	}
}
</style>
