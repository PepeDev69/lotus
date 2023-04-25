<template>
	<ClientOnly>
		<AppModalScreen @close="$emit('cancel')">
			<div class="t-modal inset-0">
				<div class="mx-card">
					<div class="mx-card--head">
						<h3>{{ polylang.title_appointment_booking }}</h3>
						<p>{{ polylang.content_appointment_booking }}</p>
					</div>
					<div class="mx-card--body">
						<div class="mx-card--left">
							<VDatePicker
								v-model="date"
								:masks="masks"
								:min-date="dateTomorrow"
								:disabled-dates="{ weekdays: [1] }"
								:model-config="{
									type: 'string',
									mask: 'YYYY-MM-DD',
								}"
								:locale="$i18n.locale"
								:is-required="true"
							/>
						</div>
						<div class="mx-card--right">
							<div class="calendar-turns">
								<section class="calendar-turns-before">
									<h3 class="c-turn-title">
										<svg width="24" height="20" fill="none" viewBox="0 0 24 20">
											<path
												fill="#395D64"
												d="M16.993 15.29c.104-3.002-2.224-5.35-5.144-5.284-2.842.064-5.067 2.585-4.82 5.465.01.104.034.208.035.312a.843.843 0 0 1-.728.876.806.806 0 0 1-.908-.67c-.22-1.173-.06-2.315.373-3.416 1.199-3.052 4.475-4.8 7.62-4.081a6.684 6.684 0 0 1 5.228 6.987 3.52 3.52 0 0 1-.035.312c-.097.605-.461.937-.953.871-.49-.065-.752-.467-.695-1.085.016-.126.024-.247.027-.286Zm-5.039 4.704H4.83a2.044 2.044 0 0 1-.466-.018c-.417-.104-.675-.367-.678-.804 0-.46.26-.74.706-.832.154-.02.31-.024.466-.014h14.559c.559.02.924.358.915.847-.009.47-.36.794-.892.818h-.363l-7.122.003ZM11.15 2.846c-.37.384-.645.685-.936.97-.44.432-.921.473-1.283.123-.362-.35-.34-.85.085-1.282.768-.778 1.541-1.55 2.319-2.316.467-.459.882-.455 1.353.012.78.763 1.552 1.535 2.316 2.316.405.417.432.893.096 1.249-.336.356-.845.34-1.283-.075-.15-.143-.302-.287-.44-.442-.137-.155-.258-.324-.388-.487l-.154.068v2.146c0 .243.012.486 0 .729-.032.487-.385.823-.832.818a.819.819 0 0 1-.82-.833c-.017-.849 0-1.7-.005-2.548-.002-.104-.015-.203-.027-.448ZM2.018 15.83c-.276 0-.553.013-.833 0-.488-.027-.827-.367-.833-.816a.812.812 0 0 1 .808-.838c.57-.023 1.145-.023 1.71 0a.815.815 0 0 1 .813.835c-.007.45-.345.79-.833.816-.28.016-.558.004-.832.004Zm19.98-1.663c.276 0 .552-.014.832 0 .49.028.827.368.833.818a.818.818 0 0 1-.81.837 22.16 22.16 0 0 1-1.71 0 .816.816 0 0 1-.81-.836c.008-.453.343-.787.832-.814.28-.019.556-.005.833-.005ZM6.231 8.445c-.155.183-.294.505-.532.609-.237.104-.644.07-.849-.08a6.78 6.78 0 0 1-1.144-1.118c-.277-.324-.257-.712.017-1.04.275-.33.676-.428.974-.195.51.398.937.901 1.384 1.373.077.072.08.217.15.451Zm12.311.773c-.173-.14-.487-.276-.577-.5-.097-.246-.094-.652.051-.853.338-.435.726-.83 1.155-1.177.306-.26.682-.237 1.003.013.32.25.459.664.226.964-.406.52-.921.962-1.404 1.422-.076.07-.223.07-.454.131Z"
											/>
										</svg>
										<div class="c-turn-ftitle">
											<span class="@dayly">{{ polylang.title_day_shift }}</span>
											<span class="@timely">(08:00 - 12:00) pm</span>
										</div>
									</h3>
									<div class="distribute-time">
										<template v-for="schedule in times.AM">
											<div :key="schedule.time" class="fancy-time">
												<FancyButton
													:text="schedule.time"
													:disable="schedule.busy"
													@click="handleMarkTime($event, schedule.value)"
													:current="schedule.value == current_time"
												/>
											</div>
										</template>
									</div>
								</section>
								<section class="calendar-turns-after">
									<h3 class="c-turn-title">
										<svg width="24" height="20" fill="none" viewBox="0 0 24 20">
											<path
												fill="#395D64"
												d="M16.993 15.29c.104-3.002-2.224-5.35-5.144-5.284-2.842.063-5.067 2.585-4.82 5.465.01.104.034.208.035.312a.843.843 0 0 1-.728.876.805.805 0 0 1-.908-.67c-.22-1.173-.06-2.315.373-3.416 1.199-3.052 4.475-4.8 7.62-4.081a6.684 6.684 0 0 1 5.228 6.987 3.525 3.525 0 0 1-.035.312c-.097.605-.461.937-.953.871-.49-.065-.752-.467-.695-1.085.016-.126.024-.247.027-.287Zm-5.039 4.704H4.83a2.044 2.044 0 0 1-.466-.018c-.417-.104-.675-.367-.678-.804 0-.46.26-.74.706-.832.154-.02.31-.024.466-.014h14.559c.559.02.924.358.915.847-.009.47-.36.794-.892.818h-.363l-7.122.003Zm.904-16.165c.37-.384.645-.685.936-.97.44-.432.921-.473 1.283-.123.363.35.34.85-.085 1.282-.768.778-1.54 1.55-2.319 2.316-.467.459-.882.454-1.352-.012-.78-.763-1.552-1.535-2.317-2.316-.405-.417-.432-.893-.096-1.25.336-.355.845-.34 1.283.076.15.143.302.287.44.442.137.155.259.324.388.487l.154-.069V1.546c0-.242-.012-.486 0-.728.032-.487.385-.823.832-.818a.819.819 0 0 1 .82.833c.017.849 0 1.699.006 2.548.002.104.014.203.027.448ZM2.018 15.83c-.276 0-.553.013-.833 0-.488-.026-.827-.367-.833-.816a.811.811 0 0 1 .808-.838c.57-.023 1.145-.023 1.71 0a.817.817 0 0 1 .813.835c-.007.45-.345.79-.833.817-.28.015-.558.003-.832.003Zm19.98-1.663c.276 0 .552-.014.832 0 .49.028.827.368.833.818a.818.818 0 0 1-.81.837 22.16 22.16 0 0 1-1.71 0 .816.816 0 0 1-.81-.836c.008-.453.343-.787.832-.814.28-.019.556-.005.833-.005ZM6.231 8.445c-.155.183-.294.505-.532.609-.237.104-.644.07-.849-.08a6.78 6.78 0 0 1-1.144-1.118c-.277-.324-.257-.712.017-1.04.275-.33.676-.428.974-.195.51.398.937.9 1.384 1.373.077.072.08.217.15.45Zm12.311.773c-.173-.14-.487-.276-.577-.5-.097-.246-.094-.652.051-.853.338-.435.726-.83 1.155-1.177.306-.26.682-.237 1.003.013.32.25.459.664.226.964-.406.52-.921.962-1.404 1.422-.076.07-.223.07-.454.131Z"
											/>
										</svg>
										<div class="c-turn-ftitle">
											<span class="@dayly">{{ polylang.title_after_shift }}</span>
											<span class="@timely">(12:00 - 07:00) pm</span>
										</div>
									</h3>
									<div class="distribute-time">
										<template v-for="schedule in times.PM">
											<div :key="schedule.time" class="fancy-time">
												<FancyButton
													:text="schedule.time"
													:disable="schedule.busy"
													@click="handleMarkTime($event, schedule.value)"
													:current="schedule.value == current_time"
												/>
											</div>
										</template>
									</div>
								</section>
								<div class="calendar-turns-loading" :class="{ loading }">
									<IconLoading :text="polylang.title_loading" />
								</div>
								<div class="popover-ex" :style="computePopover" v-if="current_doctor">
									<div class="users-lists fancy-time-popover">
										<button
											v-for="user in users"
											:key="user.id"
											class="user-item"
											:class="{ current: user.id === current_doctor }"
											:title="user.fullname"
											@click="defineDoctorId(user.id)"
										>
											<IconUser />
										</button>
									</div>
								</div>
							</div>
							<div class="calendar-legend">
								<button class="calendar-turns--action" @click="updateService">{{ polylang.btn_confirm }}</button>
								<div class="flex gap-4 pl-8">
									<span class="lg-date lg-selected">
										<i class="lg-square" />
										{{ polylang.text_selected_date || 'Fecha seleccionada' }}
									</span>
									<span class="lg-date lg-busy">
										<i class="lg-square" />
										{{ polylang.text_not_available || 'No disponible' }}
									</span>
									<span class="lg-date lg-available">
										<i class="lg-square" />
										{{ polylang.text_available || 'Disponible' }}
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</AppModalScreen>
	</ClientOnly>
