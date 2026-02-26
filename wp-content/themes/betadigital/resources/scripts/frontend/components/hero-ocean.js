import { Application } from '@splinetool/runtime';
import { createTimeline, stagger } from 'animejs';

/* ─────────────────────────────────────────────────────────────────────────────
   EASING
───────────────────────────────────────────────────────────────────────────── */
function easeInOutCubic(t) {
  return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
}

/* ─────────────────────────────────────────────────────────────────────────────
   CLASS
───────────────────────────────────────────────────────────────────────────── */
export default class HeroOcean {
  constructor() {
    this.canvas  = document.getElementById('hero-ocean-canvas');
    this.wrapper = document.querySelector('.hero-spline-wrapper');
    this.sticky  = document.querySelector('.hero-spline-sticky');
    this.text1      = document.querySelector('.hero-spline-text-1');
    this.text2      = document.querySelector('.hero-spline-text-2');
    this.scrollHint = document.getElementById('hero-scroll-hint');

    if (!this.canvas || !this.wrapper) return;

    // Split both texts into animatable chars up-front
    this._splitChars(this.text1);
    this._splitChars(this.text2);

    this._setupSpline();
    this._setupScroll();
  }

  /* ── Spline ──────────────────────────────────────────────────────────────── */
  _setupSpline() {
    try {
      this.canvas.width  = window.innerWidth;
      this.canvas.height = window.innerHeight;

      this.app = new Application(this.canvas);
      this.app
        .load('https://prod.spline.design/P4JYFhIRNqk-BQ4O/scene.splinecode')
        .then(() => this._removeWatermark())
        .catch((err) => console.warn('[HeroOcean] Spline load error:', err));

      this._removeWatermark();
      this._setupVisibility();
    } catch (err) {
      console.warn('[HeroOcean] Spline init error:', err);
    }
  }

