<template>
	<div>
		<h2>{{ error.statusCode }}</h2>
		<h1>{{ error.message }}</h1>
	</div>
</template>

<script>
export default {
	name: 'ErrorPageTemplate',
	layout: 'error',
	props: {
		error: {
			type: Object,
			default: () => ({}),
		},
	},
};
</script>
