/// <reference types="vite/client" />

declare module '*.vue' {
	import type { DefineComponent } from 'vue';
	// eslint-disable-next-line @typescript-eslint/no-explicit-any, @typescript-eslint/ban-types
	const component: DefineComponent<{}, {}, any>;
	export default component;
}
interface ImportMetaEnv {
	readonly VITE_REST_URL: string;
	readonly VITE_SITE_URL: string;
}

interface ImportMeta {
	readonly env: ImportMetaEnv;
}

declare global {
	interface Window {
		webkitRequestAnimationFrame: any;
		mozRequestAnimationFrame: any;
		oRequestAnimationFrame: any;
		msRequestAnimationFrame: any;
		REST_URL: string;
	}
}
