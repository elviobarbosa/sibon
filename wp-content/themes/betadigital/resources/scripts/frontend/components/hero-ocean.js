import * as THREE from 'three';

/* ─────────────────────────────────────────────────────────────────────────────
   SHADERS
───────────────────────────────────────────────────────────────────────────── */
const VERT = `
  uniform float uTime;
  varying float vElevation;
  varying vec2  vUv;

  void main() {
    vec4 wPos = modelMatrix * vec4(position, 1.0);
    float x = wPos.x, z = wPos.z, t = uTime;

    // Large rolling swells (slow, majestic)
    float swell = sin(x * 0.45 + t * 0.40) * 0.30
                + sin(z * 0.35 + t * 0.32) * 0.24;

    // Medium chop — diagonal tension
    float chop  = sin(x * 1.7 + z * 1.1 + t * 0.85) * 0.10
                + sin(x * 2.1 - z * 1.5 + t * 1.05) * 0.07;

    // Surface ripples
    float rip   = sin(x * 5.2 + z * 4.1 + t * 2.10) * 0.025
                + sin(x * 6.8 - z * 5.8 + t * 2.90) * 0.012;

    float e = swell + chop + rip;
    wPos.y += e;
    vElevation = e;
    vUv = uv;

    gl_Position = projectionMatrix * viewMatrix * wPos;
  }
`;

const FRAG = `
  uniform vec3  uDeep;
  uniform vec3  uMid;
  uniform vec3  uSurface;
  uniform vec3  uFoam;
  uniform vec3  uSun;
  uniform float uTime;

  varying float vElevation;
  varying vec2  vUv;

  void main() {
    // Normalise elevation to [0,1]
    float norm = clamp((vElevation + 0.7) / 1.4, 0.0, 1.0);

    // Three-stage colour blend: deep -> mid -> surface
    vec3 water = norm < 0.5
      ? mix(uDeep, uMid, norm * 2.0)
      : mix(uMid, uSurface, (norm - 0.5) * 2.0);

    // Foam on crests
    float foam = smoothstep(0.60, 0.90, norm);
    water = mix(water, uFoam, foam * 0.50);

    // Sun shimmer strip — centred horizontally, lives on high peaks
    float dx      = abs(vUv.x - 0.5);
    float shimmer = exp(-dx * dx * 10.0) * smoothstep(0.45, 0.85, norm) * 0.75;
    water += uSun * shimmer;

    // Fresnel-like brightening toward the horizon (vUv.y=0 = far)
    float fresnel = pow(1.0 - clamp(vUv.y, 0.0, 1.0), 3.0) * 0.25;
    water += uSurface * fresnel;

    gl_FragColor = vec4(water, 1.0);
  }
`;

const SKY_VERT = `
  varying vec3 vWorldPos;
  void main() {
    vWorldPos = position;
    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
  }
`;

// Sky: deep navy zenith -> ocean blue mid -> warm teal/gold at horizon
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
      // Near horizon: horizon -> warm glow band
      float tt = t / 0.25;
      sky = mix(uGlow, uHorizon, tt);
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
───────────────────────────────────────────────────────────────────────────── */
export default class HeroOcean {
  constructor() {
    this.canvas  = document.getElementById('hero-ocean-canvas');
    this.wrapper = document.querySelector('.hero-spline-wrapper');
    this.sticky  = document.querySelector('.hero-spline-sticky');
    this.text1   = document.querySelector('.hero-spline-text-1');
    this.text2   = document.querySelector('.hero-spline-text-2');

    if (!this.canvas || !this.wrapper) return;

    this.clock = new THREE.Clock();
    this.scene = new THREE.Scene();

    this._setupRenderer();
    this._setupCamera();
    this._setupSky();
    this._setupOcean();
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
    // LinearToneMapping keeps colours faithful — ACES crushes near-blacks
    this.renderer.toneMapping = THREE.LinearToneMapping;
    this.renderer.toneMappingExposure = 1.0;
  }

  /* ── Camera ──────────────────────────────────────────────────────────────── */
  _setupCamera() {
    this.camera = new THREE.PerspectiveCamera(
      55, window.innerWidth / window.innerHeight, 0.1, 2000
    );
    // Dramatic low angle — feeling of being in the water
    this.camera.position.set(0, 2.8, 11);
    this.camera.lookAt(0, 0.5, -10);
  }

  /* ── Sky ─────────────────────────────────────────────────────────────────── */
  _setupSky() {
    const geo = new THREE.SphereGeometry(500, 32, 16);
    // Do NOT scale — BackSide handles inside view; scaling + BackSide cancel out

    this.skyMat = new THREE.ShaderMaterial({
      uniforms: {
        uZenith:  { value: new THREE.Color('#0d2454') },  // deep but visible dark blue
        uMid:     { value: new THREE.Color('#1a5aab') },  // rich tropical blue
        uHorizon: { value: new THREE.Color('#2e90d4') },  // bright ocean-sky
        uGlow:    { value: new THREE.Color('#65c8e8') },  // vivid cyan at waterline
      },
      vertexShader:   SKY_VERT,
      fragmentShader: SKY_FRAG,
      side: THREE.BackSide,
      fog: false,  // sky sphere must never be fogged
    });

    this.scene.add(new THREE.Mesh(geo, this.skyMat));

    // Fog only softens the far ocean horizon — low density so sky stays visible
    this.scene.fog = new THREE.FogExp2('#2e90d4', 0.008);
  }

