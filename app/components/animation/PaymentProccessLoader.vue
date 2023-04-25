<template>
	<div class="complete-loader" :class="{ open: open }">
		<article class="charger">
			<div class="sk-cube-grid">
				<div class="sk-cube sk-cube1"></div>
				<div class="sk-cube sk-cube2"></div>
				<div class="sk-cube sk-cube3"></div>
				<div class="sk-cube sk-cube4"></div>
				<div class="sk-cube sk-cube5"></div>
				<div class="sk-cube sk-cube6"></div>
				<div class="sk-cube sk-cube7"></div>
				<div class="sk-cube sk-cube8"></div>
				<div class="sk-cube sk-cube9"></div>
			</div>
			<h1 class="sk-title">Estamos procesando su compra ...</h1>
		</article>
	</div>
</template>

<script>
export default {
	name: "PaymentProccessLoader",
	props: {
		open: Boolean,
	},
};
</script>

<style lang="postcss">
.complete-loader {
	@apply fixed inset-0 bg-white z-[101] justify-center items-center flex pointer-events-none opacity-0
        transition-opacity duration-300;
	&.open {
		@apply opacity-100;
	}
}
.sk-cube-grid {
	width: 7rem;
	height: 7rem;
	margin: auto;
	position: relative;
	z-index: 102;
}
.sk-title {
	font: normal 500 calc(var(--p-font-size) + 3px)/ 1 'Rubik';
	@apply mt-[2em] text-primary;
}
.sk-cube-grid .sk-cube {
	width: 33%;
	height: 33%;
	float: left;
	animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
	background-color: var(--primary);
}
.sk-cube-grid .sk-cube1 {
	animation-delay: 0.2s;
}
.sk-cube-grid .sk-cube2 {
	animation-delay: 0.3s;
}
.sk-cube-grid .sk-cube3 {
	animation-delay: 0.4s;
}
.sk-cube-grid .sk-cube4 {
	animation-delay: 0.1s;
}
.sk-cube-grid .sk-cube5 {
	animation-delay: 0.2s;
}
.sk-cube-grid .sk-cube6 {
	animation-delay: 0.3s;
}
.sk-cube-grid .sk-cube7 {
	animation-delay: 0s;
}
.sk-cube-grid .sk-cube8 {
	animation-delay: 0.1s;
}
.sk-cube-grid .sk-cube9 {
	animation-delay: 0.2s;
}

@keyframes sk-cubeGridScaleDelay {
	0%,
	70%,
	100% {
		transform: scale3d(1, 1, 1);
	}
	35% {
		transform: scale3d(0, 0, 1);
	}
}
</style>
