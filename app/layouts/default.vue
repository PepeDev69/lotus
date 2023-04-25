<template>
	<div class="__root">
		<NotifyToast />
		<AppHeader />
		<Nuxt />
		<AppFooter />
	</div>
</template>

<script>
import defaultMeta from '@/mixins/head.mixin';
import { mapState } from 'vuex';
export default {
	name: 'MainLayout',
	mixins: [defaultMeta],
	components: {
		NotifyToast: () => import('~/components/animation/NotifyToast.vue'),
		AppHeader: () => import('~/components/organisms/Header.vue'),
		AppFooter: () => import('~/components/organisms/Footer.vue'),
	},
	computed: {
		// ...mapState({
		// 	meta: state => state.siteMeta,
		// 	poly: state => state.polylang,
		// }),
		...mapState(['common', 'polylang']),
	},
	methods: {
		initGetButton() {
			const ctx = this;
			(function () {
				var options = {
					facebook: `${ctx.common.facebook_id}`, // Facebook page ID 825764917801081
					sms: `${ctx.common.phone}`, // Sms phone number
					// call_to_action: 'Message us',
					call_to_action: `${ctx.polylang.call_to_action_message}`, // Call to action
					button_color: '#243d42', // Color of button
					position: 'right', // Position may be 'right' or 'left'
					order: 'sms,facebook', // Order of buttons
				};
				var proto = 'https:',
					host = 'getbutton.io',
					url = proto + '//static.' + host;
				var s = document.createElement('script');
				s.type = 'text/javascript';
				s.async = true;
				s.src = url + '/widget-send-button/js/init.js';
				s.onload = function () {
					WhWidgetSendButton.init(host, proto, options);
				};
				var x = document.getElementsByTagName('script')[0];
				x.parentNode.insertBefore(s, x);
			})();
		},
	},
	beforeMount() {
		this.initGetButton();
	},
};
</script>

<style lang="postcss">
.__root {
	overflow: hidden;
	padding-top: var(--header-height);
}
</style>
