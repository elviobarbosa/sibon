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

    // Só processa se a seção está visível
    if (rect.bottom < 0 || rect.top > windowHeight) return;

    // Calcula o progresso do scroll dentro da seção
    const scrolled = windowHeight - rect.top;

    // Parallax nas imagens - cada uma com velocidade diferente
    this.images.forEach((image) => {
      const speed = parseFloat(image.dataset.parallaxSpeed) || 0.2;
      const translateY = -(scrolled * speed);

      // Preservar translateX para imagem centralizada (--2)
      if (image.classList.contains('unforgettable__image--2')) {
        image.style.transform = `translateX(-50%) translateY(${translateY}px)`;
      } else {
        image.style.transform = `translateY(${translateY}px)`;
      }
    });

    // Movimento sutil nos glows baseado no scroll
    const glowOffset = scrolled * 0.05;
    this.glows.forEach((glow, index) => {
      const direction = index === 0 ? 1 : -1;
      glow.style.transform = `translate(${glowOffset * direction}px, ${glowOffset * 0.5 * direction}px)`;
    });
  }
}
