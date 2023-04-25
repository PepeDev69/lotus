<template>
	<svg
		:width="icon.with"
		:height="icon.height"
		:fill="icon.fill"
		:viewBox="`0 0 ${icon.width} ${icon.height}`"
		:data-icon="icon.name"
	>
		<path
			v-for="(path, i) in icon.paths"
			:key="i"
			:d="path.path"
			:fill="path.fill"
			:class="path.class"
		/>
	</svg>
</template>

<script>
export default {
	name: "ViewIcon",
	props: {
		icon: {
			type: Object,
			default: {
				name: "icon",
				width: 15,
				height: 15,
				fill: "none",
				paths: [{ fill: "red", path: "50C8.08" }],
			},
		},
	},
};
</script>
