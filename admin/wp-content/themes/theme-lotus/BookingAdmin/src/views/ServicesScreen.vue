<script lang="ts" setup async>
import { mainService } from '@/services/common.service';
import { onMounted, ref } from 'vue';

const services = ref<ServiceComplete[]>([]);
onMounted(async () => {
	services.value = await mainService.findServicesComplete();
});
</script>

<template>
	<div class="service-page">
		<ul class="service-grid">
			<li v-for="service in services" :key="service.id" class="service-item">
				<article :style="`--image: url(${service.picture})`" class="service-card">
					<div class="service-mask">
						<h2>{{ service.name }}</h2>
					</div>
				</article>
			</li>
		</ul>
	</div>
</template>

<style lang="scss">
.service-page {
	padding: 5rem;
}
.service-grid {
	display: grid;
	grid-template-columns: repeat(4, 1fr);
	gap: 4rem;
}
.service-item {
	display: flex;
}

.service-card {
	background: transparent var(--image) no-repeat center / cover;
	width: 100%;
	aspect-ratio: 6/5;
	display: flex;
	align-items: flex-end;
}
.service-mask {
	padding: 3rem;
	background-image: linear-gradient(360deg, rgb(0, 0, 0.6) 0%, rgba(53, 53, 53, 0.8) 50%, rgba(0, 0, 0, 0) 100%);
	width: 100%;
	height: 60%;
	display: flex;
	align-items: flex-end;
	color: var(--ts-primary);
	h2 {
		font: normal 500 2.5rem / 1.25 var(--font);
		text-transform: uppercase;
		letter-spacing: 0.05em;
	}
}
</style>
