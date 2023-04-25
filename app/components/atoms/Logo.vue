<template>
	<NuxtLink :to="localePath({ name: 'index' })">
		<figure class="logoGeneral">
			<img class="imgLogo" :src="image" alt="Logo" />
		</figure>
	</NuxtLink>
</template>

<script>
export default {
	props: {
		image: String,
	},
};
</script>

<style lang="postcss">
.logoGeneral {
	@apply overflow-hidden;
	.imgLogo {
		@apply w-full object-cover;
	}
}
</style>
