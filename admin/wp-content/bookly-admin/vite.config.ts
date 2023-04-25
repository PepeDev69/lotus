import { defineConfig, splitVendorChunkPlugin, UserConfigExport } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

const viteConfig: UserConfigExport = {
	plugins: [vue(), splitVendorChunkPlugin()],
	optimizeDeps: {
		include: ['vue', 'pinia', 'axios', 'vue-router'],
	},
	css: {
		modules: {
			generateScopedName: '[local]--[hash:base64:4]',
		},
		preprocessorOptions: {
			scss: {
				additionalData: `
					@import "./src/assets/__functions.scss";
			  	`,
			},
		},
	},
	resolve: {
		alias: {
			vue: 'vue/dist/vue.esm-bundler.js',
			'@component': path.resolve(__dirname, './src/components'),
			'@service': path.resolve(__dirname, './src/services'),
			'@instance': path.resolve(__dirname, './src/instance'),
			'@': path.resolve(__dirname, './src'),
		},
	},
	server: {
		port: 3030,
	},
};

if (process.env.APP_ENV !== 'development') {
	viteConfig.build = {
		emptyOutDir: true,
		outDir: './../dist',
		manifest: true,
		rollupOptions: {
			input: path.resolve(__dirname, 'src', 'main.ts'),
		},
	};
	viteConfig.root = 'src';
}

export default defineConfig(viteConfig);
