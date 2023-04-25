<script setup lang="ts">
import { user, date, services, customers, home } from '@component/atoms/icons';
import { ref } from 'vue';
const RETURN_ADMIN_URL = ref(import.meta.env.BASE_URL);
console.log(import.meta.env);
</script>

<template>
	<header :class="css.head">
		<span :class="css.brand">
			<BrandLogo />
		</span>
		<nav :class="css.menu">
			<!-- <RouterLink :class="css.link" class="hs-lk" :to="{ name: 'home' }" aria-label="Inicio">
				<ViewIcon :icon="home" />
			</RouterLink> -->
			<RouterLink :class="css.link" class="hs-lk" :to="{ name: 'doctor' }" aria-label="Especialistas">
				<ViewIcon :icon="user" />
			</RouterLink>
			<RouterLink :class="css.link" class="hs-lk" :to="{ name: 'schedule' }" aria-label="Appoinemnts">
				<ViewIcon :icon="date" />
			</RouterLink>
			<RouterLink :class="css.link" class="hs-lk" :to="{ name: 'services' }" aria-label="Servicios">
				<ViewIcon :icon="services" />
			</RouterLink>
			<!-- <RouterLink :class="css.link" class="hs-lk" :to="{ name: 'customers' }" aria-label="Clientes">
				<ViewIcon :icon="customers" />
			</RouterLink> -->
		</nav>
		<a :href="RETURN_ADMIN_URL" :class="css.btn_return">
			<svg fill="none" viewBox="0 0 24 24">
				<path
					fill="currentColor"
					d="M18 6h2v12h-2V6Zm-2 5H7.414l4.293-4.293-1.414-1.414L3.586 12l6.707 6.707 1.414-1.414L7.414 13H16v-2Z"
				/>
			</svg>
		</a>
	</header>
</template>

<style lang="scss" module="css">
.head {
	border-right: 1px solid var(--ts-grey-800);
	min-height: 100vh;
	padding: 2rem 1.3rem;
	background-color: var(--ts-grey-900);
	display: flex;
	flex-direction: column;
}
.brand {
	display: inline-flex;
	width: 100%;
	align-items: center;
	justify-content: center;
	margin-bottom: 2.5rem;
	svg {
		width: 4.5rem;
		height: 4.5rem;
	}
}
.menu {
	display: flex;
	align-items: center;
	flex-direction: column;
	row-gap: 1.5rem;
	.link {
		display: inline-flex;
		align-items: center;
		cursor: pointer;
		padding: 1.1rem;
		background-color: var(--ts-grey-800);
		transition: all 300ms ease-in-out;
		border-radius: 3px;
		border: 1px solid transparent;
		color: #9b9fa3;
		position: relative;
		z-index: 2;
		svg {
			width: 2.8rem;
			height: 2.8rem;
		}
		&:hover,
		&[aria-current='page'] {
			background-color: var(--ts-grey-900);
			border-color: #398edd8c;
		}
		&:hover::after {
			opacity: 1;
			transform: translateY(0);
		}
		&::after {
			content: attr(aria-label);
			position: absolute;
			font: normal 600 calc(var(--ts-font-size) - 1px) / 1 var(--font);
			letter-spacing: 0.06em;
			left: 150%;
			text-transform: uppercase;
			background-color: var(--ts-grey-800);
			padding: 0.6em 1em;
			border-radius: 0.4rem;
			z-index: 1;
			opacity: 0;
			transform: translateY(0.5em);
			transition: opacity 250ms ease-in-out, transform 250ms ease-in-out;
			box-shadow: 0px 0px 14px 1px rgba(0, 0, 0, 0.65);
			pointer-events: none;
		}
	}
}
.btn_return {
	margin-top: auto;
	margin-bottom: 1rem;
	color: var(--ts-grey-600);
	padding: 0.6rem;
	border-radius: 0.5rem;
	border-radius: 0.5rem;
	display: inline-flex;
	&:hover {
		background-color: var(--ts-grey-700);
	}
	svg {
		width: 3rem;
		height: 3rem;
	}
}
</style>

<style lang="scss">
.today {
	fill-rule: evenodd;
	clip-rule: evenodd;
}
.hs-lk {
	&.router-link-active {
		background-color: var(--ts-grey-900);
		border-color: #398edd8c;
	}
}
</style>
