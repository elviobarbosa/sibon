import { Swiper, Navigation, Pagination } from "swiper";

Swiper.use([Navigation, Pagination]);

const BULLET_DEFAULT = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20.057" viewBox="0 0 20 20.057"><path d="M0,10.032l2.448-.587q2.718-.652,5.437-1.3a.239.239,0,0,0,.2-.217Q9,4.091,9.919.257C9.934.192,9.955.129,9.991,0c.036.121.059.185.075.251q.921,3.834,1.837,7.67a.264.264,0,0,0,.233.228q3.837.913,7.671,1.836a.413.413,0,0,1,.192.1c-.356.087-.712.175-1.068.261q-3.41.818-6.821,1.632a.24.24,0,0,0-.2.209q-.914,3.836-1.837,7.67a.451.451,0,0,1-.1.2c-.1-.4-.2-.807-.3-1.211q-.8-3.331-1.594-6.662a.252.252,0,0,0-.221-.216Q4.023,11.055.188,10.132C.125,10.116.063,10.1,0,10.077c0-.015,0-.03,0-.045" fill="none" stroke="#b78d00" stroke-width="1"/></svg>`;

const BULLET_ACTIVE = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20.057" viewBox="0 0 20 20.057"><path d="M0,10.032l2.448-.587q2.718-.652,5.437-1.3a.239.239,0,0,0,.2-.217Q9,4.091,9.919.257C9.934.192,9.955.129,9.991,0c.036.121.059.185.075.251q.921,3.834,1.837,7.67a.264.264,0,0,0,.233.228q3.837.913,7.671,1.836a.413.413,0,0,1,.192.1c-.356.087-.712.175-1.068.261q-3.41.818-6.821,1.632a.24.24,0,0,0-.2.209q-.914,3.836-1.837,7.67a.451.451,0,0,1-.1.2c-.1-.4-.2-.807-.3-1.211q-.8-3.331-1.594-6.662a.252.252,0,0,0-.221-.216Q4.023,11.055.188,10.132C.125,10.116.063,10.1,0,10.077c0-.015,0-.03,0-.045" fill="#4b9eff"/></svg>`;

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
      spaceBetween: 16,
      speed: 600,
      loop: true,
      slidesOffsetBefore: 16,
      navigation: {
        nextEl: ".feature-slide__btn--next",
        prevEl: ".feature-slide__btn--prev",
      },
      pagination: {
        el: ".feature-slide__pagination",
        clickable: true,
        renderBullet(_index, className) {
          return `<span class="${className}">
            <span class="bullet-default">${BULLET_DEFAULT}</span>
            <span class="bullet-active">${BULLET_ACTIVE}</span>
          </span>`;
        },
      },
      breakpoints: {
        768: {
          centeredSlides: false,
          spaceBetween: 50,
          slidesOffsetBefore: 80,
        },
      },
    });
  }
}