  /* ── Ocean ───────────────────────────────────────────────────────────────── */
  _setupOcean() {
    const geo = new THREE.PlaneGeometry(80, 80, 224, 224);

    this.oceanMat = new THREE.ShaderMaterial({
      uniforms: {
        uTime:    { value: 0 },
        uDeep:    { value: new THREE.Color('#003366') },  // visible deep blue
        uMid:     { value: new THREE.Color('#0072aa') },  // rich tropical mid
        uSurface: { value: new THREE.Color('#00b4e0') },  // vivid turquoise crest
        uFoam:    { value: new THREE.Color('#e0f6ff') },  // bright foam
        uSun:     { value: new THREE.Color('#90dcf0') },  // sky-light shimmer
      },
      vertexShader:   VERT,
      fragmentShader: FRAG,
    });

    const mesh = new THREE.Mesh(geo, this.oceanMat);
    mesh.rotation.x = -Math.PI / 2;
    this.scene.add(mesh);
  }

  /* ── Lights ──────────────────────────────────────────────────────────────── */
  _setupLights() {
    this.scene.add(new THREE.AmbientLight(0x4488aa, 1.4));

    const sun = new THREE.DirectionalLight(0xc8e8ff, 3.0);
    sun.position.set(-18, 28, -25);
    this.scene.add(sun);

    // Subtle fill from below (ocean reflected light)
    const fill = new THREE.DirectionalLight(0x0066aa, 0.6);
    fill.position.set(0, -5, 5);
    this.scene.add(fill);
  }

  /* ── Scroll-driven animation ─────────────────────────────────────────────── */
  _setupScroll() {
    var self = this;
    var SLIDE = 30; // px — vertical travel for text slide

    function update() {
      if (!self.wrapper) return;
      var rect = self.wrapper.getBoundingClientRect();
      var winH = window.innerHeight;
      var total = rect.height - winH;
      if (total <= 0) return;

      var raw = Math.max(0, Math.min(1, -rect.top / total));

      var p, e, fadeOut, r, g, b;

      if (raw < 0.20) {
        // ── Phase 1: text1 fully visible ──
        self._text(self.text1, 1, 0);
        self._text(self.text2, 0, SLIDE);
        self._canvasOpacity(1);
        self._bg('#0d2454');

      } else if (raw < 0.35) {
        // ── Phase 2: text1 fades up and out ──
        p = easeInOutCubic(1 - (raw - 0.20) / 0.15);
        self._text(self.text1, p, -(1 - p) * 16);
        self._text(self.text2, 0, SLIDE);
        self._canvasOpacity(1);
        self._bg('#0d2454');

      } else if (raw < 0.50) {
        // ── Phase 3: empty stage ──
        self._text(self.text1, 0, -16);
        self._text(self.text2, 0, SLIDE);
        self._canvasOpacity(1);
        self._bg('#0d2454');

      } else if (raw < 0.65) {
        // ── Phase 4: text2 rises from below ──
        p = easeInOutCubic((raw - 0.50) / 0.15);
        self._text(self.text1, 0, -16);
        self._text(self.text2, p, (1 - p) * SLIDE);
        self._canvasOpacity(1);
        self._bg('#0d2454');

      } else if (raw < 0.80) {
        // ── Phase 5: text2 fully visible ──
        self._text(self.text1, 0, -16);
        self._text(self.text2, 1, 0);
        self._canvasOpacity(1);
        self._bg('#0d2454');

      } else {
        // ── Phase 6: everything fades, boat section emerges ──
        e = easeInOutCubic(1 - (raw - 0.80) / 0.20); // 1 → 0
        self._text(self.text1, 0, -16);
        self._text(self.text2, e, -(1 - e) * 16);
        self._canvasOpacity(e);

        // Interpolate bg: #0d2454 → #70c7f1
        r = Math.round(13  + 99  * (1 - e));   // 13 -> 112
        g = Math.round(36  + 163 * (1 - e));   // 36 -> 199
        b = Math.round(84  + 157 * (1 - e));   // 84 -> 241
        if (self.sticky) self.sticky.style.background = 'rgb(' + r + ',' + g + ',' + b + ')';
      }
    }

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
    update();
  }

  _text(el, opacity, translateY) {
    if (!el) return;
    el.style.opacity = String(Math.max(0, Math.min(1, opacity)));
    el.style.transform = 'translate(-50%, calc(-50% + ' + translateY + 'px))';
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
