<template>
	<div class="sw-lang" @click="toggleActive" :class="{ inactive: notActive }">
		<p class="sw-lang__main sw-lang__text">{{ currentLanguageName }}</p>
		<!-- <div class="sw-lang__arrow"></div> -->
		<ArrowMenu class="sw-lang__arrow" :class="{ inactive: notActive }" />
		<div class="sw-lang__switch" :data-active="isActive">
			<!-- <p
				v-for="item in locales"
				:key="item.code"
				class="sw-lang__option sw-lang__text"
				:class="[item.code === 'en' ? 'pointer-events-none cursor-auto' : 'pointer-events-auto']"
			>
				<NuxtLink :to="switchLocalePath(item.code)"> {{ item.name }} </NuxtLink>
			</p> -->
			<p v-for="item in locales" :key="item.code" class="sw-lang__option sw-lang__text">
				<NuxtLink :to="switchLocalePath(item.code)"> {{ item.name }} </NuxtLink>
			</p>
		</div>
	</div>
</template>

<script>
export default {
	name: 'SwitchLanguage',
	data() {
		return {
			isActive: false,
			notActive: false, // PONER EN "FALSO" PARA DESHABILITAR EL DOBLE IDIOMA
		};
	},
	computed: {
		currentLanguageName() {
			return this.$i18n.localeProperties.name;
		},
		locales() {
			return this.$i18n.locales.filter(i => i.code !== this.$i18n.locale);
		},
	},
	methods: {
		toggleActive() {
			this.isActive = !this.isActive;
		},
	},
	props: {
		main: {
			type: String,
			default: 'en',
		},
	},
};
</script>

<style lang="postcss">
.sw-lang {
	@apply flex relative ml-[1em] uppercase items-baseline gap-[.3em] cursor-pointer;
	@media (max-width: 1024px) {
		@apply ml-0;
	}
	&.inactive {
		@apply cursor-auto pointer-events-none;
	}
}

.sw-lang__arrow {
	transform: rotate(90deg);
	path {
		@apply !fill-[#7e7e7e];
	}
	/*&::after {
		content: '<';
		@apply inline-block text-primary;
	}*/
	&.inactive {
		@apply opacity-0;
	}
}

.sw-lang__switch {
	content: '';
	transition: opacity 0.3s ease-in-out;
	/* @apply absolute top-[115%] left-0 inline-block p-2 px-4 bg-gray-900 rounded-xl opacity-0 z-10; */
	@apply absolute top-[115%] left-0 inline-block p-2 px-4 bg-primary/[0.9] rounded-xl opacity-0 z-10;
	&[data-active='true'] {
		@apply opacity-100;
	}
}

.sw-lang__text {
	font-family: 'Roboto', sans-serif;
	@apply text-[1.0625em] font-normal text-gray-500 -tracking-tighter;
}

.sw-lang__option {
	@apply text-white;
}
</style>
