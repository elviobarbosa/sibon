import * as THREE from 'three';

export default class WaterEffect {
  constructor(container, imageUrl, maskUrl = null) {
    this.container = container;
    this.imageUrl = imageUrl;
    this.maskUrl = maskUrl;

    if (!this.container) return;

    this.time = 0;
    this.scene = null;
    this.camera = null;
    this.renderer = null;
    this.material = null;
    this.plane = null;

    this.loadImages();
  }

  loadImages() {
    const loader = new THREE.TextureLoader();

    loader.load(this.imageUrl, (texture) => {
      texture.minFilter = THREE.LinearFilter;
      texture.magFilter = THREE.LinearFilter;

      if (this.maskUrl) {
        loader.load(this.maskUrl, (maskTexture) => {
          maskTexture.minFilter = THREE.LinearFilter;
          maskTexture.magFilter = THREE.LinearFilter;
          this.setup(texture, maskTexture);
        });
      } else {
        this.setup(texture, null);
      }
    });
  }

  setup(texture, maskTexture) {
    const imageWidth = texture.image.width;
    const imageHeight = texture.image.height;
    const imageAspect = imageWidth / imageHeight;

    // Calcular tamanho do canvas baseado na largura do container
    const containerWidth = this.container.offsetWidth || window.innerWidth;
    const canvasWidth = containerWidth;
    const canvasHeight = containerWidth / imageAspect;

    // Criar cena
    this.scene = new THREE.Scene();

    // Câmera ortográfica simples (-1 a 1)
    this.camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0.1, 10);
    this.camera.position.z = 1;

    // Renderer com tamanho proporcional à imagem
    this.renderer = new THREE.WebGLRenderer({
      alpha: false,
      antialias: true
    });
    this.renderer.setSize(canvasWidth, canvasHeight);
    this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    this.container.appendChild(this.renderer.domElement);

    // Criar material e plano
    this.createWaterPlane(texture, maskTexture);

    // Guardar aspect para resize
    this.imageAspect = imageAspect;

    // Iniciar animação
    this.animate();