  /* ── Pause/resume Spline when section leaves/enters viewport ─────────────── */
  _setupVisibility() {
    if (!this.wrapper || !this.app) return;
    this._splineStopped = false;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (!this.app) return;
          if (entry.isIntersecting) {
            if (this._splineStopped) {
              this.app.play();
              this._splineStopped = false;
            }
          } else {
            if (!this._splineStopped) {
              this.app.stop();
              this._splineStopped = true;
            }
          }
        });
      },
      // 200px de buffer: resume um pouco antes do usuário ver a seção de volta
      { rootMargin: '200px' }
    );

    observer.observe(this.wrapper);
    this._visibilityObserver = observer;
  }

  /* ── Watermark removal ───────────────────────────────────────────────────── */
  _removeWatermark() {
    const SELECTORS = [
      'a[href*="spline.design"]',
      '#logo',
      '#spline-logo',
      '.spline-watermark',
      '[data-logo]',
    ];
    const kill = () => {
      SELECTORS.forEach(sel => {
        document.querySelectorAll(sel).forEach(el => {
          el.style.cssText +=
            ';display:none!important;opacity:0!important;pointer-events:none!important;';
        });
      });
    };

    kill();

    if (this._wmObserver) return;
    this._wmObserver = new MutationObserver(kill);
    this._wmObserver.observe(document.body, { childList: true, subtree: true });
    setTimeout(() => {
      if (this._wmObserver) { this._wmObserver.disconnect(); this._wmObserver = null; }
    }, 12000);
  }

  /* ── Char splitting — same logic as TextAnimation ───────────────────────── */
  _splitChars(container) {
    if (!container) return;
    container.querySelectorAll('.heading-hero__eyebrow, .heading-hero__main').forEach(span => {
      const text = span.textContent.trim();
      span.innerHTML = '';

      text.split(' ').forEach((word, wi, arr) => {
        const wordEl = document.createElement('span');
        wordEl.style.cssText = 'display:inline-block;white-space:nowrap;';

        word.split('').forEach(char => {
          const charEl = document.createElement('span');
          charEl.className = 'char';
          charEl.textContent = char;
          charEl.style.cssText = 'display:inline-block;opacity:0;';
          wordEl.appendChild(charEl);
        });

        span.appendChild(wordEl);

        if (wi < arr.length - 1) {
          const space = document.createElement('span');
          space.className = 'char';
          space.textContent = '\u00A0';
          space.style.cssText = 'display:inline-block;opacity:0;';
          span.appendChild(space);
        }
      });
    });
  }

  /* ── Char animation — same params as TextAnimation.animateIn ─────────────── */
  _animateIn(container) {
    if (!container) return;
    const chars = container.querySelectorAll('.char');
    if (!chars.length) return;

    chars.forEach(c => {
      c.style.opacity   = '0';
      c.style.transform = 'translateY(100px) scale(0.2) rotate(90deg)';
      c.style.filter    = 'blur(15px)';
    });

    createTimeline({
      defaults: { ease: 'out(4)' },
      onComplete: () => {
        // Limpa filter e will-change após animação — libera compositing layers
        chars.forEach(c => {
          c.style.filter     = '';
          c.style.willChange = 'auto';
        });
      },
    }).add(chars, {
      opacity:    [0, 1],
      translateY: [100, 0],
      scale:      [0.2, 1],
      rotate:     [90, 0],
      filter:     ['blur(15px)', 'blur(0px)'],
      duration:   1400,
      delay:      stagger(60),
    });
  }

  /* ── Scroll-driven animation ─────────────────────────────────────────────── */
  _setupScroll() {
    var self      = this;
    var SLIDE     = 30;
    var text1Done = false;
    var text2Done = false;
    var ticking   = false;
    var winH      = window.innerHeight; // cacheado — atualizado só no resize
    var lastRaw   = -1;                 // evita writes repetidos quando o raw não mudou

    // Background nunca muda — define uma vez só
    self._bg('rgb(112,199,242)');

    function update() {
      if (!self.wrapper) return;
      var rect  = self.wrapper.getBoundingClientRect();
      var total = rect.height - winH;
      if (total <= 0) return;

      // Seção completamente acima do viewport — nada a fazer
      if (rect.bottom < 0) return;

      var raw = Math.max(0, Math.min(1, -rect.top / total));

      // Pula se o progresso não mudou de forma perceptível
      if (Math.abs(raw - lastRaw) < 0.0005) return;
      lastRaw = raw;

      var p, e;

      if (raw < 0.20) {
        // ── Phase 1: text1 + scroll hint fully visible ──
        if (!text1Done) { text1Done = true; self._animateIn(self.text1); }
        self._container(self.text1, 1, 0);
        self._container(self.text2, 0, SLIDE);
        self._hint(1);
        self._canvasOpacity(1);

      } else if (raw < 0.35) {
        // ── Phase 2: text1 + scroll hint fade up and out ──
        if (!text1Done) { text1Done = true; self._animateIn(self.text1); }
        p = easeInOutCubic(1 - (raw - 0.20) / 0.15);
        self._container(self.text1, p, -(1 - p) * 16);
        self._container(self.text2, 0, SLIDE);
        self._hint(p);
        self._canvasOpacity(1);

      } else if (raw < 0.50) {
        // ── Phase 3: empty stage — hint gone ──
        self._container(self.text1, 0, -16);
        self._container(self.text2, 0, SLIDE);
        self._hint(0);
        self._canvasOpacity(1);

      } else if (raw < 0.80) {
        // ── Phase 4+5: text2 reveals via char animation ──
        if (!text2Done) {
          text2Done = true;
          self._container(self.text2, 1, 0);
          self._animateIn(self.text2);
        }
        self._container(self.text1, 0, -16);
        self._canvasOpacity(1);

      } else {
        // ── Phase 6: everything fades, boat section emerges ──
        e = easeInOutCubic(1 - (raw - 0.80) / 0.20); // 1 → 0
        self._container(self.text1, 0, -16);
        self._container(self.text2, e, -(1 - e) * 16);
        self._canvasOpacity(e);
      }
    }

    // rAF throttle: garante no máximo 1 update por frame de animação
    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(() => {
          update();
          ticking = false;
        });
        ticking = true;
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', () => {
      winH = window.innerHeight; // atualiza cache
      if (this.canvas) {
        this.canvas.width  = window.innerWidth;
        this.canvas.height = winH;
      }
      lastRaw = -1; // força re-render com novo winH
      update();
    }, { passive: true });
    update();
  }

  // Sets opacity + translateY on the TEXT CONTAINER (not the individual chars)
  _container(el, opacity, translateY) {
    if (!el) return;
    el.style.opacity   = String(Math.max(0, Math.min(1, opacity)));
    el.style.transform = 'translate(-50%, calc(-50% + ' + translateY + 'px))';
  }

  _hint(v) {
    if (this.scrollHint) this.scrollHint.style.opacity = String(Math.max(0, Math.min(1, v)));
  }

  _canvasOpacity(v) {
    if (this.canvas) this.canvas.style.opacity = String(Math.max(0, Math.min(1, v)));
  }

  _bg(color) {
    if (this.sticky) this.sticky.style.background = color;
  }

}
