import { createTimeline, stagger } from 'animejs';

export default class TextAnimation {
  constructor() {
    this.animatedTexts = [];
    this.init();
  }

  init() {
    // Seleciona todos os elementos com a classe de animação
    const textElements = document.querySelectorAll('.animate-text');

    if (textElements.length === 0) return;

    textElements.forEach(element => {
      this.splitTextByChar(element);
    });

    // Setup Intersection Observer para detectar quando elementos entram/saem da viewport
    this.setupScrollObserver();
  }

  splitTextByChar(element) {
    const text = element.textContent;
    element.innerHTML = '';

    // Criar spans para cada caractere
    const chars = text.split('').map((char, index) => {
      const span = document.createElement('span');
      span.textContent = char === ' ' ? '\u00A0' : char; // Preservar espaços
      span.style.display = 'inline-block';
      span.style.opacity = '0';
      span.className = 'char';
      span.dataset.index = index;
      return span;
    });

    chars.forEach(char => element.appendChild(char));

    // Armazenar referência
    this.animatedTexts.push({
      element,
      chars,
      isVisible: false,
      hasAnimatedIn: false,
      currentTimeline: null // referência para cancelar animações
    });
  }

  animateIn(textObj) {
    if (textObj.hasAnimatedIn) return;

    // Cancelar animação anterior se existir
    if (textObj.currentTimeline) {
      textObj.currentTimeline.pause();
      textObj.currentTimeline = null;
    }

    const chars = textObj.element.querySelectorAll('.char');

    // Resetar estado visual antes de animar
    chars.forEach(char => {
      char.style.opacity = '0';
      char.style.transform = 'translateY(100px) scale(0.2) rotate(90deg)';
      char.style.filter = 'blur(15px)';
    });

    const timeline = createTimeline({
      defaults: {
        ease: 'out(4)'
      }
    });

    timeline.add(chars, {
      opacity: [0, 1],
      translateY: [100, 0],
      scale: [0.2, 1],
      rotate: [90, 0],
      filter: ['blur(15px)', 'blur(0px)'],
      duration: 1400,
      delay: stagger(60),
    });

    textObj.currentTimeline = timeline;
    textObj.isVisible = true;
    textObj.hasAnimatedIn = true;
  }

  animateOut(textObj) {
    if (!textObj.isVisible) return;

    // Cancelar animação anterior se existir
    if (textObj.currentTimeline) {
      textObj.currentTimeline.pause();
      textObj.currentTimeline = null;
    }

    const chars = textObj.element.querySelectorAll('.char');

    const timeline = createTimeline({
      defaults: {
        ease: 'in(4)'
      }
    });

    timeline.add(chars, {
      opacity: [1, 0],
      translateY: [0, -100],
      scale: [1, 0.2],
      rotate: [0, -90],
      filter: ['blur(0px)', 'blur(15px)'],
      duration: 1000,
      delay: stagger(50),
    });

    textObj.currentTimeline = timeline;
    textObj.isVisible = false;
  }

  setupScrollObserver() {
    const options = {
      root: null,
      rootMargin: '-10% 0px -10% 0px', // Margem menor para detectar mais cedo
      threshold: 0.2 // Precisa ter 20% visível para animar
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;

        const textObj = this.animatedTexts.find(t => t.element === entry.target);
        if (!textObj) return;

        this.animateIn(textObj);
        observer.unobserve(entry.target); // anima apenas uma vez
      });
    }, options);

    // Observar todos os elementos
    this.animatedTexts.forEach(textObj => {
      observer.observe(textObj.element);
    });
  }
}
