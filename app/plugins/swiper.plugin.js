import Vue from 'vue';
import { Swiper as SwiperClass, Pagination, Navigation, Autoplay, EffectFade } from 'swiper';
import getSwiper from 'vue-awesome-swiper/dist/exporter';
SwiperClass.use([Pagination, Navigation, Autoplay, EffectFade]);
Vue.use(getSwiper(SwiperClass));
