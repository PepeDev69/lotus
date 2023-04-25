import { mapState } from 'vuex';
export default {
	computed: {
		...mapState({
			meta: state => state.siteMeta,
			poly: state => state.polylang,
		}),
	},
	head() {
		const data = {
			title: 'Lotus Estetic',
			htmlAttrs: {
				class: this.overflow,
			},
			script: [
				{
					src: `https://www.googletagmanager.com/gtag/js?id=${this.meta.google_analitics}`,
					async: true,
					hid: 'gtag',
				},
				{
					vmid: 'script_tag',
					hid: 'script_tag',
					innerHTML: `
						window.dataLayer = window.dataLayer || [];
                        function gtag(){
							dataLayer.push(arguments);
						}
                        gtag('js', new Date());
                        gtag('config', '${this.meta.google_analitics}');
					`,
				},
				{
					src: 'https://connect.facebook.net/en_US/fbevents.js',
					async: true,
					innerHTML: `
					!function(f) {
						if (f.fbq) return;
						var n = f.fbq = function() {
							n.callMethod ?
								n.callMethod.apply(n, arguments) : n.queue.push(arguments)
						};
						if (!f._fbq) f._fbq = n;
						n.push = n;
						n.loaded = !0;
						n.version = '2.0';
						n.queue = [];
					}(window);
					fbq('init', '${this.meta.facebook_id}');
					fbq('track', 'PageView');`,
				},
				{
					src: `https://www.paypal.com/sdk/js?client-id=${this.meta.paypal_credentials}&locale=en_US`,
					defer: true,
					hid: 'paypal',
				},
				// {
				// 	vmid: 'button-io',
				// 	hid: 'button-io',
				// 	innerHTML: `
				// 		!function() {
				// 			var options = {
				// 				facebook: "825764917801081",
				// 				sms: "510 916-8664",
				// 				call_to_action: "${this.poly.call_to_action_message}",
				// 				button_color: "#243d42",
				// 				position: "right",
				// 				order: "whatsapp,facebook",
				// 			};
				// 			var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
				// 			var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
				// 			s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
				// 			var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
				// 		}();
				// 	`,
				// 	// innerHTML: `
				// 	// 	!function() {
				// 	// 		var options = {
				// 	// 			facebook: "825764917801081",
				// 	// 			whatsapp: "510 916-8664",
				// 	// 			call_to_action: "${this.poly.call_to_action_message}",
				// 	// 			button_color: "#243d42",
				// 	// 			position: "right",
				// 	// 			order: "whatsapp,facebook",
				// 	// 		};
				// 	// 		var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
				// 	// 		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
				// 	// 		s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
				// 	// 		var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
				// 	// 	}();
				// 	// `,
				// },
			],

			__dangerouslyDisableSanitizers: ['innerHTML'],
		};
		return data;
	},
	beforeMount() {
		this.$store.dispatch({
			type: 'shop/shopCartMount',
		});
	},
	created() {
		this.$nuxt.$on('overflow', ({ type }) => {
			this.overflow = type;
		});
	},
	data: () => ({
		overflow: '',
	}),
};