</template>

<script>
import { dateFormatTomorrow, getTomorrow } from '@/plugins/utils';
import { mapState } from 'vuex';
import { IconUser } from '@/components/atoms/icons';

export default {
	name: 'VueCalendar',
	components: {
		AppModalScreen: () => import('@/components/globals/AppModalScreen.vue'),
		IconUser,
	},
	props: {
		id: [Number, String],
		doctor: Number,
		fromDate: {
			type: Object,
			default: () => ({ from: '', to: '' }),
		},
	},
	computed: {
		...mapState({
			polylang: state => state.polylang,
			common: state => state.common,
			users: state => state.booking.users,
			loading: state => state.booking.loading,
			times: state => state.booking.times,
		}),
		dateTomorrow: () => getTomorrow(),
		computePopover() {
			return {
				top: `${this.printContext.y}px`,
				left: `${this.printContext.x}px`,
			};
		},
		langActive() {
			return this.$i18n.locale;
		},
	},
	methods: {
		async handleMarkTime(event, value) {
			const sizes = event.target.getBoundingClientRect();
			this.current_time = value;
			const current = `${this.date} ${value.split('|')[0]}`;
			await this.$store.dispatch({
				type: 'booking/setBookingTime',
				time: current,
			});
			this.current_doctor = this.users[0] ? this.users[0].id : null;
			this.printContext = {
				x: parseFloat(sizes.left),
				y: parseFloat(sizes.top - (sizes.height + 10)),
			};
		},
		defineDoctorId(id) {
			this.current_doctor = id;
		},
		updateService() {
			if (this.current_time === '' && this.$i18n.locale === 'es') {
				return this.$store.dispatch('event/triggerWarningEvent', 'Seleccione fecha y hora');
			}
			if (this.current_time === '' && this.$i18n.locale === 'en') {
				return this.$store.dispatch('event/triggerWarningEvent', 'Select date and time');
			}
			// if (this.current_doctor === null && this.$i18n.locale === 'es') {
			// 	return this.$store.dispatch('event/triggerWarningEvent', 'Selecione un especialista que lo atendera');
			// }
			// if (this.current_doctor === null && this.$i18n.locale === 'en') {
			// 	return this.$store.dispatch('event/triggerWarningEvent', 'Selecione un especialista que lo atendera ingles');
			// }
			const [start, end] = this.current_time.split('|');
			const from = `${this.date} ${start}`;
			const to = `${this.date} ${end}`;
			this.$store.dispatch('shop/updateService', {
				id: this.id,
				from: from,
				to: to,
				doctor: this.current_doctor,
			});
			this.$emit('update');
		},
	},
	mounted() {
		this.current_doctor = this.doctor;
		if (this.fromDate.from && this.fromDate.to) {
			const makeTimeline = `${this.fromDate.from.split(' ')[1]}|${this.fromDate.to.split(' ')[1]}`;
			this.current_time = makeTimeline;
			this.date = this.fromDate.from.split(' ')[0];
		}
		console.log(this.$i18n.locale);
	},
	watch: {
		date(current, old) {
			this.$store.dispatch({
				type: 'booking/setBookingSchedule',
				date: current,
			});
		},
	},
	data: () => ({
		date: dateFormatTomorrow(),
		masks: {
			weekdays: 'WWW',
			navMonths: 'MMMM',
		},
		current_time: '',
		current_doctor: null,
		printContext: {
			x: 0,
			y: 0,
		},
	}),
};
</script>

