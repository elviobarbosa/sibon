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
      centeredSlides: true,
      spaceBetween: 30,
      speed: 600,
      loop: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        768: {
          spaceBetween: 50,
        },
      },
    });
  }
}
