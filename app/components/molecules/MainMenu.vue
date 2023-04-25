<template>
	<nav class="m-nav-menu" :class="{ open: openMenu }">
		<ul class="m-menu">
			<li class="m-menu__item" v-for="item in items" :key="item.id" :class="{ 'with-child': item.children }">
				<template>
					<a
						v-if="item.ref === 'services' || item.ref === 'products'"
						class="m-menu__item-link mt-link prin !uppercase cursor-default"
						:class="[
							item.ref,
							{ productActive: shopProductActive && item.ref === 'products' },
							{ serviceActive: shopServiceActive && item.ref === 'services' },
						]"
						@click="emiteWithRef($event, item.ref, 'menu')"
					>
						{{ item.label }}
					</a>
					<AppLink
						v-else
						class="m-menu__item-link mt-link prin !uppercase"
						:class="[
							item.ref,
							{ productActive: shopProductActive && item.ref === 'products' },
							{ serviceActive: shopServiceActive && item.ref === 'services' },
						]"
						:to="primaryLinker(item.url, item.ref)"
						@click.native="emiteWithRef($event, item.ref, 'menu')"
					>
						{{ item.label }}
					</AppLink>
				</template>
				<ArrowMenu v-if="item.children" class="icon-menu-mobile" :ref="item.ref" />
				<template v-if="item.children">
					<ul class="m-dropdown" :id="item.ref" :ref="item.ref">
						<li class="m-dropdown__item" v-for="subitem in item.children" :key="subitem.id" :class="{ 'with-child': subitem.children }">
							<template>
								<a
									v-if="item.ref === 'services'"
									class="m-dropdown__item-link mt-link hoverTwo w-full"
									:class="[
										item.ref === 'services' ? 'cursor-default' : 'cursor-pointer',
										subitem.slug.replace('#', '') === categorySelected ? 'current-active exact-current' : '',
										subitem.slug,
									]"
									@click="emiteWithRef($event, subitem.ref, 'submenu', item.ref, subitem.slug)"
								>
									{{ subitem.label }}
									<ArrowMenu class="icon-menu-laptop prim" />
								</a>
								<AppLink
									v-else
									class="m-dropdown__item-link mt-link hoverTwo w-full"
									:class="[
										item.ref === 'services' ? 'cursor-default' : 'cursor-pointer',
										subitem.slug.replace('#', '') === categorySelected ? 'current-active exact-current' : '',
										subitem.slug,
									]"
									:to="makeRoute(item, subitem)"
									@click.native="emiteWithRef($event, subitem.ref, 'submenu', item.ref, subitem.slug)"
								>
									{{ subitem.label }}
									<ArrowMenu class="icon-menu-laptop prim" />
								</AppLink>
							</template>
							<ArrowMenu v-if="subitem.children && item.ref !== 'products'" class="icon-menu-mobile-two" :ref="subitem.ref" />
							<template v-if="subitem.children">
								<ul class="m-subdropdwon" :class="[item.ref === 'services' ? 'onlyServices' : '']" :id="subitem.slug" :ref="subitem.ref">
									<li class="m-subdropdwon__item" v-for="child in subitem.children" :key="child.id">
										<AppLink
											:to="makeRoute(item, subitem, child)"
											class="m-subdropdwon__item-link mt-link hoverTwo !font-normal"
											:class="[child.children ? 'w-full' : '', child.slug === subcategorySelected ? 'exact-current current-active' : '']"
											@click.native="emiteWithRef($event, child.ref, 'menu')"
										>
											{{ child.label ? child.label : child.title }}
											<ArrowMenu v-if="child.children" class="icon-menu-laptop sec" />
										</AppLink>
										<template v-if="child.children">
											<template>
												<ul class="m-subdropdownlast">
													<li v-for="hijo in child.children" :key="hijo.id" class="m-subdropdownlast__item">
														<AppLink
															:to="makeRoute(item, subitem, child, hijo)"
															class="m-subdropdownlast__item-link mt-link hoverTwo !font-normal"
															@click.native="emiteWithRef($event, hijo.ref, 'menu')"
														>
															{{ hijo.title }}
														</AppLink>
													</li>
												</ul>
											</template>
										</template>
									</li>
								</ul>
							</template>
						</li>
					</ul>
				</template>
			</li>
		</ul>
	</nav>
