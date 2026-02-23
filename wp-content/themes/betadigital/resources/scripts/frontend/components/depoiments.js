import { animate } from 'animejs';

// Entrance direction per line:
//  0 ("Guests")          → from right to left  (starts at +X, ends at 0)
//  1 ("Say About")       → from left to right  (starts at -X, ends at 0)
//  2 ("Sibon charters")  → from right to left  (starts at +X, ends at 0)
const ENTRANCE_SIGN = [1, -1, 1];   // positive = comes from right
const PARALLAX_SIGN = [-1, 1, -1];  // negative = moves left while scrolling

export default class Depoiments {
  constructor() {
    this.section = document.querySelector('.depoiments');
    if (!this.section) return;

    this.header  = this.section.querySelector('.depoiments__header');
    this.lines   = Array.from(this.section.querySelectorAll('.depoiments__title-line'));

    this.hasAnimatedIn   = false;
    this.parallaxReady   = false;
    this.baseScrolled    = 0;
    this.ticking         = false;

    this.init();
  }

  init() {
    // Hide lines before animation plays
    this.lines.forEach((line, i) => {
      line.style.opacity   = '0';
      line.style.transform = `translateX(${ENTRANCE_SIGN[i] * 140}px)`;
    });

    this.setupIntersectionObserver();
    this.setupScrollParallax();
  }

  setupIntersectionObserver() {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !this.hasAnimatedIn) {
            this.hasAnimatedIn = true;
            this.animateIn();
          }
        });
      },
      { threshold: 0.15 }
    );

    observer.observe(this.header || this.section);
  }

  animateIn() {
    const totalDuration = 900; // ms per line
    const staggerDelay  = 180; // ms between lines

    this.lines.forEach((line, i) => {
      animate(line, {
        opacity:    [0, 1],
        translateX: [ENTRANCE_SIGN[i] * 140, 0],
        duration:   totalDuration,
        delay:      i * staggerDelay,
        ease:       'out(3)',
      });
    });

    // Enable parallax after the last line finishes
    const readyAt = (this.lines.length - 1) * staggerDelay + totalDuration + 50;
    setTimeout(() => {
      const rect = this.section.getBoundingClientRect();
      this.baseScrolled  = window.innerHeight - rect.top;
      this.parallaxReady = true;
    }, readyAt);
  }

  setupScrollParallax() {
    window.addEventListener(
      'scroll',
      () => {
        if (!this.ticking) {
          requestAnimationFrame(() => {
            this.updateParallax();
            this.ticking = false;
          });
          this.ticking = true;
        }
      },
      { passive: true }
    );
  }

  updateParallax() {
    if (!this.parallaxReady) return;

    const rect         = this.section.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    if (rect.bottom < 0 || rect.top > windowHeight) return;

    const scrolled = windowHeight - rect.top;
    const delta    = scrolled - this.baseScrolled; // 0 at animation-complete moment

    this.lines.forEach((line, i) => {
      const speed  = 0.05 + i * 0.015; // slight speed variation per line
      const offset = delta * speed * PARALLAX_SIGN[i];
      line.style.transform = `translateX(${offset}px)`;
    });
  }
}
