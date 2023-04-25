<template>
	<main id="main__content">
		<slot />
	</main>
</template>

<style lang="postcss">
#main__content {
	min-height: calc(100vh - 12rem);
}
</style>
