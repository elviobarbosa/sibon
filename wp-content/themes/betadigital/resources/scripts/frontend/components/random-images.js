export default class RandomImages {
  constructor() {
    this.container = document.querySelector('.random-images[data-parallax]');
    this.figure = document.querySelector('.random-images__figure');
    if (!this.container || !this.figure) return;

    this.speed = 0.3; // quanto menor, mais lento o parallax
    this.ticking = false;

    this.init();
  }

  isMobile() {
    return window.innerWidth < 768;
  }

  init() {
    if (this.isMobile()) return;

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
    const rect = this.container.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    // Só processa se visível
    if (rect.bottom < 0 || rect.top > windowHeight) return;

    // Calcula o offset baseado na posição do container
    const scrolled = windowHeight - rect.top;
    const translateY = -(scrolled * this.speed);

    this.figure.style.transform = `translateY(${translateY}px)`;
  }
}