</template>

<script>
export default {
	name: 'MaiMenu',
	props: {
		items: {
			type: [Array, Object],
			default: () => [],
		},
		openMenu: Boolean,
	},
	computed: {
		primaryLinker: () => (url, item) => {
			if (url === '/' || url === '/en') {
				return { name: 'index' };
			}
			if (url == '') {
				return `#${item}`;
			}
			const name = url.replace(/^((\/(es\/|en\/))|\/)/, '');
			return { name };
		},
		makeRoute: () => (item, subitem, su_subitem, child) => {
			if (item.ref === 'services') {
				if (subitem && su_subitem && child) {
					return {
						name: 'service-category-slug',
						params: {
							shop: 'services',
							category: subitem.ref,
							subcategory: su_subitem.ref,
							slug: child.slug,
						},
					};
				}
				if (subitem && su_subitem) {
					return {
						name: 'service-category',
						params: {
							shop: 'services',
							category: subitem.ref,
							subcategory: su_subitem.ref,
						},
					};
				}
				return `#${subitem.ref}`;
			}

			if (item.ref === 'products') {
				if (subitem && su_subitem) {
					return {
						name: 'product-category-slug',
						params: {
							shop: 'products',
							category: subitem.ref,
							slug: su_subitem.slug,
						},
					};
				}
				return {
					name: 'product-category',
					params: {
						shop: 'products',
						category: subitem.ref,
					},
				};
			}
		},
		shopProductActive() {
			return this.$route.params.shop === 'products' ? true : false;
		},
		shopServiceActive() {
			return this.$route.params.shop === 'services' ? true : false;
		},
		categorySelected() {
			return this.$route.params.category;
		},
		subcategorySelected() {
			return this.$route.params.subcategory;
		},
	},
	methods: {
		isMenuTech() {
			const [{ name: acupulse }, { name: legent }] = [
				this.localeRoute({ name: 'acupulse-co2-laser' }),
				this.localeRoute({ name: 'laser-legend-pro' }),
			];
			if ([acupulse, legent].includes(this.$route.name)) {
				return 'tech';
			}
			return this.$route.params.shop;
		},
		handleMatchMedia(e) {
			this.matchMedia = e.matches;
		},
		paginate(items) {
			const pages = Math.ceil(items.length / 9);
			const paginated = Array.from({ length: pages }, (_, index) => {
				const start = index * 9;
				return items.slice(start, start + 9);
			});
			return [...paginated];
		},
		emiteWithRef(event, ref, type, refPrin, slugRef) {
			// console.log('ref =>', ref, 'type =>', type, 'refprin =>', refPrin, 'slugref =>', slugRef);
			this.$emit(type, event, {
				parent: ref && this.$refs[ref] ? this.$refs[ref][1] : false,
				hijos: ref && this.$refs[ref] ? this.$refs[ref][0] : false,
				refPrin: refPrin,
				slugMenu: slugRef,
			});
		},
	},
	mounted() {
		const media = window.matchMedia('(min-width: 62em)');
		media.addEventListener('change', this.handleMatchMedia);
		this.handleMatchMedia(media);
	},
	data: () => ({
		matchMedia: false,
		iconoActive: true,
	}),
};
</script>

