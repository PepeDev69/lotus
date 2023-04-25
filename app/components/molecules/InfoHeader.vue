<template>
	<section class="m-info-bg" ref="menuFixed">
		<div class="m-info-container">
			<ul class="m-info">
				<li class="m-info__item">
					<a :href="common.address_url_map" target="_blank" class="m-info__text">
						<span class="m-info__icon icon-header-map" />
						<span>{{ address }}</span>
					</a>
				</li>
				<li class="m-info__item m-phone--group">
					<a :href="'tel:' + common.phone" class="m-info__text m-phone">
						<span class="m-info__icon icon-header-phone" />
						<span>{{ common.phone }}</span>
					</a>
					<a :href="'tel:' + common.cell" class="m-info__text m-phone">
						<span class="m-info__icon icon-header-phone" />
						<span>{{ common.cell }}</span>
					</a>
				</li>
				<li class="m-info__item m-mail--group">
					<a :href="'mailto:' + mail(0)" class="m-info__text m-mail">
						<span class="m-info__icon icon-header-email" />
						<span>{{ mail(0) }}</span>
					</a>
					<a :href="'mailto:' + mail(1)" class="m-info__text m-mail">
						<span class="m-info__icon icon-header-email" />
						<span>{{ mail(1) }}</span>
					</a>
				</li>
			</ul>
			<div class="m-socials">
				<p>{{ polylang.title_follow || 'Siguenos' }}:</p>
				<SocialIcons :items="common.social_networks" />
				<SwitchLanguage />
			</div>
		</div>
	</section>
</template>

<script>
import { mapState } from 'vuex';
export default {
	name: 'InfoHeader',
	components: {
		SocialIcons: () => import('../atoms/SocialIcons.vue'),
		SwitchLanguage: () => import('../atoms/SwitchLanguage.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		address() {
			return this.common.address.replace(/\s*<br>\s*/g, ' ');
		},
		mail() {
			return function (offset) {
				const email = this.common.email.split('|');
				if (email.length > 1) {
					return email[offset].trim();
				}
				return this.common.email;
			};
		},
	},
	mounted() {
		this.observer = new IntersectionObserver(
			entries => {
				if (entries[0].isIntersecting) {
					this.$emit('activeFixed', false);
				} else {
					this.$emit('activeFixed', true);
				}
			},
			{ threshold: 1 }
		);
		this.observer.observe(this.$refs.menuFixed);
	},
};
</script>

<style lang="postcss">
.m-info-bg {
	@apply hidden;
}
.m-info-container {
	@apply w-[92%] mx-auto flex justify-between items-center;
}
.m-info__item {
	@apply text-gray-900 leading-none font-normal flex items-center cursor-pointer;
}
.m-info__text {
	@apply text-gray-900 inline-flex items-center px-[0.4em] gap-[0.4em];
	&:hover {
		@apply text-primary;
	}
}
.m-mail--group, 
.m-phone--group {
	@apply flex-col gap-[0.6em] px-[2em];
	@apply design:flex-row design:px-[1.5rem];
}

@media screen(xl) {
	.m-info-bg {
		@apply bg-gray-800 text-[1.5rem] flex items-center;
	}
	.m-info {
		@apply flex items-center;
	}
	.m-info__icon {
		@apply text-[1.1em];
	}
	.m-socials {
		@apply flex items-baseline text-[1.6rem] tracking-[0.03em] font-normal;
	}
}
</style>
