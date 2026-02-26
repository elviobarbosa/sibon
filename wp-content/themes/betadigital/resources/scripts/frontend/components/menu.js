export default class Menu {
  constructor() {
    this.selector = ".js-menu";
    this.classes = {
      navContainer: ".nav-container",
    };
    this.init();
  }

  init() {
    // Header transparente no hero — não depende do menu element
    this._setupHeroHeader();
    this._setupHeroParallaxHeader();

    const menu = document.querySelector(this.selector);
    if (!menu) return;

    menu.addEventListener("click", (e) => {
      e.preventDefault();
      const target = e.currentTarget;
      const navMenu = document.querySelector(".js-nav-menu");
      const logo = document.querySelector(".nav-container__logo");
      target.classList.toggle("active");
      navMenu.classList.toggle("active");
      logo.classList.toggle("opacity-0");
    });
  }

  _setupHeroHeader() {
    const nav           = document.querySelector(this.classes.navContainer);
    const hero          = document.querySelector('.hero-spline-wrapper');
    const unforgettable = document.querySelector('.unforgettable');

    // Só ativa se ambas as seções existirem nesta página
    if (!nav || !hero || !unforgettable) return;

    // Estado inicial: hero visível → header transparente
    nav.classList.add('nav--hero');

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(({ isIntersecting, boundingClientRect }) => {
          if (isIntersecting) {
            // Entrou em unforgettable → remove hero state → header opaco
            nav.classList.remove('nav--hero');
          } else if (boundingClientRect.top > 0) {
            // Seção ainda abaixo do viewport → user voltou ao hero → transparente
            nav.classList.add('nav--hero');
          }
          // top < 0: seção passou acima → user está em seções posteriores → mantém opaco
        });
      },
      { threshold: 0 }
    );

    observer.observe(unforgettable);
  }

  _setupHeroParallaxHeader() {
    const nav      = document.querySelector(this.classes.navContainer);
    const boatSection = document.querySelector('.hero-parallax__section--boat');

    if (!nav || !boatSection) return;

    // Estado inicial: seção visível → header transparente
    nav.classList.add('nav--hero');

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(({ isIntersecting, boundingClientRect }) => {
          if (isIntersecting) {
            // Seção do barco visível → transparente
            nav.classList.add('nav--hero');
          } else if (boundingClientRect.top < 0) {
            // Seção passou acima → user scrollou para baixo → opaco
            nav.classList.remove('nav--hero');
          } else {
            // Seção ainda abaixo → voltou ao topo → transparente
            nav.classList.add('nav--hero');
          }
        });
      },
      { threshold: 0 }
    );

    observer.observe(boatSection);
  }
}
