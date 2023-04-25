<template>
	<NuxtLink :to="localePath(path)" v-bind="$attrs" v-on="$listeners">
		<slot></slot>
	</NuxtLink>
</template>

<script>
export default {
	name: "RouterLink",
	props: {
		path: {
			type: Object,
			default: () => {},
		},
	},
};
</script>