<style lang="postcss">
.t-modal {
	@apply flex justify-center items-center;
	overflow: hidden;
	@media screen(xl) {
		max-width: 75vw;
	}
}
.calendar-turns {
	background-color: rgba(73, 164, 180, 0.31);
	border-radius: 1rem;
	padding: calc(var(--p-font-size) * 1.8);
	position: relative;
}
.calendar-turns-after {
	padding-top: var(--p-font-size);
	border-top: 1px solid #395d64;
}
.calendar-turns-before {
	padding-bottom: 1.4rem;
}
.calendar-turns--action {
	display: inline-flex;
	align-items: center;
	font: normal 500 calc(var(--p-font-size) - 1px) / 1.2 'Roboto', serif;
	border-radius: 0.5rem;
	background-color: var(--primary);
	color: var(--white);
	padding: 0.4em 1em;
}
.calendar-turns-loading {
	position: absolute;
	@apply inset-0 flex items-center justify-center flex-col;
	background-color: #c1d7db;
	border-radius: 1rem;
	pointer-events: none;
	opacity: 0;
	transition: opacity 300ms ease-in-out;
	z-index: 2;
	.t-load {
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}
	h6 {
		padding-top: 1.6rem;
	}
	&.loading {
		opacity: 1;
		pointer-events: auto;
	}
}

