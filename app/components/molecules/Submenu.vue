<template>
	<ul class="submenu">
		<li>
			<!-- bucle for -->
			<NuxtLink to="/">
				<Titles class="submenu__title" title="Tratamiento Laser" tag="h3" />
			</NuxtLink>
			<ul>
				<!-- bucle for -->
				<li class="submenu__item">
					<div class="submenu__icon"></div>
					<NuxtLink to="/" class="submenu__link">Depilacion</NuxtLink>
				</li>
			</ul>
		</li>
	</ul>
</template>

<script>
export default {
	name: "Submenu",
};
</script>

<style lang="postcss">
.submenu {
	box-shadow: 0 0 10px rgb(0 0 0 / 0.3);
	@apply bg-white rounded-2xl px-[7.6rem] pt-28 pb-[3.2rem] flex max-w-fit justify-between;
}

.submenu__title {
	.title-general {
		@apply text-[1.7rem] tracking-[0.03em] uppercase font-medium mb-[1.7em] inline-block;
		&::after {
			content: "";
			border-bottom: 1.5px solid;
			transform: scaleX(0);
			transform-origin: 0% 50%;
			transition: transform 0.3s ease-in-out;
			@apply block border-primary mt-[.2em];
		}
		&:hover::after {
			transform: scaleX(1);
		}
	}
}

.submenu__item {
	@apply text-[1.7rem] flex items-center cursor-pointer mb-[1.5em];

	.submenu__link {
		transition: color 0.3s ease-in-out;
		@apply leading-none ml-[0.6em] text-gray-600 tracking-[0.02em] font-medium;
	}
	.submenu__icon {
		border: 1px solid;
		border-radius: 50%;
		@apply bg-white border-primary w-[.625em] h-[.625em] grid place-items-center;
		&::before {
			content: "";
			transition: background-color 0.3s ease-in-out;
			border-radius: 50%;
			@apply h-[.325em] w-[.325em] bg-white block;
		}
	}
	&:hover {
		.submenu__link {
			@apply text-primary;
		}
		.submenu__icon::before {
			@apply bg-primary;
		}
	}
}
</style>