<style lang="postcss">
.m-nav-menu {
	@media (max-width: 1024px) {
		max-height: calc(100vh - 11rem);
		overflow-y: auto;
	}
	/* @media screen(m-lg) { */
	@media (max-width: 1024px) {
		position: absolute;
		width: 100%;
		background-color: #fcebe5;
		top: 100%;
		left: 0;
		padding-bottom: 5rem;
		border-radius: 0 0 1.5rem 1.5rem;
		transform: translateY(-120%);
		opacity: 0;
		transition: all 500ms ease-in-out;
		&.open {
			transform: none;
			opacity: 1;
		}
	}
}
.m-menu {
	display: flex;
	font-size: var(--p-font-size);
	column-gap: 1.8em;
	flex-direction: column;
	@media (max-width: 1024px) {
		border-bottom: 1px solid #ee8864;
	}
	.mt-link {
		/* font: 0.95em / 1 var(--font-work); */
		@apply text-[0.95em];
		@apply !font-workSans;
		display: block;
		padding: 0.5em 1.5em;
		color: var(--primary);
		@apply text-[#767676];
		position: relative;
		@media (max-width: 1024px) {
			@apply !pl-[2rem];
		}
		@media (min-width: 1700px) {
			@apply text-[1.6rem];
			&.prin {
				@apply text-[1.8rem];
			}
		}
	}
	&__item.with-child {
		position: relative;
		&:hover .m-dropdown {
			transform: none;
			opacity: 1;
			transition: opacity 400ms ease-in-out;
			pointer-events: auto;
			@media (max-width: 1200px) {
				max-height: 36rem;
				overflow-y: auto;
			}
		}
	}
	&__item:hover > .mt-link::before {
		width: 100%;
	}
	&__item-link {
		color: var(--gray-900);
	}
	&__item.with-child &__item-link::after {
		@media (min-width: 1200px) {
			content: '';
			width: 100%;
			height: 2.5em;
			position: absolute;
			top: 75%;
			display: block;
			z-index: 2;
		}
	}
	&__item {
		@apply relative;
		&.iconActive {
			.icon-menu-mobile {
				@apply rotate-90;
				transition: transform 350ms ease-in-out;
			}
		}
	}
	@media (max-width: 1024px) {
		&__item {
			border-top: 1px solid #ee8864;
			width: 100%;
		}
	}
	@media (min-width: 1025px) {
		flex-direction: row;
		.mt-link {
			padding: 0 0.2em;
			display: initial;
		}
		.mt-link::before {
			content: '';
			width: 0;
			height: 0.5em;
			position: absolute;
			background-color: rgba(73, 164, 180, 0.4);
			left: 0;
			bottom: 0;
			display: block;
			transition: width 400ms ease-in-out;
		}
		.current-active.exact-current.mt-link::before,
		.productActive.mt-link::before,
		.serviceActive.mt-link::before {
			width: 100%;
		}
		.current-active.exact-current.hoverTwo {
			@apply !text-green-two !font-semibold;
			.prim path {
				@apply !fill-green-two;
			}
		}
	}
	.current-active.exact-current.hoverTwo {
		@apply !text-green-two !font-semibold;
		.prim path {
			@apply !fill-green-two;
		}
	}
}
.m-dropdown {
	display: none;
	@media (min-width: 1200px) {
		@apply !border-none;
	}
	&.open {
		display: block;
	}
	&__item {
		padding: 0 1em;
		@apply relative pt-[.8em] leading-[1.1] !font-medium;
		&-link {
			@apply !font-medium;
		}
		&:last-child {
			padding-bottom: 0.8em;
		}
		/* @media (max-width: 1024px) {
			border-bottom: 1px solid #ee8864;
		} */
		@media (min-width: 1200px) {
			&:first-child {
				padding-top: 1.8em;
			}
			&:last-child {
				padding-bottom: 1.8em;
			}
		}
		@media (min-width: 1200px) {
			@apply flex items-center justify-center;
		}
	}
	@media (max-width: 1024px) {
		overflow: hidden;
	}
	@media (min-width: 1025px) {
		background-color: white;
		top: 46px;
		@media (min-width: 1400px) {
			@apply top-[47px];
		}
		@media (min-width: 1700px) {
			@apply top-[50px];
		}
		/* left: -85%; */
		left: 50%;
		transform: translateX(-50%) !important;
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
		border-radius: 10px 0px 0px 10px;
		min-width: max-content;
		display: flex;
		flex-direction: column;
		position: relative;
		&__item {
			padding: 0 3rem;
			@apply pt-[1em] leading-[1.1] w-[29ch] pr-[4.5rem];
			@media (min-width: 1700px) {
				@apply w-[25ch];
			}
			&-link {
				@apply !font-medium;
			}
		}
		&__item:hover .m-subdropdwon {
			transform: none;
			opacity: 1;
			transition: opacity 400ms ease-in-out;
			pointer-events: auto;
		}
		/* &__item:hover > .mt-link::before {
			width: 100%;
		} */
		&__item:hover > .hoverTwo {
			@apply !text-green-two !font-semibold;
		}
		&__item:hover {
			.prim path {
				@apply !fill-green-two;
			}
		}
		.current-active.exact-current.mt-link::before {
			width: 0 !important;
		}
	}
}
.m-subdropdwon {
	display: none;
	/* @media (max-width: 1024px) {
		@apply flex flex-col gap-[10px];
	} */
	&.open {
		/* display: block; */
		@media (max-width: 1024px) {
			@apply flex flex-col gap-[10px];
		}
	}
	&__item {
		/* padding: 0.5em 2.5rem;
		@apply relative; */
		padding: 0 1em;
		@apply relative pt-[.8em] leading-[1.1];
		@media (min-width: 1200px) {
			padding: 0.4em 4.5em;
		}
		@media (min-width: 1200px) {
			&:first-child {
				padding-top: 1.8em;
			}
			&:last-child {
				padding-bottom: 1.8em;
			}
		}
		&-link {
			@apply !font-normal;
		}
		@media (min-width: 1200px) {
			@apply flex items-center justify-start;
		}
	}
	@media (max-width: 1024px) {
		overflow: hidden;
		/* height: 0; */
	}
	@media (min-width: 1025px) {
		background-color: white;
		top: 225%;
		left: -85%;
		/* left: 50%;
		transform: translateX(-50%) !important; */
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
		/* border: 1px solid #e2e2e2; */
		min-width: max-content;
		display: flex;
		flex-direction: column;
		position: relative;
		border-radius: 0px 0px 10px 10px;
		&__item {
			/* padding: 0.4em 4.5rem; */
			padding: 0 3rem;
			@apply pt-[.7em] w-[26ch] leading-[1.1] pr-[4.5rem];
			@media (min-width: 1400px) {
				@apply w-[25ch];
			}
			@media (min-width: 1700px) {
				@apply w-[24ch];
			}
			&-link {
				@apply !text-[#767676] !font-normal;
			}
		}
		&__item:hover .m-subdropdownlast {
			transform: none;
			opacity: 1;
			transition: opacity 400ms ease-in-out;
			pointer-events: auto;
		}
		/* &__item:hover > .mt-link::before {
			width: 100%;
		} */
		&__item:hover > .hoverTwo {
			@apply !text-green-two !font-semibold;
		}
		&__item:hover {
			.sec path {
				@apply !fill-green-two;
			}
		}
	}
}

.m-dropdown,
.m-subdropdwon,
.m-subdropdownlast {
	transition: border 210ms, height 210ms, opacity 400ms, transform 210ms, -webkit-transform 210ms;
	@media (min-width: 1025px) {
		opacity: 0;
		pointer-events: none;
		z-index: 1;
		position: absolute;
		transform: translateY(1rem);
		transition: opacity 400ms, transform 210ms, -webkit-transform 210ms;
		@apply min-h-[100%];
	}
}

.m-subdropdwon {
	@apply bg-transparent;
	@media (min-width: 1200px) {
		@apply bg-[#f9fafb];
	}
	/* min-width: 30ch; */
	left: 34.1rem;
	@media (min-width: 1200px) {
		@apply left-[22.5rem];
	}
	@media (min-width: 1400px) {
		@apply left-[25.7rem];
	}
	@media (min-width: 1700px) {
		@apply left-[26.3rem];
	}
	top: 0px;
	&.stack-over {
		/* min-width: 60ch; */
		display: grid;
		column-gap: 1rem;
		/* grid-template-columns: repeat(2, 1fr); */
	}
	&__item-link {
		font: calc(var(--p-font-size) - 2px) / 1.25;
		@apply !font-workSans;
		display: flex;
		align-items: center;
		@apply relative;
		@apply !text-[#767676];
		&:hover::after {
			background-color: var(--primary);
		}
		padding: 0 !important;
	}
	/* @media screen(m-lg) {
		display: none !important;
	} */
}
.m-subdropdownlast {
	background-color: #f9fafb;
	/* padding: 4rem 5rem; */
	min-width: max-content;
	left: 26.7rem;
	@media (min-width: 1200px) {
		@apply left-[20.1rem];
	}
	@media (min-width: 1400px) {
		@apply left-[22.2rem];
	}
	@media (min-width: 1700px) {
		@apply left-[25.2rem];
	}
	top: 0;
	&.stack-over {
		min-width: 60ch;
		display: grid;
		column-gap: 1rem;
		grid-template-columns: repeat(2, 1fr);
	}
	&__item {
		padding: 0.6em 0;
		@apply w-[32ch] leading-[1.1];
		@media (min-width: 1400px) {
			@apply w-[32ch];
		}
		@media (min-width: 1700px) {
			@apply w-[29ch];
		}
		padding: 0 1em;
		@apply pt-[.8em];
		/* @media (min-width: 1200px) {
			padding: 0.4em 4.5em;
		} */
		&:first-child {
			padding-top: 1.8em;
		}
		&:last-child {
			padding-bottom: 1.8em;
		}
		&-link {
			@apply !font-normal;
		}
	}
	&__item-link {
		font: calc(var(--p-font-size) - 2px) / 1.25 var(--font-work);
		@apply !font-workSans;
		display: flex;
		align-items: center;
		@apply relative;
		&:hover::after {
			background-color: var(--primary);
		}
		padding: 0 !important;
	}
	@media (max-width: 1024px) {
		display: none !important;
	}
	@media (min-width: 1025px) {
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
		border-radius: 0px 10px 10px 0px;
		/* &__item:hover > .mt-link::before {
			width: 100%;
		} */
		&__item:hover > .hoverTwo {
			@apply !text-green-two !font-semibold;
		}
		&__item:hover {
			path {
				@apply !fill-green-two;
			}
		}
		&__item {
			padding: 0 3rem;
			@apply pt-[.8em] leading-[1.1];
			&-link {
				@apply !text-[#767676] !font-normal;
			}
		}
	}
}

.icon-menu-laptop {
	@apply hidden;
	@media (min-width: 1200px) {
		@apply absolute right-[-1.3rem] top-[50%] flex items-center justify-center;
		path {
			@apply !fill-[#767676];
		}
		transform: translateY(-50%);
	}
}
.icon-menu-mobile {
	@apply absolute right-[3rem] top-[1.5rem] flex items-center justify-center rotate-0;
	transition: transform 350ms ease-in-out;
	&.openIcono {
		@apply rotate-90;
		transition: transform 400ms ease-in-out;
	}
	&-two {
		@apply absolute right-[3rem] top-[2.3rem] flex items-center justify-center rotate-0;
		transition: transform 400ms ease-in-out;
		&.openIconoTwo {
			@apply rotate-90;
			transition: transform 400ms ease-in-out;
		}
	}
	@media (min-width: 1025px) {
		@apply hidden;
		&-two {
			@apply hidden;
		}
	}
}
</style>
