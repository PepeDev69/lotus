import DashboardScreen from '@/views/DashboardScreen.vue';
import LoginPage from '@/views/LoginPage.vue';
import DoctorsScreen from '@/views/DoctorsScreen.vue';
import ScheduleScreen from '@/views/ScheduleScreen.vue';
import ServicesScreen from '@/views/ServicesScreen.vue';
import { nextTick } from 'vue';
import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';

const routes = [
	{
		path: '/',
		name: 'home',
		meta: { title: 'Bookly - Home' },
		component: DashboardScreen,
		// component: () => import('@/views/DashboardScreen.vue'),
	},
	{
		path: '/login',
		name: 'login',
		meta: { title: 'Bookly - Login to admin' },
		component: LoginPage,
		// component: () => import('@/views/DashboardScreen.vue'),
	},
	{
		path: '/doctor',
		name: 'doctor',
		meta: { title: 'Bookly - Especialists' },
		component: DoctorsScreen,
		// component: () => import('@/views/DoctorsScreen.vue'),
	},
	{
		path: '/schedule/:date?',
		name: 'schedule',
		meta: { title: 'Bookly - Appoinments' },
		component: ScheduleScreen,
		// component: () => import('@/views/ScheduleScreen.vue'),
	},
	{
		path: '/services',
		name: 'services',
		meta: { title: 'Bookly - Services' },
		component: ServicesScreen,
		// component: () => import('@/views/ServicesScreen.vue'),
	},
	{
		path: '/customers',
		name: 'customers',
		meta: { title: 'Bookly - Customers' },
		component: ServicesScreen,
		// component: () => import('@/views/ServicesScreen.vue'),
	},
] as RouteRecordRaw[];

export const router = createRouter({
	history: createWebHistory /*import.meta.env.VITE_BASE_ROUTER*/(),
	/*'lotus/admin/bookly/'*/
	routes,
});

router.afterEach((to, from) => {
	nextTick(() => {
		document.title = (to.meta.title as string) || 'Bookly - Admin';
	});
});
