import { Swiper, Navigation } from "swiper";

Swiper.use([Navigation]);

export default class FeatureSlide {
  constructor() {
    this.selector = ".feature-slide__swiper";
    this.init();
  }

  init() {
    const slider = document.querySelector(this.selector);
    if (!slider) return;
    this.initSwiper(slider);
  }

  initSwiper(sliderEl) {
    new Swiper(sliderEl, {
      slidesPerView: "auto",
      centeredSlides: false,
      spaceBetween: 60,
      speed: 600,
      loop: true,
      slidesOffsetBefore: 80,
      navigation: {
        nextEl: ".feature-slide__btn--next",
        prevEl: ".feature-slide__btn--prev",
      },
      breakpoints: {
        768: {
          spaceBetween: 50,
          slidesOffsetBefore: 80,
        },
      },
    });
  }
}
