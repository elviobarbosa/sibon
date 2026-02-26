<section class="hero-spline-wrapper">
  <div class="hero-spline-sticky">

    <canvas id="hero-ocean-canvas"
      data-ocean-texture="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/ocean@1-2131x1000.jpg'); ?>">
    </canvas>

    <div class="hero-spline-text hero-spline-text-1">
      <h1 class="heading-hero">
        <span class="heading-hero__eyebrow">INTO THE BLUE</span>
        <span class="heading-hero__main">Private waves wait</span>
      </h1>
    </div>

    <div class="hero-scroll-hint" id="hero-scroll-hint" aria-hidden="true">
      <span class="hero-scroll-hint__label">Scroll down</span>
      <div class="hero-scroll-hint__track">
        <div class="hero-scroll-hint__line"></div>
        <div class="hero-scroll-hint__chevron"></div>
      </div>
    </div>

    <div class="hero-spline-text hero-spline-text-2">
      <h2 class="heading-hero">
        <span class="heading-hero__eyebrow">Experience the</span>
        <span class="heading-hero__main">Adventure<br>of a lifetime</span>
      </h2>
    </div>

  </div>
</section>

<!-- Third fold — Boat -->
<div class="hero-parallax__section hero-parallax__section--boat">
  <h2 class="hero-parallax__title">
    <span class="hero-parallax__title-line hero-parallax__title-line--headline animate-text">Surfing</span>
    <span class="hero-parallax__title-line hero-parallax__title-line--highlight animate-text">In the paradise</span>
  </h2>
  <div class="hero-parallax__boat-image">
    <div id="water-effect-container"
      data-boat-image="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-baru-jaya-cover.jpg'); ?>"
      data-water-mask="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/sibon-water-mask.png'); ?>">
    </div>
    <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/hero-parallax-boats.png'); ?>"
      alt="Sibon boats" class="hero-parallax__boat-overlay" fetchpriority="high">
    <div class="hero-parallax__boat-select">
      <select class="hero-parallax__experience-select" onchange="if(this.value) window.location.href=this.value">
        <option value="" selected disabled>CHOOSE YOUR SIBON EXPERIENCE</option>
        <option value="<?php echo esc_url(home_url('/sibon-baru')); ?>">Sibon Baru</option>
        <option value="<?php echo esc_url(home_url('/sibon-jaya')); ?>">Sibon Jaya</option>
      </select>
      <svg class="hero-parallax__select-arrow" xmlns="http://www.w3.org/2000/svg" width="12" height="8"
        viewBox="0 0 12 8" fill="none">
        <path d="M1 1L6 6L11 1" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>
  </div>
</div>

<style>
/* ── Wrapper & sticky ──────────────────────────────────────────────────────── */
.hero-spline-wrapper {
  position: relative;
  height: 300vh;
  width: 100%;
  background: #70c7f2;
  /* boat section colour — visible during bg fade-out */
  z-index: 1;
}

.hero-spline-sticky {
  position: sticky;
  top: 0;
  height: 110vh;
  width: 100%;
  overflow: hidden;
  background: #70c7f2;
  /* bright sky cyan — matches Three.js sky uMid */
}

/* ── Canvas ────────────────────────────────────────────────────────────────── */
#hero-ocean-canvas {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  display: block;
  /* Disable pointer events so the Spline canvas never captures scroll/touch */
  pointer-events: none;
}

/* ── Spline watermark suppression ──────────────────────────────────────────── */
a[href*="spline.design"],
#logo,
#spline-logo,
.spline-watermark,
[data-logo] {
  display: none !important;
  opacity: 0 !important;
  pointer-events: none !important;
}

/* ── Text containers ───────────────────────────────────────────────────────── */
.hero-spline-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  width: 100%;
  max-width: 1100px;
  padding: 0 32px;
  pointer-events: none;
  z-index: 1000;
  box-sizing: border-box;
  will-change: opacity, transform;
}

.hero-spline-text-1 {
  opacity: 1;
}

.hero-spline-text-2 {
  opacity: 0;
}

/* ── Typography — mirrors .hero-parallax__title styling ─────────────────────── */
.heading-hero {
  font-size: clamp(2.5rem, 8vw, 6rem);
  color: #fff;
  line-height: 0.8;
  margin: 0;
  letter-spacing: -0.02em;
  text-shadow:
    0 2px 12px rgba(0, 40, 80, 0.30),
    0 8px 40px rgba(0, 60, 100, 0.35);
}

/* Mirrors .hero-parallax__title-line--headline */
.heading-hero__eyebrow {
  display: block;
  font-family: var(--body-font, "Avenir Next Condensed", sans-serif) !important;
  font-weight: 100;
  text-transform: uppercase;
  font-style: normal;
}

/* Mirrors .hero-parallax__title-line--highlight */
.heading-hero__main {
  display: block;
  font-style: italic;
}

/* ── Scroll hint ─────────────────────────────────────────────────────────── */
.hero-scroll-hint {
  position: absolute;
  bottom: 25%;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  pointer-events: none;
  will-change: opacity;
}

.hero-scroll-hint__label {
  font-family: var(--body-font, "Avenir Next Condensed", sans-serif);
  font-weight: 100;
  font-size: clamp(0.5rem, 1.1vw, 0.7rem);
  letter-spacing: 0.55em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.75);
  text-shadow: 0 1px 10px rgba(0, 40, 80, 0.45);
  /* nudge right to compensate letter-spacing on last char */
  padding-left: 0.55em;
}

.hero-scroll-hint__track {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0;
  animation: scrollHintFloat 2.2s ease-in-out infinite;
}

.hero-scroll-hint__line {
  width: 1px;
  height: 32px;
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.7) 100%);
}

.hero-scroll-hint__chevron {
  width: 8px;
  height: 8px;
  border-right: 1px solid rgba(255, 255, 255, 0.75);
  border-bottom: 1px solid rgba(255, 255, 255, 0.75);
  transform: rotate(45deg);
  margin-top: -2px;
}

@keyframes scrollHintFloat {
  0% {
    opacity: 0.5;
    transform: translateY(-5px);
  }

  50% {
    opacity: 1;
    transform: translateY(4px);
  }

  100% {
    opacity: 0.5;
    transform: translateY(-5px);
  }
}

/* Char spans injected by JS animation */
.heading-hero .char {
  display: inline-block;
  will-change: transform, opacity;
}
</style>