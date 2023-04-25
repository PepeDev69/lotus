<template>
	<header class="o-header" ref="header" :class="{ sticky }" v-scroll="observeHeader" :style="mapHeight">
		<section class="o-header-top" ref="header_top">
			<HeaderTop />
		</section>
		<div class="tg_overlay" :class="openMenu ? 'open' : 'close'" @click="closeMenu"></div>
		<section class="o-header-main flex items-center" v-click-outside="closeMenu" :class="{ open: openMenu }">
			<div class="flex items-center o-header-main-inter">
				<AppLink :to="{ name: 'index' }" class="o-header-brand">
					<img :src="common.logo" alt="Lotus Stetic Branding" />
				</AppLink>
				<MainMenu :items="polylang.menu" :open-menu="openMenu" @menu="menuHandler" @submenu="subMenuHandler" />
				<SocialBlock type="footer" class="os-header-socials" />
				<MenuIcon :isActive="openMenu" :data-active="openMenu" @click.native="toggleMenu" />
			</div>
		</section>
	</header>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import { throttle } from '~/plugins/utils';
export default {
	name: 'AppHeader',
	components: {
		SocialBlock: () => import('@/components/molecules/SocialBlock.vue').then(e => e.default),
		ShopCartCounter: () => import('@/components/molecules/ShopCartCounter.vue').then(e => e.default),
		MainMenu: () => import('@/components/molecules/MainMenu.vue').then(e => e.default),
		HeaderTop: () => import('@/components/molecules/HeaderTop.vue').then(e => e.default),
		MenuIcon: () => import('~/components/atoms/MenuIcon.vue'),
	},
	computed: {
		...mapState(['common', 'polylang']),
		...mapGetters('shop', {
			countCart: 'getCartCount',
		}),
		mapHeight() {
			return { '--pg-height': ` -${this.headerHeight}px` };
		},
	},
	methods: {
		observeHeader: throttle(function (e) {
			if (matchMedia('(min-width: 62em)').matches) {
				this.sticky = window.scrollY > this.headerHeight;
			}
		}, 50),
		handleOpenMenu() {
			this.openMenu = true;
			document.querySelector('html').classList.add('open');
		},
		closeMenu() {
			this.openMenu = false;
			document.querySelector('html').classList.remove('open');
		},
		toggleMenu() {
			this.openMenu = !this.openMenu;
			if (this.openMenu === true) {
				document.querySelector('html').classList.add('open');
			} else {
				document.querySelector('html').classList.remove('open');
			}
		},
		menuHandler(event, { parent, hijos }) {
			// console.log('parent', parent);
			// console.log('svg', hijos.$el);
			if (parent === false) {
				this.openMenu = false;
				document.body.classList.remove('active');
				document.querySelector('html').classList.remove('open');
				document.getElementById('permanent-hair-removal').classList.remove('open');
				document.getElementById('skin-care').classList.remove('open');
				document.getElementById('body-wellness').classList.remove('open');
				document.getElementById('services').classList.remove('open');
				document.getElementById('products').classList.remove('open');
			} else if (!matchMedia('(min-width: 1025px)').matches) {
				this.parent = parent;
				if (!parent.classList.contains('open')) {
					const height = [...parent.children].reduce((acc, el) => acc + el.scrollHeight, 0.0);
					parent.classList.add('open');
					hijos.$el.classList.add('openIcono');
					parent.style.borderTop = `1px solid #ee8864`;
					// console.log({ parent: '1' });
				} else {
					if (this.parent.querySelector('.open')) {
						this.parent.querySelector('.open').height = '';
					}
					parent.classList.remove('open');
					hijos.$el.classList.remove('openIcono');
					parent.style.borderTop = '';
					// console.log({ parent: '1-2' });
				}
			}
		},
		subMenuHandler(event, { parent, hijos, refPrin, slugMenu }) {
			// permanent-hair-removal, skin-care, body-wellness
			// console.log(parent, hijos, refPrin, slugMenu);
			const servicesList = document.getElementsByClassName('onlyServices');

			for (let i = 0; i < servicesList.length; i++) {
				const element = servicesList[i];
				// console.log(element);
			}

			if (parent === false || refPrin === 'products') {
				this.openMenu = false;
				document.getElementById('permanent-hair-removal').classList.remove('open');
				document.getElementById('skin-care').classList.remove('open');
				document.getElementById('body-wellness').classList.remove('open');
				document.getElementById('products').classList.remove('open');
				document.getElementById('services').classList.remove('open');
				document.querySelector('html').classList.remove('open');
			}

			if (slugMenu === 'permanent-hair-removal') {
				if (document.getElementById('permanent-hair-removal').classList.contains('open')) {
					document.getElementById('permanent-hair-removal').classList.remove('open');
				} else {
					document.getElementById('permanent-hair-removal').classList.add('open');
					document.getElementById('skin-care').classList.remove('open');
					document.getElementById('body-wellness').classList.remove('open');
				}
			}
			if (slugMenu === 'skin-care') {
				if (document.getElementById('skin-care').classList.contains('open')) {
					document.getElementById('skin-care').classList.remove('open');
				} else {
					document.getElementById('skin-care').classList.add('open');
					document.getElementById('permanent-hair-removal').classList.remove('open');
					document.getElementById('body-wellness').classList.remove('open');
				}
			}
			if (slugMenu === 'body-wellness') {
				if (document.getElementById('body-wellness').classList.contains('open')) {
					document.getElementById('body-wellness').classList.remove('open');
				} else {
					document.getElementById('body-wellness').classList.add('open');
					document.getElementById('permanent-hair-removal').classList.remove('open');
					document.getElementById('skin-care').classList.remove('open');
				}
			}
			hijos.$el.classList.add('openIconoTwo');
			// if (parent === false || refPrin === 'products') {
			// 	this.openMenu = false;
			// 	document.body.classList.remove('active');
			// 	document.querySelector('html').classList.remove('open');
			// } else if (!matchMedia('(min-width: 1025px)').matches) {
			// 	if (!parent.classList.contains('open')) {
			// 		const height = Array.from(parent.children).reduce((acc, el) => acc + el.scrollHeight, 0.0);
			// 		[...this.parent.children].forEach(el => {
			// 			el.classList.remove('open');
			// 			el.lastChild.style.borderTop = '';
			// 		});
			// 		parent.classList.add('open');
			// 		hijos.$el.classList.add('openIconoTwo');
			// 	} else {
			// 		parent.classList.remove('open');
			// 		hijos.$el.classList.remove('openIconoTwo');
			// 		parent.style.borderTop = '';
			// 	}
			// }
		},
	},
	mounted() {
		this.headerHeight = parseFloat(getComputedStyle(this.$refs.header_top).height);
		const headerHeight = getComputedStyle(this.$refs.header).height;
		this.$nextTick(() => {
			this.$root.$el.setAttribute('style', `--header-height: ${headerHeight}`);
		});
	},
	data: () => ({
		headerHeight: 0,
		sticky: false,
		openMenu: false,
		parent: null,
		parentHeight: 0,
		childsHeight: 0,
	}),
};
</script>

