<template>
	<Transition name="pop-up" appear>
		<div v-if="open" class="notify" :class="[css.flash, type]">
			<article class="relative immer" :data-in="open">
				<span :class="css.type">{{ type }}</span>
				<p>{{ message }}</p>
				<button @click="hideMessage" aria-label="Close panel" class="text-gray-500 absolute top-0 right-0" style="outline: none">
					<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</article>
		</div>
	</Transition>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'NotifyToast',
	computed: {
		...mapState('event', ['type', 'open', 'message']),
	},
	methods: {
		hideMessage() {
			this.$store.dispatch('event/hideEventMessage');
		},
		toastMessage() {
			this.$store.dispatch('event/hideEventMessage');
		},
	},
};
</script>

<style lang="postcss" module="css">
.flash {
	font: normal 400 1.6rem / 1.25 var(--font-rubik);
	border: 1px solid rgba(25, 157, 228, 0.508);
	border-left: 0.4em solid #199de4;
	box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.15);
	@apply bg-teal-50 fixed z-[101] top-[8vw] py-[.8em] px-[1em] right-[1.5vw] min-h-[2em] min-w-[25ch];
	&.error {
		@apply bg-rose-500 border-rose-200;
	}
	&.warning,
	&.aviso {
		border-color: #ffadb9;
		@apply bg-rose-100 border-l-rose-600;
	}
	p {
		font: inherit;
		@apply leading-snug;
		max-width: 28ch;
	}
	span,
	p {
		@apply block;
	}
	@media screen(lg) {
		font-size: calc(var(--p-font-size) - 1.5px);
	}
}

.type {
	@apply capitalize font-semibold mb-[0.5em] text-[1.1em];
	.error & {
		@apply text-rose-700;
	}
	.warning & {
		@apply text-rose-600;
	}
	.aviso & {
		@apply text-rose-600;
	}
}
</style>

<style lang="postcss">
.notify.error {
	@apply bg-rose-500 border-rose-200;
}
.notify.warning,
.notify.aviso {
	border-color: #ffadb9 !important;
	@apply bg-rose-100 border-l-rose-600;
}
</style>
