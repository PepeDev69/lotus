<template>
	<ul :class="['socials', type]" v-if="items">
		<li class="icon__social" v-for="(social, index) in items" :key="index">
			<a
				:class="`icon-${type}-${social.type}`"
				:href="social.url ? social.url : '#'"
				:title="social.url ? social.type : 'Coming Soon'"
				:target="social.url ? '_blank' : ''"
			/>
		</li>
	</ul>
</template>

<script>
export default {
	name: 'SocialIcons',
	props: {
		items: {
			type: Array,
			default: () => [],
		},
		type: {
			type: String,
			default: 'header', // enum { header, footer }
		},
	},
};
</script>

<style lang="postcss">
.socials {
	@apply flex;
}

.socials.header {
	@apply ml-[.5em] gap-[.5em];
	.icon__social {
		@apply w-[1.5625em] h-[1.5625em] bg-gray-900 rounded-full grid place-items-center;
	}

	a[class^='icon'] {
		@apply text-white text-[.875em];
	}
	a[class$='instagram'] {
		@apply text-[.75em];
	}
}

.socials.footer {
	@apply p-0 justify-start gap-[.8em] mt-[2rem];
	@media (min-width: 1200px) {
		@apply mt-[1em];
	}
	a[class^='icon'] {
		@apply text-white/80;
	}
}
</style>