    // Setup eventos
    window.addEventListener('resize', () => this.onResize());
  }

  createWaterPlane(texture, maskTexture) {
    const vertexShader = `
      varying vec2 vUv;
      void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }
    `;

    const fragmentShader = `
      uniform sampler2D uTexture;
      uniform sampler2D uMask;
      uniform float uTime;
      uniform bool uHasMask;

      varying vec2 vUv;

      vec3 mod289(vec3 x) { return x - floor(x * (1.0 / 289.0)) * 289.0; }
      vec2 mod289(vec2 x) { return x - floor(x * (1.0 / 289.0)) * 289.0; }
      vec3 permute(vec3 x) { return mod289(((x*34.0)+1.0)*x); }

      float snoise(vec2 v) {
        const vec4 C = vec4(0.211324865405187, 0.366025403784439,
                           -0.577350269189626, 0.024390243902439);
        vec2 i  = floor(v + dot(v, C.yy));
        vec2 x0 = v - i + dot(i, C.xx);
        vec2 i1 = (x0.x > x0.y) ? vec2(1.0, 0.0) : vec2(0.0, 1.0);
        vec4 x12 = x0.xyxy + C.xxzz;
        x12.xy -= i1;
        i = mod289(i);
        vec3 p = permute(permute(i.y + vec3(0.0, i1.y, 1.0)) + i.x + vec3(0.0, i1.x, 1.0));
        vec3 m = max(0.5 - vec3(dot(x0,x0), dot(x12.xy,x12.xy), dot(x12.zw,x12.zw)), 0.0);
        m = m*m;
        m = m*m;
        vec3 x = 2.0 * fract(p * C.www) - 1.0;
        vec3 h = abs(x) - 0.5;
        vec3 ox = floor(x + 0.5);
        vec3 a0 = x - ox;
        m *= 1.79284291400159 - 0.85373472095314 * (a0*a0 + h*h);
        vec3 g;
        g.x = a0.x * x0.x + h.x * x0.y;
        g.yz = a0.yz * x12.xz + h.yz * x12.yw;
        return 130.0 * dot(m, g);
      }

      void main() {
        vec2 uv = vUv;

        float maskValue = uHasMask ? texture2D(uMask, uv).r : 1.0;

        if (maskValue < 0.01) {
          gl_FragColor = texture2D(uTexture, uv);
          return;
        }

        float waterIntensity = maskValue;

        // Ondas
        float wave1 = snoise(vec2(uv.x * 2.0 + uTime * 0.1, uv.y * 1.5 + uTime * 0.06));
        float wave2 = snoise(vec2(uv.x * 3.0 - uTime * 0.12, uv.y * 2.0 + uTime * 0.05));
        float combinedWave = wave1 * 0.6 + wave2 * 0.4;

        // Displacement — livre agora que os barcos estão em camada separada
        float strength = waterIntensity * 0.022;
        vec2 displacement = vec2(
          combinedWave * strength,
          combinedWave * strength * 0.5
        );

        // Ondulação horizontal
        displacement.x += sin(uv.y * 15.0 + uTime * 0.7) * 0.005 * waterIntensity;

        vec2 distortedUv = uv + displacement;

        // Verificar máscara no UV distorcido
        float distortedMask = uHasMask ? texture2D(uMask, distortedUv).r : 1.0;
        if (distortedMask < 0.1) {
          distortedUv = uv;
        }

        distortedUv = clamp(distortedUv, 0.0, 1.0);

        vec4 color = texture2D(uTexture, distortedUv);

        // Specular - brilho nas cristas
        float specular = pow(max(0.0, combinedWave), 1.5) * 0.38 * waterIntensity;
        color.rgb += vec3(specular * 0.88, specular * 0.94, specular);

        // Caustics - padrões de luz
        float caustic = snoise(vec2(uv.x * 10.0 + uTime * 0.12, uv.y * 10.0 - uTime * 0.06));
        caustic = pow(max(0.0, caustic), 1.8) * 0.22 * waterIntensity;
        color.rgb += vec3(caustic * 0.82, caustic * 0.93, caustic);

        // Segunda camada de caustics para mais complexidade
        float caustic2 = snoise(vec2(uv.x * 7.0 - uTime * 0.09, uv.y * 8.0 + uTime * 0.07));
        caustic2 = pow(max(0.0, caustic2), 2.2) * 0.12 * waterIntensity;
        color.rgb += vec3(caustic2 * 0.8, caustic2 * 0.92, caustic2);

        gl_FragColor = color;
      }
    `;

    // Textura branca fallback
    const whiteTex = new THREE.DataTexture(
      new Uint8Array([255, 255, 255, 255]), 1, 1, THREE.RGBAFormat
    );
    whiteTex.needsUpdate = true;

    this.material = new THREE.ShaderMaterial({
      uniforms: {
        uTexture: { value: texture },
        uMask: { value: maskTexture || whiteTex },
        uTime: { value: 0 },
        uHasMask: { value: maskTexture !== null }
      },
      vertexShader,
      fragmentShader
    });

    // Plano 2x2 que preenche a câmera ortográfica
    const geometry = new THREE.PlaneGeometry(2, 2);
    this.plane = new THREE.Mesh(geometry, this.material);
    this.scene.add(this.plane);
  }

  animate() {
    this.time += 0.008;

    if (this.material) {
      this.material.uniforms.uTime.value = this.time;
    }

    if (this.renderer && this.scene && this.camera) {
      this.renderer.render(this.scene, this.camera);
    }

    this.animationId = requestAnimationFrame(() => this.animate());
  }

  onResize() {
    if (!this.container || !this.renderer || !this.imageAspect) return;

    const containerWidth = this.container.offsetWidth || window.innerWidth;
    const canvasWidth = containerWidth;
    const canvasHeight = containerWidth / this.imageAspect;

    this.renderer.setSize(canvasWidth, canvasHeight);
  }

  destroy() {
    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
    }
    if (this.renderer) {
      this.renderer.dispose();
      if (this.renderer.domElement.parentNode) {
        this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
      }
    }
    if (this.material) {
      this.material.dispose();
    }
    if (this.plane) {
      this.plane.geometry.dispose();
    }
  }
}
