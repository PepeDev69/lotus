<template>
	<a v-if="isExternalLink" v-bind="$attrs" :href="to" target="_blank">
		<slot />
	</a>
	<NuxtLink v-else :to="withFallbackPath" custom v-slot="{ isActive, isExactActive, href, navigate }">
		<a
			v-bind="$attrs"
			:href="href"
			@click="routeGuards($event, navigate)"
			:class="{ 'current-active': isActive, 'exact-current': isExactActive }"
		>
			<slot />
		</a>
	</NuxtLink>
</template>

<script>
export default {
	name: 'AppLink',
	props: {
		inactiveClass: String,
		prevent: Boolean,
		to: {
			type: [Object, String],
			default: () => {},
		},
	},
	computed: {
		isExternalLink() {
			return typeof this.to === 'string' && this.to.startsWith('http');
		},
		withFallbackPath() {
			return typeof this.to == 'string' ? this.to : this.localePath(this.to);
		},
	},
	methods: {
		routeGuards(event, next) {
			this.prevent && event.preventDefault();
			next(event);
		},
	},
};
</script>
