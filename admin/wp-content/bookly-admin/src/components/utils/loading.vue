<script setup lang="ts">
defineProps<{
	loading: boolean;
	top?: boolean
}>();
</script>

<template>
	<div v-if="loading" class="inset t-absolute t-abs-center tx-loader" :class="{ top }">
		<div>
			<span class="loader loader-quart-4"></span>
		</div>
	</div>
</template>

<style lang="scss">
.tx-loader {
	height: 100vh;
	&.top {
		height: 50vh;
	}
}
.loader {
	width: 50px;
	height: 50px;
	display: inline-block;
	vertical-align: middle;
	position: relative;
}
.loader-quart-4 {
	border-radius: 50px;
	border: 5px solid var(--ts-primary);
	box-sizing: content-box;
}

.loader-quart-4:after {
	content: "";
	position: absolute;
	top: -5px;
	left: -5px;
	right: -5px;
	bottom: -5px;
	border: 5px solid var(--ts-primary);
	border-radius: 25px;
	animation: rotation 1s linear infinite;
}

@keyframes rotation {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
</style>
