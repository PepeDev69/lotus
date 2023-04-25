<script setup>
import AdminNavigation from '@component/organisms/AppHeader.vue';
import AppBanner from '@component/molecules/AppBanner.vue';
import { useMainStore } from '@/stores/main';
import { onMounted } from 'vue';

const main = useMainStore();
onMounted(async () => {
	await main.mainFetch();
});
</script>

<template>
	<AdminNavigation />
	<div id="root--layout">
		<AppBanner id="root--layout__head"/>
		<div id="root--layout__body">
			<RouterView v-slot="{ Component }">
				<template v-if="Component">
					<Transition name="route" mode="out-in">
						<Suspense timeout="0">
							<component :is="Component"></component>
							<template #fallback> Loading... </template>
						</Suspense>
					</Transition>
				</template>
			</RouterView>
		</div>
	</div>
</template>

<style lang="scss">
:root {
	--root-head-height: 6rem;
}
#bookly__root {
	background-color: var(--ts-darkest);
	display: flex;
	min-height: 100vh;
}

#root--layout {
	width: 100%;
	max-height: 100vh;
	&__head {
		height: var(--root-head-height);
	}
	&__body {
		max-height: calc(100vh - var(--root-head-height));
		overflow: hidden auto;
	}
}
</style>
