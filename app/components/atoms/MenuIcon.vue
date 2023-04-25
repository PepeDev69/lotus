<template>
	<div class="menu" :class="[type, { change: isActive }]">
		<span class="span"></span>
		<span class="span"></span>
		<span class="span"></span>
	</div>
</template>

<script>
export default {
	name: 'MenuIcon',
	props: {
		type: {
			type: String,
			default: 'hamburguer', //type=hamburguer tiene animacion y el type=close es una X fija
		},
		isActive: {
			type: Boolean,
			default: false, //cuando es true el menu hamburguer se activara (type=close no se anima)
		},
	},
};
</script>

<style lang="postcss">
.menu {
	--menu-size: 5.6rem;
	&.hamburguer {
		height: var(--menu-size);
		width: var(--menu-size);
		border-bottom-left-radius: 1rem;
		transition: background-color 0.4s ease;
		@apply bg-primary flex justify-center items-center relative cursor-pointer right-0 top-0;
		position: absolute;
		@screen design {
			@apply hidden;
		}

		.span {
			height: 0.2rem;
			width: 2.5rem;
			transition: 0.4s ease;
			transition-property: transform, top;
			@apply bg-white inline-block absolute mx-auto;
		}
		.span:nth-child(1) {
			transform: translateY(-0.8rem);
		}
		.span:nth-child(3) {
			transform: translateY(0.8rem);
		}
		/* Animacion cuando "isActive" es true */
		&.change {
			top: 0.5rem;
			background-color: rgb(255 194 11 / 0);
			.span:nth-child(1) {
				transform: rotateZ(42.19deg);
				@apply bg-primary;
			}

			.span:nth-child(2) {
				@apply opacity-0;
			}

			.span:nth-child(3) {
				transform: rotateZ(-42.19deg);
				@apply bg-primary;
			}
		}
	}

	&.close {
		width: var(--menu-size);
		height: var(--menu-size);

		@apply bg-transparent relative cursor-pointer flex justify-center items-center;
		@screen xl {
			@apply hidden;
		}
		.span {
			width: 2.6rem;
			height: 0.2rem;
			border-radius: 2px;
			@apply bg-white inline-block absolute;
		}

		.span:nth-child(1) {
			transform: rotateZ(42.19deg);
		}

		.span:nth-child(2) {
			@apply hidden;
		}

		.span:nth-child(3) {
			transform: rotateZ(-42.19deg);
		}
	}
	/* @media screen(lg) { */
	@media (min-width: 1025px) {
		&.hamburguer {
			display: none;
		}
	}
}
</style>
