<script lang="ts" setup>
import Title from "@component/atoms/Title.vue";
import BaseButton from "@component/atoms/BaseButton.vue";
import MetaBox from "@component/atoms/MetaBox.vue";
import { ref } from "vue";
import { useUserStore } from "@/stores/users";
import { useOverlayStore } from "@/stores/overlay";

const props = defineProps({
	action: {
		type: String,
		default: "update",
	},
	values: {
		type: Object,
		default: {
			first_name: "",
			last_name: "",
			email: "",
			avatar: "",
			position: "",
			gender: "",
		},
	},
});

const user = ref<Doctor>(props.values as Doctor);
const userStore = useUserStore();
const overlay = useOverlayStore();

const dict = ref<Record<any, Record<any, string>>>({
	register: {
		message: "Registrar un nuevo empleado",
		button: "REGISTRAR",
	},
	update: {
		message: "Actualizar informacion",
		button: "ACTUALIZAR",
	},
});

const handleUserMutation = async () => {
	if (props.action == "register") {
		const success = await userStore.createUser(user.value);
		success == "success" && overlay.changeClose();
	}

	if (props.action == "update") {
		const success = await userStore.updateUser(Number(user.value.id), user.value);
		success == "success" && overlay.changeClose();
	}
};
</script>

<template>
	<div :class="css.form_wrap">
		<form @submit.prevent="handleUserMutation" :class="css.form" class="t-box" enctype="multipart/form-data">
			<Title :text="dict[action].message" />
			<div :class="css.wrap">
				<TextField label="Nombres" placeholder="Nombres" v-model.trim="user.first_name" />
				<TextField label="Apellidos" placeholder="Apellidos" v-model.trim="user.last_name" />
			</div>
			<TextField label="Correo electronico" placeholder="Correo electronico" v-model.trim="user.email" />
			<div :class="css.wrapped">
				<FileReader label="Imagen" v-model:value="user.avatar" />
				<div class="">
					<TextField label="Cargo en la compania" placeholder="Posicion" v-model.trim="user.position" />
					<MetaBox v-model="user.gender" />
				</div>
			</div>
			<div class="t-flex" :class="css.form_action">
				<BaseButton text="CANCELAR" @click.native="overlay.changeClose" />
				<BaseButton
					type="submit"
					:text="dict[action].button"
					:loading="userStore.loading"
				/>
			</div>
		</form>
	</div>
</template>

<style lang="scss" module="css">
.form_wrap {
	min-width: 54vw;
}
.form {
	display: flex;
	flex-direction: column;
	&_action {
		padding-top: 1.2rem;
		column-gap: 3rem;
	}
}

.wrap {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	column-gap: 2rem;
}

.wrapped {
	display: grid;
	grid-template-columns: 2fr 5fr;
	margin-bottom: 1em;
	align-items: center;
}
</style>
