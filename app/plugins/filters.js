import Vue from 'vue';

Vue.directive('click-outside', {
	bind: function (el, binding, vNode) {
		const bubble = binding.modifiers.bubble;
		const handler = e => {
			if (bubble || (!el.contains(e.target) && el !== e.target)) {
				binding.value(e);
			}
		};
		el.__vueClickOutside__ = handler;
		document.addEventListener('click', handler);
	},

	unbind: function (el, binding) {
		document.removeEventListener('click', el.__vueClickOutside__);
		el.__vueClickOutside__ = null;
	},
});

Vue.directive('scroll', {
	inserted: function (el, binding) {
		let f = function (event) {
			if (binding.value(event, el)) {
				window.removeEventListener('scroll', f);
			}
		};
		window.addEventListener('scroll', f, { passive: true });
	},
});

Vue.filter('currency', function (value) {
	const formatter = new Intl.NumberFormat('en-US', {
		style: 'currency',
		currency: 'USD',
	});
	return formatter.format(parseFloat(value || 0));
});

Vue.filter('date', function (value) {
	if (!value) return 'Today';

	const today = new Date(value);
	return today.toLocaleDateString('en-US', {
		day: 'numeric',
		month: 'long',
		year: 'numeric',
	});
});

Vue.filter('weekday', (value, locale) => {
	if (!value && isFinite(value)) return '';
	const date = new Date(value);
	return new Intl.DateTimeFormat(locale, { weekday: 'long', month: 'long', day: 'numeric' }).format(date);
});

Vue.filter('hour', (value, format = '') => {
	return new Date(value).toLocaleString('en', { hour: '2-digit', minute: 'numeric', hour12: true });
});
