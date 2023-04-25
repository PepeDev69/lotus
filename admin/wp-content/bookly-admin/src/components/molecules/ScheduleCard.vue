<script lang="ts" setup>
import { trash, update, view } from '@component/atoms/icons';

defineProps<{
	id: number;
	customer: string;
	service: string;
	doctor: string;
	mutate: any;
}>();

defineEmits(['delete', 'update', 'view']);
</script>

<template>
	<article class="t-round sc-card" :class="{ mutate: mutate == id }">
		<h3 class="sc-card__tit">
			<div class="sc-card__tit-label">
				<span class="sc-card__@type">CLIENTE</span>
				<span class="sc-card__@span">{{ customer }}</span>
			</div>
			<div class="sc-card__tit-label">
				<span class="sc-card__@type">SERVICIO</span>
				<span class="sc-card__@span">{{ service }}</span>
			</div>
		</h3>
		<h4 class="sc-card__doc-title">{{ doctor }}</h4>
		<div class="sc-card__actions">
			<button class="sc-card__actions-btn" @click="$emit('view')">
				<ViewIcon :icon="view" />
			</button>
			<button class="sc-card__actions-btn" @click="$emit('delete')">
				<ViewIcon :icon="trash" />
			</button>
			<button class="sc-card__actions-btn" @click="$emit('update')">
				<ViewIcon :icon="update" />
			</button>
		</div>
	</article>
</template>

<style lang="scss">
.sc-card {
	display: flex;
	background-color: var(--ts-dark);
	padding: 1.1rem 1.4rem;
	align-items: center;
	justify-content: space-between;
	box-shadow: 0 1px 2px 1px #0b0b0c29;
	border-top: 1px solid var(--ts-cyan-light);
	cursor: pointer;
	transition: 500ms ease-in-out;
	transition-property: transform;
	&.mutate {
		background-color: rgba(193, 57, 33, 0.159);
		border-top-color: tomato;
		pointer-events: none;
	}
	&__doc-title {
		color: var(--ts-primary);
		font: normal 500 1.4rem/1 var(--font);
	}

	&__actions {
		display: inline-flex;
		column-gap: 1rem;
		&-btn {
			color: var(--ts-grey-600);
			background-color: transparent;
			padding: 3px;
			line-height: 1;
			cursor: pointer;
			transition: color 500ms ease-in-out;
			svg {
				width: 1.4em;
				height: 1.4em;
			}
			&:hover {
				color: var(--ts-cyan-light);
			}
		}
	}
}

.sc-card__tit {
	color: var(--ts-grey-200);
	display: flex;
	column-gap: 1em;
	font: normal 500 1.5rem/1 var(--font);
	&-label {
		display: flex;
		flex-direction: column;
		min-width: 22ch;
	}
	.sc-card {
		&__\@span {
			font-weight: 400;
		}
		&__\@type {
			font-size: 0.65em;
			padding-bottom: 0.3em;
			color: var(--ts-grey-500);
		}
	}
}
</style>
