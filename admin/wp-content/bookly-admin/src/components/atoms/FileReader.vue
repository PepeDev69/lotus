<script setup lang="ts">
import { ref } from "vue";
import { upload } from "@component/atoms/icons";

const props = defineProps({
	value: [File, String],
});

const emit = defineEmits(["update:value"]);
const img = ref<string>(props.value as string);

const openFile = (input: HTMLInputElement) => {
	const reader = new FileReader();
	reader.addEventListener("load", () => {
		const imageURI = reader.result;
		img.value = imageURI as string;
	});
	reader.readAsDataURL(input.files[0]);
	emit("update:value", input.files[0]);
};
</script>

<template>
	<div :class="css.file" class="t-round">
		<img :class="css.output" v-if="img" :src="img" alt="" />
		<label :class="[css.reader, img && css.shadow]" class="t-round t-abs-center">
			<input type="file" accept="image/*" @change="openFile($event.target as HTMLInputElement)" hidden />
			<span :class="css.legend" class="t-main-center">
				<ViewIcon :icon="upload" />
				<span> AVATAR </span>
			</span>
		</label>
	</div>
</template>

<style lang="scss" module="css">
// @import "@/assets/__functions.scss";
.file {
	display: inline-flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	background-color: var(--ts-dark);
	border: 2px dashed var(--ts-grey-600);
	width: 8em;
	height: 6.8em;
	object-fit: contain;
	cursor: pointer;
	position: relative;

	@include media-from(monitor) {
		width: 19rem;
		height: 14rem;
		margin-left: 3rem;
		margin-top: 1.8rem;
	}
}

.reader {
	color: var(--ts-grey-500);
	width: 100%;
	height: 100%;
	cursor: pointer;

	input {
		display: none;
	}
}

.legend {
	color: var(--ts-light-700);

	span {
		font-weight: 500;
	}
}

.output {
	object-fit: contain;
	height: 100%;
	width: 100%;
	padding: 1.5rem;
}

.label {
	font: normal 500 1.5rem / 1.5 var(--font);
	padding: 0.5em 0;
	color: var(--ts-grey-400);
}

.shadow {
	position: absolute;
	z-index: 1;
	opacity: 0;
}
</style>
