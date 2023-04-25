import { createApp } from 'vue';
// @ts-ignore
import { SetupCalendar, Calendar, DatePicker } from 'v-calendar';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import App from './App.vue';
import { router } from '@/router';
import '@/assets/main.scss';
import 'primevue/resources/themes/md-dark-deeppurple/theme.css';
import 'primevue/resources/primevue.css';
import 'primeicons/primeicons.css';

import ViewIcon from '@component/atoms/ViewIcon.vue';
import TextField from '@component/atoms/TextField.vue';
import FileReader from '@component/atoms/FileReader.vue';
import ModuleOverlay from '@component/atoms/ModuleOverlay.vue';
import BrandLogo from '@component/atoms/BrandLogo.vue';

const app = createApp(App);

app.component('ViewIcon', ViewIcon);
app.component('TextField', TextField);
app.component('FileReader', FileReader);
app.component('ModuleOverlay', ModuleOverlay);
app.component('BrandLogo', BrandLogo);

app.component('VueCalendar', Calendar);
app.component('VueDatePicker', DatePicker);

app.use(createPinia());
app.use(PrimeVue);
app.use(SetupCalendar, {});

app.directive('click-outside', {
	mounted(el, binding, vnode) {
		el.clickOutsideEvent = function (event) {
			if (!(el === event.target || el.contains(event.target))) {
				binding.value(event, el);
			}
		};
		document.body.addEventListener('click', el.clickOutsideEvent);
	},
	unmounted(el) {
		document.body.removeEventListener('click', el.clickOutsideEvent);
	},
});

app.use(router).mount('#bookly__root');
