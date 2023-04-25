<template>
	<button
		type="button"
		:class="[css.fancy, loading && css.loading, disable && css.disable]"
		:disabled="disable"
		:data-current="current"
		v-on="$listeners"
	>
		<svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" fill="none" viewBox="0 0 13 12">
			<path
				fill="currentColor"
				d="M5.992 12A5.989 5.989 0 0 1 0 5.992 5.99 5.99 0 0 1 6.01 0a5.999 5.999 0 0 1 5.992 6.01A5.988 5.988 0 0 1 5.992 12Zm0-1.087a4.922 4.922 0 0 0 4.922-4.931C10.912 3.29 8.705 1.089 6.01 1.088a4.916 4.916 0 0 0-4.92 4.905c-.004 2.709 2.2 4.921 4.904 4.92Z"
			/>
			<path
				fill="currentColor"
				d="M5.45 4.356V2.924c0-.479.192-.742.545-.746.352-.005.557.262.557.734 0 .878.004 1.756-.003 2.634a.507.507 0 0 0 .168.401c.416.404.824.816 1.231 1.228.278.28.304.6.074.835-.236.244-.564.219-.853-.069-.496-.493-.986-.99-1.485-1.48a.742.742 0 0 1-.236-.57c.006-.512.002-1.024.002-1.535Z"
			/>
		</svg>
		{{ text }}
	</button>
</template>

<script>
export default {
	name: 'FancyButton',
	props: {
		loading: {
			type: Boolean,
			default: false,
		},
		text: {
			type: String,
			default: '',
		},
		disable: {
			type: Boolean,
			default: false,
		},
		current: Boolean,
	},
};
</script>

<style lang="postcss" module="css">
.fancy {
	font: normal 400 1.5rem /1 'Roboto';
	padding: 0.2em 0.7em;
	height: 2em;
	display: inline-flex;
	column-gap: 0.3em;
	justify-content: center;
	align-items: center;
	border: 2px solid var(--primary);
	color: var(--primary);
	border-radius: 5px;
	cursor: pointer;
	background-color: transparent;
	transition: 400ms ease-in-out;
	transition-property: opacity, background, color;
	position: relative;
	&::before {
		transition: inherit;
		opacity: 0;
		pointer-events: none;
		content: '';
		position: absolute;
		top: 50%;
		width: 105%;
		transform: rotate(-11deg);
		background-color: #395d64;
		height: 2px;
	}
	svg {
		color: var(--primary);
	}
	@media screen(lg) {
		font-size: calc(var(--p-font-size) - 2px);
	}
}
.fancy:hover,
.fancy[data-current]:not([disabled]) {
	background-color: var(--primary);
	color: var(--white);
	svg {
		color: var(--white);
	}
}

.disable {
	opacity: 0.6;
	pointer-events: none;
	&::before {
		opacity: 1;
	}
}
</style>
