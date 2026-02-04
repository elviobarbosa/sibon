export default class RandomImages {
  constructor() {
    this.container = document.querySelector('.random-images[data-parallax]');
    if (!this.container) return;

    this.figure = this.container.querySelector('.random-images__figure');
    if (!this.figure) return;

    this.ticking = false;
    this.isVisible = false;

    this.init();
  }

  init() {
    // Intersection Observer para só processar quando visível
    const observer = new IntersectionObserver(
      (entries) => {
        this.isVisible = entries[0].isIntersecting;
      },
      { rootMargin: '100px' }
    );
    observer.observe(this.container);

    window.addEventListener('scroll', () => this.onScroll(), { passive: true });
  }

  onScroll() {
    if (!this.isVisible || this.ticking) return;

    this.ticking = true;
    requestAnimationFrame(() => {
      this.updateParallax();
      this.ticking = false;
    });
  }

  updateParallax() {
    const rect = this.container.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    // Calcula progresso: 0 quando entra por baixo, 1 quando sai por cima
    const progress = 1 - (rect.bottom / (windowHeight + rect.height));

    // Move a imagem de -15% a +15% (30% de range total)
    const translateY = progress * 30 - 15;

    this.figure.style.transform = `translateY(${translateY}%)`;
  }
}
