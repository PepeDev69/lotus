<template>
	<ul>
		<li class="itemSocials" v-for="(social, index) in listSocials" :key="index">
			<span class="span" :title="social.url ? '' : 'Coming Soon'">
				<template>
					<a
						class="icon"
						:class="[
							'icon-' + type + '-' + social.type,
							social.url ? 'pointer-events-auto' : 'pointer-events-none',
						]"
						:href="social.url ? social.url : '#'"
						:target="social.url ? '_blank' : ''"
					>
					</a>
				</template>
			</span>
		</li>
	</ul>
</template>

<script>
export default {
	props: {
		listSocials: {
			type: Array,
			default: {},
		},
		type: String,
	},
};
</script>

<style lang="postcss">
.itemSocials {
	.span {
		@apply flex items-center justify-center;
	}
}
</style>
