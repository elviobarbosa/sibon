import { createTimeline, stagger } from 'animejs';

export default class CtaBoatAnimation {
  constructor() {
    this.sections = document.querySelectorAll('.cta-boat');
    if (!this.sections.length) return;

    this.sections.forEach(section => this.prepare(section));
    this.observe();
  }

  prepare(section) {
    section.classList.add('cta-boat--will-animate');
  }

  observe() {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          this.animateIn(entry.target);
          observer.unobserve(entry.target);
        });
      },
      {
        threshold: 0.2,
        // Aguarda o elemento estar 80px dentro da viewport antes de disparar
        rootMargin: '0px 0px -80px 0px',
      }
    );

    this.sections.forEach(section => observer.observe(section));
  }

  animateIn(section) {
    const isReversed  = section.classList.contains('cta-boat--reversed');
    const image       = section.querySelector('.cta-boat__image');
    const eyebrow     = section.querySelector('.cta-boat__eyebrow');
    const name        = section.querySelector('.cta-boat__name');
    const description = section.querySelector('.cta-boat__description');
    const specs       = section.querySelector('.cta-boat__specs');
    const cta         = section.querySelector('.btn');

    // Wipe: reversed → imagem à esquerda → cortina abre da direita
    const clipStart = isReversed ? 'inset(0 0 0 100%)' : 'inset(0 100% 0 0)';
    const clipEnd   = 'inset(0 0% 0 0%)';

    const tl = createTimeline({ defaults: { ease: 'out(3)' } });

    // ── 1. Imagem: wipe lento com leve zoom saindo do clip ──────────
    if (image) {
      tl.add(image, {
        clipPath: [clipStart, clipEnd],
        scale:    [1.06, 1],      // zoom out suave enquanto revela
        duration: 1800,
        ease:     'out(2)',
      }, 0);
    }

    // ── 2. Eyebrow: desliza do lado oposto à imagem ─────────────────
    if (eyebrow) {
      const xStart = isReversed ? -60 : 60;
      tl.add(eyebrow, {
        opacity:    [0, 1],
        translateX: [xStart, 0],
        duration:   900,
      }, 400);
    }

    // ── 3. Nome: emerge de baixo com impulso dramático ──────────────
    if (name) {
      tl.add(name, {
        opacity:    [0, 1],
        translateY: [100, 0],
        duration:   1100,
        ease:       'out(4)',
      }, 600);
    }

    // ── 4. Descrição ────────────────────────────────────────────────
    if (description) {
      tl.add(description, {
        opacity:    [0, 1],
        translateY: [40, 0],
        duration:   800,
      }, 950);
    }

    // ── 5. Specs: stagger item a item ───────────────────────────────
    if (specs) {
      const items = specs.querySelectorAll('li');
      tl.add(items.length ? items : specs, {
        opacity:    [0, 1],
        translateY: [24, 0],
        duration:   600,
        delay:      stagger(100),
      }, 1150);
    }

    // ── 6. CTA: escala + fade ───────────────────────────────────────
    if (cta) {
      tl.add(cta, {
        opacity:  [0, 1],
        scale:    [0.85, 1],
        duration: 600,
        ease:     'out(4)',
      }, 1400);
    }
  }
}
