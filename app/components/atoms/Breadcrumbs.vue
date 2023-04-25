<template>
	<div class="whitespace-nowrap max-w-full">
		<ul class="ps-breadcrumb">
			<li class="ps-bread__link">
				<AppLink :to="{ name: 'index' }">{{ home }}</AppLink>
			</li>
			<li
				v-for="(link, index) in breadcrumbs"
				:key="index"
				class="ps-bread__link"
				:class="[
					`link-${index + 1}`,
					link.path === '/services' || link.path === '/en/services' || link.path === '/products' || link.path === '/en/products'
						? 'pointer-events-none'
						: 'pointer-events-auto',
				]"
			>
				<NuxtLink :to="link.path">
					{{ index === 0 ? titleModified : index === 1 ? termName : index === 2 ? productName : link.title }}
				</NuxtLink>
			</li>
		</ul>
	</div>
</template>

<script>
import { titleCase } from '@/functions/titleCase';
export default {
	name: 'NuxtBreadcrumbs',
	props: {
		home: {
			type: String,
		},
		titlePrin: String,
		termName: String,
		productName: String,
	},
	computed: {
		// titleModified() {
		// 	if (this.$route.params.shop === 'services' && this.$i18n.locale === 'es') {
		// 		return 'Servicios';
		// 	} else {
		// 		if (this.$route.params.shop === 'services' && this.$i18n.locale === 'en') {
		// 			return 'Services';
		// 		} else {
		// 			if (this.$route.params.shop === 'products' && this.$i18n.locale === 'es') {
		// 				return 'Productos';
		// 			} else {
		// 				if (this.$route.params.shop === 'products' && this.$i18n.locale === 'en') {
		// 					return 'Products';
		// 				} else {
		// 					return this.titlePrin;
		// 				}
		// 			}
		// 		}
		// 	}
		// },
		breadcrumbs() {
			const params = this.$route.fullPath.startsWith('/')
				? this.$route.fullPath
						.replace(/(\?.*|\#.*)/, '')
						.substring(1)
						.split('/')
				: this.$route.fullPath.replace(/(\?.*|\#.*)/, '').split('/');

			const meta = [];
			let path = '';

			params.forEach(param => {
				path = `${path}/${param}`;
				const match = this.$router.match(path);
				if (match.name !== null) {
					meta.push({
						title: titleCase(param.replace(/-/g, ' ')),
						...match,
					});
				}
			});
			this.$i18n.locale !== this.$i18n.defaultLocale && meta.shift();
			return meta;
		},
	},
	data() {
		return {
			titleModified: '',
		};
	},
	mounted() {
		// console.log(this.$i18n.locale);
		if (this.$route.params.shop === 'services' && this.$i18n.locale === 'es') {
			this.titleModified = 'Servicios';
		} else {
			if (this.$route.params.shop === 'services' && this.$i18n.locale === 'en') {
				this.titleModified = 'Services';
			} else {
				if (this.$route.params.shop === 'products' && this.$i18n.locale === 'es') {
					this.titleModified = 'Productos';
				} else {
					if (this.$route.params.shop === 'products' && this.$i18n.locale === 'en') {
						this.titleModified = 'Products';
					} else {
						this.titleModified = this.titlePrin;
					}
				}
			}
		}
	},
};
</script>

<style lang="postcss">
.ps-breadcrumb {
	font-size: calc(var(--p-font-size) + 1px);
	color: var(--primary);
	column-gap: 0.3em;
	display: flex;
	/* @apply whitespace-nowrap max-w-full; */
	@apply text-ellipsis;

	/* li:last-child {
		@apply text-ellipsis overflow-hidden;
	} */
}
.ps-bread__link {
	@apply flex items-center;
	&:not(:last-child)::after {
		content: '/';
		vertical-align: middle;
		padding-left: 0.4em;
	}
	a {
		font: normal 500 0.9em / 1 'Work-Sans';
		@apply text-ellipsis overflow-hidden block w-full;
	}
	a.nuxt-link-exact-active {
		pointer-events: none;
	}
	&.link-2,
	&.link-3 {
		@apply overflow-hidden;
	}
	/* &:last-child {
		@apply overflow-hidden;
	} */
}
</style>
