import * as THREE from 'three';
import { createTimeline, stagger } from 'animejs';

/* ─────────────────────────────────────────────────────────────────────────────
   OCEAN SHADERS
   Vertex: wave displacement  |  Fragment: image texture + UV distortion
───────────────────────────────────────────────────────────────────────────── */
const OCEAN_VERT = `
  uniform float uTime;
  varying float vElevation;
  varying vec2  vUv;

  void main() {
    vec4 wPos = modelMatrix * vec4(position, 1.0);
    float x = wPos.x, z = wPos.z, t = uTime;

    float swell  = sin(x * 0.35 + t * 0.45) * cos(z * 0.30 + t * 0.38) * 0.42;
    float chop   = sin(x * 1.60 - z * 1.30 + t * 1.00) * 0.12;
    float ripple = sin(x * 4.50 + z * 3.50 + t * 2.20) * 0.022;

    float e = swell + chop + ripple;
    wPos.y += e;
    vElevation = e;
    vUv = uv;

    gl_Position = projectionMatrix * viewMatrix * wPos;
  }
`;

const OCEAN_FRAG = `
  uniform sampler2D uTexture;
  uniform float     uTime;
  uniform vec3      uFoam;
  uniform vec3      uSky;

  varying float vElevation;
  varying vec2  vUv;

  void main() {
    vec2 uv = vUv;

    // Tile 1.5× horizontally and scroll slowly (simulates flowing water)
    uv.x = fract(uv.x * 1.5 - uTime * 0.018);

    // Map vertical UV to the ocean portion of the image (bottom 55%)
    uv.y = 0.45 + uv.y * 0.55;

    // Wave UV distortion
    float norm = clamp((vElevation + 0.5) / 1.0, 0.0, 1.0);
    uv.x += sin(vUv.y * 12.0 + uTime * 1.2) * 0.018 * norm;
    uv.y += vElevation * 0.08;

    vec3 color = texture2D(uTexture, uv).rgb;

    // Foam on wave crests
    float foam = smoothstep(0.62, 0.88, norm);
    color = mix(color, uFoam, foam * 0.45);

    // Horizon brightening (fresnel-like)
    float fresnel = pow(1.0 - clamp(vUv.y, 0.0, 1.0), 2.5) * 0.22;
    color += uSky * fresnel;

    gl_FragColor = vec4(color, 1.0);
  }
`;

/* ─────────────────────────────────────────────────────────────────────────────
   SKY SHADERS — uniform #70c7f2 top
───────────────────────────────────────────────────────────────────────────── */
const SKY_VERT = `
  varying vec3 vWorldPos;
  void main() {
    vWorldPos = position;
    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
  }
`;

const SKY_FRAG = `
  uniform vec3 uZenith;
  uniform vec3 uMid;
  uniform vec3 uHorizon;
  uniform vec3 uGlow;
  varying vec3 vWorldPos;

  void main() {
    float t = clamp((vWorldPos.y + 60.0) / 110.0, 0.0, 1.0);
    vec3 sky;
    if (t < 0.25) {
      sky = mix(uGlow, uHorizon, t / 0.25);
    } else if (t < 0.55) {
      sky = mix(uHorizon, uMid, (t - 0.25) / 0.30);
    } else {
      sky = mix(uMid, uZenith, (t - 0.55) / 0.45);
    }
    gl_FragColor = vec4(sky, 1.0);
  }
`;

/* ─────────────────────────────────────────────────────────────────────────────
   EASING
───────────────────────────────────────────────────────────────────────────── */
function easeInOutCubic(t) {
  return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
}

