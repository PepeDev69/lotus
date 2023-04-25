import Vue from 'vue';

import ButtonGeneral from '~/components/atoms/ButtonGeneral.vue';
import BaseButton from '~/components/atoms/BaseButton.vue';
import Titles from '~/components/atoms/Titles.vue';
import SocialMedia from '~/components/molecules/SocialMedia.vue';
import Information from '~/components/molecules/Information.vue';
import AppContainer from '~/components/globals/AppContainer.vue';
import AppLayout from '~/components/globals/AppLayout.vue';
import FancyButton from '~/components/atoms/FancyButton.vue';
import Link from '~/components/atoms/Link.vue';
import AppLink from '~/components/globals/AppLink.vue';
import BaseInput from '~/components/atoms/BaseInput.vue';
import Breadcrumbs from '~/components/atoms/Breadcrumbs.vue';
import ArticleGeneral from '~/components/molecules/ArticleGeneral.vue';
import TitleArticle from '~/components/atoms/TitleArticle.vue';
import IconLoading from '~/components/atoms/icons/IconLoading.vue';
import AppSeoEngine from '~/components/globals/AppSeoEngine.vue';
import ArrowMenu from '~/components/atoms/ArrowMenu.vue';

Vue.component('ButtonGeneral', ButtonGeneral);
Vue.component('FancyButton', FancyButton);
Vue.component('BaseButton', BaseButton);
Vue.component('IconLoading', IconLoading);
Vue.component('Titles', Titles);
Vue.component('SocialMedia', SocialMedia);
Vue.component('Information', Information);
Vue.component('Link', Link);
Vue.component('BaseInput', BaseInput);
Vue.component('Breadcrumbs', Breadcrumbs);
Vue.component('ArticleGeneral', ArticleGeneral);
Vue.component('TitleArticle', TitleArticle);

Vue.component('AppContainer', AppContainer);
Vue.component('AppLayout', AppLayout);
Vue.component('AppLink', AppLink);
Vue.component('AppSeoEngine', AppSeoEngine);
Vue.component('ArrowMenu', ArrowMenu);
