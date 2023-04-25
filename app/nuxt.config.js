import path from 'path';
import { sortRoutes } from '@nuxt/utils';
import messages from './messages';

export default {
	server: {
		port: 3001,
	},
	head: {
		meta: [{ charset: 'utf-8' }, { name: 'viewport', content: 'width=device-width, initial-scale=1' }],
	},
	css: [
		'@/assets/css/swiper.css',
		'@/assets/css/theme.pcss',
		'@/assets/css/icons.css',
		'@/assets/css/typos.css',
		'@/assets/css/base.css',
		'@/assets/css/module.pcss',
		'@/assets/css/vendor.pcss',
	],
	plugins: [
		'@/plugins/components.js',
		'@/plugins/i18n.js',
		'@/plugins/swiper.plugin.js',
		'@/plugins/filters.js',
		{ src: '@/plugins/v-calendar.js', ssr: false },
	],
	buildModules: ['@nuxt/postcss8', '@nuxtjs/pwa'],
	modules: ['@nuxtjs/i18n'],
	i18n: {
		detectBrowserLanguage: false,
		locales: [
			{
				code: 'es',
				name: 'ESP',
			},
			{
				code: 'en',
				name: 'ENG',
			},
		],
		defaultLocale: 'es',
		vueI18n: {
			fallbackLocale: 'es',
			messages,
		},
	},
	router: {
		extendRoutes(routes, resolve) {
			routes.push(
				{
					path: '/:shop(services|products)',
					component: path.resolve(__dirname, 'shop/index.vue'),
					name: 'shop',
				},
				/** For PRODUCTS */
				{
					path: '/:shop(products)/:category',
					component: path.resolve(__dirname, 'shop/_category/index.vue'),
					name: 'product-category',
				},
				{
					path: '/:shop(products)/:category/:slug',
					component: path.resolve(__dirname, 'shop/_category/_slug.vue'),
					name: 'product-category-slug',
				},
				/** for Service category  */
				{
					path: '/:shop(services)/:category/:subcategory/',
					component: path.resolve(__dirname, 'shop/_category/index.vue'),
					name: 'service-category',
				},
				{
					path: '/:shop(services)/:category/:subcategory/:slug',
					component: path.resolve(__dirname, 'shop/_category/_slug.vue'),
					name: 'service-category-slug',
				}
			);
			sortRoutes(routes);
		},
	},
	build: {
		standalone: true,
		extractCSS: true,
		extend(config, { isClient }) {
			config.devtool = process.env.NODE_ENV == 'production' ? '' : 'source-map';
		},
		babel: {
			presets({ envName }) {
				const envTargets = {
					client: {
						browsers: ['> 1%', 'last 2 versions', 'not dead', 'not op_mini all'],
					},
					server: { node: '13.13.0' },
				};
				return [
					[
						'@nuxt/babel-preset-app',
						{
							targets: envTargets[envName],
							corejs: { version: 3.21 },
						},
					],
				];
			},
		},
		postcss: {
			plugins: {
				'postcss-import': {},
				autoprefixer: {},
				'tailwindcss/nesting': {},
				'postcss-nested': {},
				tailwindcss: path.resolve(__dirname, './tailwind.config.cjs'),
			},
		},
		loaders: {
			cssModules: {
				modules: {
					localIdentName: 'm--[local]-[hash:base32:4]',
				},
			},
		},
		transpile: ['axios', 'swiper', 'vue-awesone-swiper', 'v-calendar'],
	},
};