.calendar-legend {
	@apply flex mt-[2rem];
	.lg-date {
		font-size: calc(var(--p-font-size) - 3px);
		&.lg-busy .lg-square {
			background-color: rgba(35, 64, 69, 0.392);
			position: relative;
			&::after {
				content: '';
				position: absolute;
				background-color: var(--primary);
				width: 1.2em;
				height: 1px;
				transform: rotate(-45deg);
				top: 0.4em;
				right: -0.2em;
			}
		}
		&.lg-available .lg-square {
			background-color: transparent;
		}
	}
	.lg-square {
		display: inline-block;
		width: 1em;
		height: 1em;
		background-color: var(--primary);
		border: 1px solid var(--primary);
		margin: 0.5em 0.5em 0;
	}
}

.c-turn-title {
	padding: 0.4em 0;
	@apply flex text-primary leading-tight items-center text-[2.1rem] lg:text-[1.9rem] design:text-[2.3rem] monitor:text-[2.7rem];
	.\@timely {
		font: normal 500 0.62em / 1 'Roboto', serif;
		color: var(--gray-400);
	}
}

.distribute-time {
	display: flex;
	flex-wrap: wrap;
	column-gap: 1.2rem;
	row-gap: 0.8rem;
	@media screen(lg) {
		max-height: 7.5ch;
		overflow: hidden auto;
		&::-webkit-scrollbar-track {
			-webkit-box-shadow: inset 0 0 6px #5e859b;
			background-color: #f5f5f5;
			border-radius: 4px;
		}

		&::-webkit-scrollbar {
			width: 6px;
			background-color: #f5f5f5;
		}

		&::-webkit-scrollbar-thumb {
			background-color: var(--primary);
			border-radius: 4px;
		}
	}
}

.fancy-time {
	/* position: relative;
	&-popover {
		position: absolute;
		background-color: var(--primary);
	} */
}

.users-lists {
	display: flex;
	gap: 0.5rem;
	font: var(--p-font-size);
	button svg {
		width: 1.7em;
		height: 1.7em;
		circle {
			stroke: #c1d7db;
		}
		path {
			fill: #c1d7db;
		}
	}
	button:hover,
	button.current {
		transition: all 300ms ease-in-out;
		circle {
			stroke: var(--primary);
			fill: #c1d7db;
		}
		path {
			fill: var(--primary);
		}
	}
	button:active {
		transform: scale(0.94);
	}
}

.mx-card {
	padding: 2.6rem;
	@apply bg-white;
	max-height: 88vh;
	overflow-y: auto;
	&--head {
		@apply text-center;
		h3 {
			font: normal 400 2.8rem / 1.2 'Cormorant-Garamont';
			color: var(--primary);
			padding: 0.5em 0 0.3em 0;
		}
		p {
			padding: 0.4em 0;
		}
	}
	@media screen(lg) {
		padding: 4vmin 9.5vmin;
		&--body {
			display: flex;
			justify-content: space-between;
			gap: 1.5rem;
		}
		&--left {
			width: 44%;
		}
		&--right {
			width: 60%;
		}
		&--head {
			h3 {
				font-size: 2.4rem;
			}
			h3,
			p {
				text-align: start;
			}
			p {
				margin-bottom: 0.8em;
			}
		}
	}
	@media screen(monitor) {
		&--head {
			h3 {
				font-size: 3.8rem;
			}
			p {
			}
		}
	}
}
.popover-ex {
	position: fixed;
	background-color: var(--primary);
	z-index: 1;
	display: flex;
	padding: 0.4rem 0.8rem;
	border-radius: 5px;
	box-shadow: 2px 2px 8px 1px rgba(0, 0, 0, 0.4);
}
</style>
