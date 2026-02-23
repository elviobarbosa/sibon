import { animate } from "animejs";

export default class HeroCharters {
  constructor() {
    this.section = document.querySelector(".hero-charters");
    if (!this.section) return;

    this.images = this.section.querySelectorAll(".hero-charters__image");
    this.animated = false;

    this.init();
  }

  init() {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !this.animated) {
            this.animated = true;
            this.animateImages();
            observer.disconnect();
          }
        });
      },
      { threshold: 0.15 }
    );

    observer.observe(this.section);
  }

  animateImages() {
    const delays = [0, 150, 300, 450];

    this.images.forEach((image, index) => {
      animate(image, {
        opacity: [0, 1],
        translateY: [50, 0],
        duration: 900,
        delay: delays[index],
        ease: "outCubic",
      });
    });
  }
}
