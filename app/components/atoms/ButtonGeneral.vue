<template>
	<NuxtLink v-if="path" :to="withPath" class="btn-gral">
		<span>{{ text }}</span>
	</NuxtLink>
	<button v-else class="btn-gral">
		<span> {{ text }}</span>
	</button>
</template>

<script>
export default {
	props: {
		text: {
			type: String,
			default: '',
		},
		path: {
			type: [Object, String],
		},
	},
	computed: {
		withPath() {
			if (this.path instanceof Object && this.path.hasOwnProperty('name')) {
				return this.localePath(this.path);
			}
			return this.localePath({ name: 'index' });
		},
	},
};
</script>

<style lang="postcss">
.btn-gral {
	font-family: 'Rubik-Medium', sans-serif;
	transition: all 0.5s ease-in-out;
	span {
		@apply inline-block relative z-[2] leading-[1.2];
	}
	@apply cursor-pointer border-0 relative inline-block h-[4rem] rounded-[5px] leading-[4rem] px-[1.2em] text-[1.8rem] tracking-[0.015em];
	&.blue {
		@apply bg-primary text-white;
	}
	&.border {
		border: 1px solid;
		@apply border-primary text-primary  bg-[transparent];
		@screen lg {
			&:hover {
				@apply bg-primary text-white;
			}
		}
	}
	&.green {
		@apply bg-green-two text-white rounded-[1rem] overflow-hidden;
		font-family: 'Roboto', sans-serif;
		&:before {
			content: '';
			transition: all 0.5s ease-in-out;
			background: linear-gradient(180deg, #377885 0%, #395d64 100%);
			@apply absolute top-0 left-0 w-full h-full opacity-0;
		}
		@screen lg {
			&:hover {
				&:before {
					@apply opacity-100;
				}
			}
		}
	}
	@screen laptop {
		span {
			@apply text-[1.7rem];
		}
	}
}
</style>