/* ─────────────────────────────────────────────────────────────────────────────
   CLASS
   Export as HeroOcean so index.js only needs the import path changed.
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

    const textureUrl = this.canvas.dataset.oceanTexture;
    if (!textureUrl) {
      console.warn('[HeroOcean] data-ocean-texture not set on canvas');
      return;
    }

    this._splitChars(this.text1);
    this._splitChars(this.text2);

    this.clock = new THREE.Clock();
    this.scene = new THREE.Scene();

    this._setupRenderer();
    this._setupCamera();
    this._setupSky();
    this._setupOcean(textureUrl);
    this._setupLights();
    this._setupScroll();
    this._setupResize();
    this._animate();
  }

  /* ── Renderer ────────────────────────────────────────────────────────────── */
  _setupRenderer() {
    this.renderer = new THREE.WebGLRenderer({ canvas: this.canvas, antialias: true });
    this.renderer.setSize(window.innerWidth, window.innerHeight);
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.renderer.toneMapping = THREE.LinearToneMapping;
    this.renderer.toneMappingExposure = 1.0;
  }

  /* ── Camera ──────────────────────────────────────────────────────────────── */
  _setupCamera() {
    this.camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 2000);
    this.camera.position.set(0, 2.8, 11);
    this.camera.lookAt(0, 0.5, -10);
  }

  /* ── Sky ─────────────────────────────────────────────────────────────────── */
  _setupSky() {
    const geo = new THREE.SphereGeometry(500, 32, 16);
    this.skyMat = new THREE.ShaderMaterial({
      uniforms: {
        uGlow:    { value: new THREE.Color('#c8f2fa') },  // pale cyan near waterline
        uHorizon: { value: new THREE.Color('#a8e8f5') },  // light horizon
        uMid:     { value: new THREE.Color('#70c7f2') },  // mid sky
        uZenith:  { value: new THREE.Color('#70c7f2') },  // top = #70c7f2
      },
      vertexShader:   SKY_VERT,
      fragmentShader: SKY_FRAG,
      side: THREE.BackSide,
      fog: false,
    });
    this.scene.add(new THREE.Mesh(geo, this.skyMat));
    this.scene.fog = new THREE.FogExp2('#a8e8f5', 0.007);
  }

  /* ── Ocean ───────────────────────────────────────────────────────────────── */
  _setupOcean(textureUrl) {
    const texture = new THREE.TextureLoader().load(textureUrl);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.ClampToEdgeWrapping;

    const geo = new THREE.PlaneGeometry(80, 80, 224, 224);
    this.oceanMat = new THREE.ShaderMaterial({
      uniforms: {
        uTexture: { value: texture },
        uTime:    { value: 0 },
        uFoam:    { value: new THREE.Color('#d5f0f5') },
        uSky:     { value: new THREE.Color('#70c7f2') },
      },
      vertexShader:   OCEAN_VERT,
      fragmentShader: OCEAN_FRAG,
    });

    const mesh = new THREE.Mesh(geo, this.oceanMat);
    mesh.rotation.x = -Math.PI / 2;
    this.scene.add(mesh);
  }

  /* ── Lights ──────────────────────────────────────────────────────────────── */
  _setupLights() {
    this.scene.add(new THREE.AmbientLight(0xeaf8fc, 1.2));
    const sun = new THREE.DirectionalLight(0xf5fdff, 2.8);
    sun.position.set(-15, 35, -20);
    this.scene.add(sun);
  }

  /* ── Char splitting ──────────────────────────────────────────────────────── */
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

  /* ── Char animation ──────────────────────────────────────────────────────── */
  _animateIn(container) {
    if (!container) return;
    const chars = container.querySelectorAll('.char');
    if (!chars.length) return;
    chars.forEach(c => {
      c.style.opacity   = '0';
      c.style.transform = 'translateY(100px) scale(0.2) rotate(90deg)';
      c.style.filter    = 'blur(15px)';
    });
    createTimeline({ defaults: { ease: 'out(4)' } }).add(chars, {
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

    function update() {
      if (!self.wrapper) return;
      var rect  = self.wrapper.getBoundingClientRect();
      var winH  = window.innerHeight;
      var total = rect.height - winH;
      if (total <= 0) return;

      var raw = Math.max(0, Math.min(1, -rect.top / total));
      var p, e;

      if (raw < 0.20) {
        // ── Phase 1: text1 + scroll hint fully visible ──
        if (!text1Done) { text1Done = true; self._animateIn(self.text1); }
        self._container(self.text1, 1, 0);
        self._container(self.text2, 0, SLIDE);
        self._hint(1);
        self._canvasOpacity(1);
        self._bg('rgb(112,199,242)');

      } else if (raw < 0.35) {
        // ── Phase 2: text1 + scroll hint fade out together ──
        if (!text1Done) { text1Done = true; self._animateIn(self.text1); }
        p = easeInOutCubic(1 - (raw - 0.20) / 0.15);
        self._container(self.text1, p, -(1 - p) * 16);
        self._container(self.text2, 0, SLIDE);
        self._hint(p);
        self._canvasOpacity(1);
        self._bg('rgb(112,199,242)');

      } else if (raw < 0.50) {
        // ── Phase 3: empty stage — hint gone ──
        self._container(self.text1, 0, -16);
        self._container(self.text2, 0, SLIDE);
        self._hint(0);
        self._canvasOpacity(1);
        self._bg('rgb(112,199,242)');

      } else if (raw < 0.80) {
        // ── Phase 4+5: text2 animates in once, stays visible ──
        if (!text2Done) { text2Done = true; self._animateIn(self.text2); }
        self._container(self.text1, 0, -16);
        self._container(self.text2, 1, 0);
        self._canvasOpacity(1);
        self._bg('rgb(112,199,242)');

      } else {
        // ── Phase 6: everything fades, boat section emerges ──
        e = easeInOutCubic(1 - (raw - 0.80) / 0.20);
        self._container(self.text1, 0, -16);
        self._container(self.text2, e, -(1 - e) * 16);
        self._canvasOpacity(e);
        self._bg('rgb(112,199,242)');
      }
    }

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
    update();
  }

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

  /* ── Resize ──────────────────────────────────────────────────────────────── */
  _setupResize() {
    window.addEventListener('resize', () => {
      this.camera.aspect = window.innerWidth / window.innerHeight;
      this.camera.updateProjectionMatrix();
      this.renderer.setSize(window.innerWidth, window.innerHeight);
      this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    });
  }

  /* ── Render loop ─────────────────────────────────────────────────────────── */
  _animate() {
    this.oceanMat.uniforms.uTime.value = this.clock.getElapsedTime();
    this.renderer.render(this.scene, this.camera);
    requestAnimationFrame(() => this._animate());
  }
}
