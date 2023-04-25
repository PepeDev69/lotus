<template>
	<div class="ctn-title">
		<component v-if="!withSubtitle" :is="tag" class="title-general" v-bind="$attrs">
			{{ title }}
		</component>
		<template v-else v-bind="$attrs">
			<h5 class="subtitle-general">{{ splited(title, 0) }}</h5>
			<h4 class="title-general">{{ splited(title, 1) }}</h4>
		</template>
	</div>
</template>

<script>
export default {
	props: {
		title: {
			type: String,
		},
		tag: {
			type: String,
			default: "h3",
		},
	},
	computed: {
		withSubtitle() {
			return String(this.title).includes("/");
		},
		splited: () => (target, offset) => {
			return typeof target == "string" ? target.split("/")[offset] : target;
		},
	},
};
</script>

<style lang="postcss">
.title-general {
	@apply leading-none text-[5.5rem] text-primary tracking-[0.015em];
}
.subtitle-general {
	font-family: "Roboto-Medium", sans-serif;
	@apply inline-block uppercase leading-none text-[1.5rem] text-primary tracking-[0.1em] relative mb-[1.5rem] pr-[3rem];
	&:before {
		content: "";
		@apply absolute right-0 w-[1.7rem] h-[1px] top-0 bottom-0 bg-primary my-[auto];
	}
}
@screen laptop{
	.title-general {
		@apply text-[4.3rem];
	}
	.subtitle-general{
		&:before {
			@apply w-[1.5rem];
		}
	}
}
@screen mobile{
	.title-general {
		@apply text-[3.2rem];
	}
}
</style>
