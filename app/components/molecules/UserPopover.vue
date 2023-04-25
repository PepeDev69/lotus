<template>
	<div class="pp-popper">
		<FancyButton />
		<template v-if="name">
			<div class="users-list">
				<button v-for="user in users" :key="user.id" class="user-item">
					<IconUser />
				</button>
			</div>
		</template>
	</div>
</template>

<script>
import { IconUser } from '@/components/atoms/icons';
import { mapState } from 'vuex';
export default {
	name: 'UserPopover',
	components: {
		IconUser,
	},
	props: {
		context: Number,
		current: Number
	},
	computed: {
		...mapState({
			users: state => state.booking.users,
		}),
		isCurrentContext() {
			return this.context;
		},
	},
};
</script>

<style></style>
