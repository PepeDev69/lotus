<template>
	<div class="@ps-service-wrap" @click="$emit('click')">
		<div class="@ps-service" v-if="date.from || date.to">
			<div class="@ps-service__date @ps-service-it">
				<svg width="19" height="19" viewBox="0 0 19 19" fill="none">
					<path
						d="M17.418 1.63294H13.6078V0.181437C13.6078 0.0816468 13.5262 0 13.4264 0H12.1563C12.0565 0 11.9749 0.0816468 11.9749 0.181437V1.63294H6.16887V0.181437C6.16887 0.0816468 6.08722 0 5.98743 0H4.71737C4.61758 0 4.53593 0.0816468 4.53593 0.181437V1.63294H0.725749C0.324319 1.63294 0 1.95725 0 2.35868V17.418C0 17.8194 0.324319 18.1437 0.725749 18.1437H17.418C17.8194 18.1437 18.1437 17.8194 18.1437 17.418V2.35868C18.1437 1.95725 17.8194 1.63294 17.418 1.63294ZM16.5108 16.5108H1.63294V7.89252H16.5108V16.5108ZM1.63294 6.35031V3.26587H4.53593V4.3545C4.53593 4.45429 4.61758 4.53593 4.71737 4.53593H5.98743C6.08722 4.53593 6.16887 4.45429 6.16887 4.3545V3.26587H11.9749V4.3545C11.9749 4.45429 12.0565 4.53593 12.1563 4.53593H13.4264C13.5262 4.53593 13.6078 4.45429 13.6078 4.3545V3.26587H16.5108V6.35031H1.63294Z"
						fill="#395D64"
					/>
				</svg>
				<span class="@ps-inner">
					<span>{{ date.from | weekday($i18n.locale) }}</span>
					<span class="@ps-inner__caption">Dia</span>
				</span>
			</div>
			<div class="@ps-service__time @ps-service-it">
				<span class="@ps-inner">
					<span>{{ date.from | hour }}</span>
					<span class="@ps-inner__caption">Hora</span>
				</span>
				<svg width="19" height="19" viewBox="0 0 19 19" fill="none">
					<path
						d="M18.6416 4.49881L15.3289 1.1633C15.11 0.945114 14.8137 0.822632 14.5049 0.822632C14.1961 0.822632 13.8999 0.945114 13.681 1.1633L1.93698 12.9111L0.864723 17.5469C0.827734 17.7164 0.829002 17.892 0.868435 18.0609C0.907867 18.2298 0.984468 18.3877 1.09264 18.5232C1.20081 18.6586 1.33783 18.7682 1.49367 18.8438C1.64952 18.9194 1.82025 18.9592 1.99341 18.9602C2.0741 18.9684 2.1554 18.9684 2.23608 18.9602L6.91449 17.8861L18.6416 6.14961C18.8594 5.93032 18.9816 5.63355 18.9816 5.32421C18.9816 5.01487 18.8594 4.7181 18.6416 4.49881ZM6.35015 16.8685L1.96519 17.79L2.96408 13.4821L11.7509 4.71364L15.137 8.10569L6.35015 16.8685ZM15.8932 7.28594L12.5071 3.8939L14.4711 1.93782L17.8007 5.32986L15.8932 7.28594Z"
						fill="#395D64"
					/>
				</svg>
			</div>
		</div>
		<div v-else class="@ps-new-service">
			<span>{{ polylang.title_define_date }}</span>
			<svg width="19" height="19" viewBox="0 0 19 19" fill="none">
				<path
					d="M18.6416 4.49881L15.3289 1.1633C15.11 0.945114 14.8137 0.822632 14.5049 0.822632C14.1961 0.822632 13.8999 0.945114 13.681 1.1633L1.93698 12.9111L0.864723 17.5469C0.827734 17.7164 0.829002 17.892 0.868435 18.0609C0.907867 18.2298 0.984468 18.3877 1.09264 18.5232C1.20081 18.6586 1.33783 18.7682 1.49367 18.8438C1.64952 18.9194 1.82025 18.9592 1.99341 18.9602C2.0741 18.9684 2.1554 18.9684 2.23608 18.9602L6.91449 17.8861L18.6416 6.14961C18.8594 5.93032 18.9816 5.63355 18.9816 5.32421C18.9816 5.01487 18.8594 4.7181 18.6416 4.49881ZM6.35015 16.8685L1.96519 17.79L2.96408 13.4821L11.7509 4.71364L15.137 8.10569L6.35015 16.8685ZM15.8932 7.28594L12.5071 3.8939L14.4711 1.93782L17.8007 5.32986L15.8932 7.28594Z"
					fill="#395D64"
				/>
			</svg>
		</div>
		<span class="msg-error" :class="[date.from || date.to ? 'hidden' : '']">{{ polylang.txt_date_not_selected }}</span>
	</div>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'DateSelectable',
	computed: {
		...mapState(['polylang']),
	},
	props: {
		date: {
			type: Object,
			default: () => ({ from: '', to: '' }),
		},
	},
};
</script>

<style lang="postcss">
.\@ps-service {
	display: flex;
	justify-content: space-between;
	padding: 1.8rem 1.6rem;
	border-radius: 0.5rem;
	border: 1px solid #395d64;
	column-gap: 1.5rem;
	cursor: pointer;
	transition: background 300ms ease-in-out;
	&-wrap {
		padding-bottom: 0.5rem;
		@media (min-width: 1200px) {
			@apply pb-[2.5rem];
		}
	}
	&.pro-empty {
		border: 1px dashed var(--primary);
		&__time {
			align-items: center;
		}
		.\@ps-inner,
		&__date {
			opacity: 0;
		}
	}
	&-it {
		display: inline-flex;
		gap: 1.5rem;
	}
	&:hover {
		background-color: hsla(190, 27%, 31%, 0.171);
	}
	&.not-active {
		border-color: red;
	}
}
.\@ps-inner {
	font: normal 400 var(--p-font-size) / 1 'Roboto';
	display: inline-flex;
	flex-direction: column;
	color: var(--gray);
	&__caption {
		font-size: 0.7em;
		padding: 0.5em 0;
		opacity: 0.5;
	}
	@media (min-width: 1025px) {
		font-size: calc(var(--p-font-size) - 4px);
	}
}
.\@ps-new-service {
	font: normal 500 calc(var(--p-font-size) - 2px) / 1 'Rubik', serif;
	border: 1px dashed var(--primary);
	padding: 0.9em 1em;
	gap: 1em;
	display: inline-flex;
	align-items: center;
	border-radius: 0.5rem;
	cursor: pointer;
	transition: background 300ms ease-in-out;
	&:hover {
		background-color: hsla(190, 27%, 31%, 0.171);
	}
}

.msg-error {
	@apply opacity-0 text-red-500 pointer-events-none ml-[.5em];
	font: ligth 300 var(--p-font-size) / 1 'Roboto';
	transition: opacity 300ms ease-in-out;
}
.not-active {
	.\@ps-new-service {
		border-color: red;
		@apply bg-red-600/[.2];
		span {
			@apply text-red-600;
		}
		path {
			fill: red;
		}
	}
	.msg-error {
		@apply opacity-100;
		transition: opacity 300ms ease-in-out;
	}
}
</style>
