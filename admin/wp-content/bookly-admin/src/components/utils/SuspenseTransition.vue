
<script lang="ts" setup>
defineProps<{
	name: string
}>()
</script>

<template>
	<Suspense>
		<Transition :name="name" mode="out-in">
			<template #default>
				<slot></slot>
			</template>
			<template #fallback>
				<slot name="fallback"></slot>
			</template>
		</Transition>
	</Suspense>
</template>