<style lang="postcss">
:root {
	--top-height: 7rem;
	--height: 7rem;
	@media (min-width: 1200px) {
		--top-height: 4rem;
	}
	@screen design {
		--top-height: 5rem;
	}
}

.tg_overlay {
	@apply z-[8] pointer-events-none fixed w-full h-[100vh] inset-0 bg-black bg-opacity-[.7] opacity-0 overflow-hidden;
	transition: opacity 500ms ease-in-out;
	&.open {
		@apply pointer-events-auto opacity-100;
	}
	@media (min-width: 1025px) {
		@apply hidden;
	}
}
.o-header {
	background-color: var(--white);
	position: fixed;
	z-index: 15;
	top: 0;
	width: 100%;
	transform: translateY(0);
	transition: transform 300ms;
	&.sticky {
		transform: translateY(var(--pg-height));
	}
	&-top {
		background-color: #ededed;
		/* overflow: hidden; */
		height: var(--top-height);
	}
	&-main {
		background-color: var(--white);
		padding: 1rem 0;
		width: 100%;
		box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
		position: relative;
		transition: all 400ms ease-in-out;
		z-index: 10;
		&-inter {
			width: 92%;
			margin-left: auto;
			margin-right: auto;
			justify-content: space-between;
		}
	}
	&-brand {
		width: 14rem;
	}

	@media (min-width: 1025px) {
		&-main.open {
			background-color: #fcebe5;
			padding: 3.3rem 0;
		}
	}
	@media screen(m-xl) {
		&-top {
			display: none;
		}
	}
	@media screen(lg) {
		&-brand {
			width: 18rem;
		}
		&-main {
			padding: 0.7rem 0;
		}
	}
}
.os-header-socials {
	padding-right: 5.4rem;
	@media (min-width: 1025px) {
		li:not(:last-child) {
			display: none;
		}
	}
}
</style>
