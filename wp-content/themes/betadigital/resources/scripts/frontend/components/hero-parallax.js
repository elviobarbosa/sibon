export default class HeroParallax {
  constructor() {
    this.setupParallax();
  }

  setupParallax() {
    const firstSection = document.querySelector('.hero-parallax__section--first');
    const secondSection = document.querySelector('.hero-parallax__section--second');

    if (!firstSection || !secondSection) return;

    const firstContent = firstSection.querySelector('.hero-parallax__content');
    const secondContent = secondSection.querySelector('.hero-parallax__content');

    if (secondContent) {
      secondContent.style.opacity = 0;
    }

    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;
      const windowHeight = window.innerHeight;

      // First section - fade out on scroll
      if (scrollY < windowHeight && firstContent) {
        const opacity = 1 - (scrollY / windowHeight);
        firstContent.style.opacity = opacity;
        firstContent.style.transform = `translateY(${scrollY * 0.3}px)`;
      }

      // Second section - fade in/out
      if (scrollY >= windowHeight * 0.5 && scrollY < windowHeight * 2 && secondContent) {
        const progress = (scrollY - windowHeight * 0.5) / windowHeight;
        const opacity = progress < 0.5 ? progress * 2 : Math.max(0, 2 - progress * 2);
        secondContent.style.opacity = opacity;
      }
    });
  }
}
