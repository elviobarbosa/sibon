export default class Unforgettable {
  constructor() {
    this.section = document.querySelector('.unforgettable');
    if (!this.section) return;

    this.images = this.section.querySelectorAll('.unforgettable__image');
    this.glows = this.section.querySelectorAll('.unforgettable__glow');
    this.ticking = false;

    this.init();
  }

  init() {
    window.addEventListener('scroll', () => {
      if (!this.ticking) {
        requestAnimationFrame(() => {
          this.updateParallax();
          this.ticking = false;
        });
        this.ticking = true;
      }
    }, { passive: true });

    // Executar uma vez no load
    this.updateParallax();
  }

  updateParallax() {
    const rect = this.section.getBoundingClientRect();
    const windowHeight = window.innerHeight;
    if (rect.bottom < 0 || rect.top > windowHeight) return;

    const progress = (windowHeight - rect.top) / (windowHeight + rect.height);
    const ranges = [24, 36, 16];

    this.images.forEach((figure, i) => {
      const img = figure.querySelector('img');
      if (!img) return;
      const offset = (progress - 0.5) * ranges[i];
      img.style.transform = `translateY(${offset}px)`;
    });
  }
}
