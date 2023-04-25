<template>
	<div class="ctn-info">
		<Titles :tag="titleTag" :title="title" />
		<div v-if="tag" v-html="text"></div>
		<div v-else>
			<p class="text___and textGeneral">
				{{ splited(text, 0) }} <br />
				<span v-if="splited(text, 1)"> {{ splited(text, 1) }} </span>
			</p>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		title: {
			type: String,
			default: '',
		},
		text: {
			type: String,
			default: '',
		},
		titleTag: String,
	},
	computed: {
		tag() {
			return this.text.includes('</p>');
		},
		splited() {
			return (str, offset) => {
				return str.split('/')[offset];
			};
		},
	},
};
</script>

<style lang="postcss">
.ctn-info {
	p {
		@apply mb-[1rem]  last:mb-[0] first:mt-[2rem];
	}
	@screen laptop {
		p {
			@apply mb-[1.5rem];
		}
	}
}
</style>
