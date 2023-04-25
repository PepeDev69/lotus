<script lang="ts" setup>
import BaseButton from '@component/atoms/BaseButton.vue';
import { view } from '@component/atoms/icons';
defineProps({
	id: Number,
	available: Boolean,
	name: String,
	email: String,
	avatar: String,
	type: String,
	mutate: Number,
});
</script>

<template>
	<article class="doc-card" :class="{ mutate: mutate === id }">
		<picture class="doc-card__picture">
			<img :src="avatar" alt="" />
			<span class="@employe-status" :class="{ avail: available }">
				{{ 'H' }}
			</span>
		</picture>
		<div class="doc-card__content">
			<h3 class="t-init @employe-name">{{ name }}</h3>
			<span class="@employe-type">{{ type }}</span>
			<span id="t-email" class="@employe-email t-round">
				<a :href="`mailto:${email}`">
					<svg width="18" height="18" fill="none" viewBox="0 0 24 24">
						<path
							fill="currentColor"
							d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2Zm0 2v.511l-8 6.223-8-6.222V6h16ZM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4Z"
						/>
					</svg>
					<span>{{ email }}</span>
				</a>
			</span>
		</div>
		<div class="doc-card__actions t-flex">
			<BaseButton text="ACTUALIZAR" class="@employe-btn" @click.native="$emit('update')" />
			<BaseButton text="ELIMINAR" class="@employe-btn" @click.native="$emit('delete')" />
			<button class="" @click="$emit('view')">
				<ViewIcon :icon="view" />
			</button>
		</div>
	</article>
</template>

<style lang="scss">
.doc-card {
	display: flex;
	flex-direction: column;
	border: 1px solid var(--ts-grey-800);
	background-color: var(--ts-grey-900);
	border-radius: 5px;
	padding: 2.2rem;
	box-shadow: 0 20px 32px -8px rgb(0 0 0 / 40%);
	transition: 200ms ease-in-out;
	transition-property: filter, background;
	&.mutate {
		pointer-events: none;
		filter: hue-rotate(90deg);
	}
	&__picture {
		position: relative;
		img {
			width: 4.5rem;
			height: 4.8rem;
			border-radius: 0.45rem;
			object-fit: cover;
			object-position: top;
		}
	}
	&__actions {
		column-gap: 1.5rem;
		padding-top: 2.2rem;
	}
}
.\@employe {
	&-status {
		position: absolute;
		top: 0;
		right: 0;
		color: teal;
	}
	&-name {
		color: var(--ts-grey-400);
		font: normal 500 1.9rem/1.5 var(--font);
		padding: 0.5em 0 0.25em;
	}
	&-type {
		display: block;
		font: normal 500 1.4rem/1.2 var(--font);
		color: var(--ts-grey-600);
		margin-bottom: 0.5em;
	}
	&-email {
		background-color: var(--ts-grey-700);
		display: inline-block;
		a {
			font: normal 1.4rem/1 var(--font);
			color: var(--ts-cyan-light);
			display: inline-flex;
			align-items: center;
			column-gap: 0.2em;
			padding: 0.4em 0.8em;
		}
	}
}
</style>
