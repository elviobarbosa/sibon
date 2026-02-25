<section class="hero-spline-wrapper">
  <div class="hero-spline-sticky">

    <canvas id="hero-ocean-canvas"></canvas>

    <div class="hero-spline-text hero-spline-text-1">
      <h1 class="heading-hero">
        <span class="heading-hero__eyebrow">Enjoy the</span>
        <span class="heading-hero__main">Wildest nature</span>
      </h1>
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
  background: #70c7f1; /* boat section colour — visible during bg fade-out */
  z-index: 1;
}

.hero-spline-sticky {
  position: sticky;
  top: 0;
  height: 100vh;
  width: 100%;
  overflow: hidden;
  background: #0d2454; /* deep ocean blue — matches Three.js sky zenith */
}

/* ── Canvas ────────────────────────────────────────────────────────────────── */
#hero-ocean-canvas {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  display: block;
}

/* ── Text containers ───────────────────────────────────────────────────────── */
.hero-spline-text {
  position: absolute;
  top: 50%;
  left: 50%;
  /* transform is driven entirely by JS — initial state set here */
  transform: translate(-50%, -50%);
  text-align: center;
  width: 100%;
  max-width: 1100px;
  padding: 0 32px;
  pointer-events: none;
  z-index: 10;
  box-sizing: border-box;
  will-change: opacity, transform;
}

.hero-spline-text-1 { opacity: 1; }
.hero-spline-text-2 { opacity: 0; transform: translate(-50%, calc(-50% + 30px)); }

/* ── Typography — matches site's eyebrow + TT Moons highlight pattern ──────── */
.heading-hero {
  margin: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
}

.heading-hero__eyebrow {
  display: block;
  font-family: var(--body-font, "Avenir Next Condensed", sans-serif);
  font-weight: 200;
  font-size: clamp(0.7rem, 1.6vw, 1rem);
  letter-spacing: 0.45em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.65);
  /* subtle separator below eyebrow */
  padding-bottom: 10px;
  position: relative;
}

.heading-hero__eyebrow::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 24px;
  height: 1px;
  background: rgba(255, 255, 255, 0.35);
}

.heading-hero__main {
  display: block;
  font-family: var(--heading-font, "TT Moons", serif);
  font-style: italic;
  font-weight: 400;
  font-size: clamp(3.2rem, 9.5vw, 7.5rem);
  line-height: 0.92;
  color: #fff;
  text-shadow:
    0 2px 40px rgba(0, 0, 0, 0.25),
    0 0 100px rgba(0, 148, 192, 0.18);
}
</style>
