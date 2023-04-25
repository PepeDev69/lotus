import DashboardScreen from '@/views/DashboardScreen.vue';
import DoctorsScreen from '@/views/DoctorsScreen.vue';
import ScheduleScreen from '@/views/ScheduleScreen.vue';
import ServicesScreen from '@/views/ServicesScreen.vue';
import { nextTick } from 'vue';
import { createRouter, createWebHashHistory, RouteLocationNormalized, RouteRecordRaw } from 'vue-router';

const routes = [
	{
		path: '/',
		name: 'home',
		meta: { title: 'Bookly - Home' },
		component: DashboardScreen,
	},
	{
		path: '/doctor',
		name: 'doctor',
		meta: { title: 'Bookly - Especialists' },
		component: DoctorsScreen,
	},
	{
		path: '/schedule/:date?',
		name: 'schedule',
		meta: { title: 'Bookly - Appoinments' },
		component: ScheduleScreen,
	},
	{
		path: '/services',
		name: 'services',
		meta: { title: 'Bookly - Services' },
		component: ServicesScreen,
	},
	{
		path: '/customers',
		name: 'customers',
		meta: { title: 'Bookly - Customers' },
		component: ServicesScreen,
	},
] as RouteRecordRaw[];

export const router = createRouter({
	history: createWebHashHistory(),
	routes,
});

router.afterEach((to: RouteLocationNormalized, from: RouteLocationNormalized) => {
	nextTick(() => {
		document.title = (to.meta.title as string) || 'Bookly - Admin';
	});
});
