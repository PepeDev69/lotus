<script lang="ts" setup>
import EmployeeForm from '@component/molecules/EmployeeForm.vue';
import EmployeeComplete from '@component/organisms/EmployeeComplete.vue';
import { ref, onMounted, reactive } from 'vue';
import { addUser, search } from '@component/atoms/icons';
import { useUserStore } from '@/stores/users';
import { useOverlayStore } from '@/stores/overlay';

const context = ref('register');
const user = useUserStore();
const overlay = useOverlayStore();

onMounted(async () => {
	await user.fetchUsers();
});

const reactiveUser = reactive({
	first_name: '',
	last_name: '',
	email: '',
	avatar: '',
	position: '',
	gender: 'Femenino',
}) as Doctor;

const currentUser = ref<Doctor>(reactiveUser);

const registerNewUser = () => {
	context.value = 'register';
	currentUser.value = reactiveUser;
	overlay.changeOpen();
};

const updateUser = ({ doctor }: any) => {
	context.value = 'update';
	currentUser.value = doctor;
	overlay.changeOpen();
};

const defineSearchCriteria = (value: string) => {
	const criteria = value.trim().toLowerCase();
	user.defineFilteredCriteria(criteria);
};
</script>

<template>
	<div :class="css.screen">
		<section :class="css.c_title" class="t-main-center">
			<TextField
				placeholder="Buscar especialista"
				@input="defineSearchCriteria($event.target.value)"
				init
				:icon="search"
			/>
			<div :class="css.icon" class="t-abs-center" @click="registerNewUser">
				<ViewIcon :icon="addUser" />
			</div>
		</section>
		<section :class="css.list">
			<Suspense :timeout="0">
				<EmployeeComplete @update="updateUser($event)" />
			</Suspense>
		</section>
		<ModuleOverlay>
			<EmployeeForm :action="context" :values="currentUser" />
		</ModuleOverlay>
	</div>
</template>

<style lang="scss" module="css">
.screen {
	padding: 3.2rem;
}
.c_title {
	display: flex;
	h3 {
		color: var(--ts-light-600);
	}
}
.list {
	position: relative;
	padding: 3.2rem 0;
}

.new {
	bottom: 4rem;
	right: 5rem;
	.icon {
		color: var(--ts-grey-800);
		font-weight: 600;
		font-size: 2.8rem;
		height: 1.8em;
		width: 1.8em;
		background-color: var(--ts-primary);
		box-shadow: 0 20px 32px -8px rgb(0 0 0 / 40%);
		border-radius: 50%;
		cursor: pointer;
		svg {
			margin-right: -0.14em;
			width: 1em;
			height: 1em;
		}
	}
}
</style>

<style lang="scss">
.css-a {
	transition: all 0.5s;
	&-last {
		min-height: 7ch;
		font: normal 500 0.9rem/1 var(--font);
		svg {
			padding-right: 0.4em;
		}
	}
}
.card-enter,
.card-leave-to {
	opacity: 0;
	transform: scale(0);
}
.card-enter-to {
	opacity: 1;
	transform: scale(1);
}

.card-move {
	opacity: 1;
	transition: all 0.5s;
}
</style>
