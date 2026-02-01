import * as THREE from 'three';
import WaterEffect from './water-effect';

export default class HeroParallax {
  constructor() {
    this.container = document.getElementById('birds-3d-container');

    if (!this.container) return;

    this.birds = [];
    this.clock = 0;
    this.totalFrames = 22;
    this.birdCount = 50;

    // Flocking parameters
    this.separationDistance = 5;
    this.alignmentDistance = 10;
    this.cohesionDistance = 15;
    this.separationFactor = 0.03;
    this.alignmentFactor = 0.05;
    this.cohesionFactor = 0.005;

    // Boundary parameters
    this.boundary = 70;
    this.minY = -5;
    this.maxY = 20;
    this.boundaryMargin = 15;
    this.boundaryForceStrength = 0.05;

    // Water effect
    this.waterEffect = null;

    this.init();
  }

  init() {
    this.setupScene();
    this.loadTexture();
    this.setupParallax();
    this.setupResize();
    this.setupWaterEffect();
  }

  setupWaterEffect() {
    const waterContainer = document.getElementById('water-effect-container');
    if (!waterContainer) return;

    const boatImageUrl = waterContainer.dataset.boatImage;
    const waterMaskUrl = waterContainer.dataset.waterMask;
    if (!boatImageUrl) return;

    // Esconder imagem fallback quando WebGL estiver ativo
    const fallbackImg = document.querySelector('.hero-parallax__boat-img--fallback');
    if (fallbackImg) {
      fallbackImg.style.display = 'none';
    }

    this.waterEffect = new WaterEffect(waterContainer, boatImageUrl, waterMaskUrl);
  }

  setupScene() {
    this.scene = new THREE.Scene();
    this.camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
    this.camera.position.set(0, 5, 80);
    this.camera.lookAt(0, 5, 0);

    this.renderer = new THREE.WebGLRenderer({ alpha: true });
    this.renderer.setSize(window.innerWidth, window.innerHeight);
    this.container.appendChild(this.renderer.domElement);
  }

  loadTexture() {
    const loader = new THREE.TextureLoader();
    const birdTexturePath = this.container.dataset.birdTexture;

    loader.load(birdTexturePath, (texture) => {
      texture.wrapS = THREE.RepeatWrapping;
      texture.wrapT = THREE.RepeatWrapping;
      texture.repeat.set(1, 1 / this.totalFrames);

      this.createBirds(texture);
      this.animate();
    });
  }

  randomDirection() {
    let dir = new THREE.Vector3(
      (Math.random() - 0.5) * 2,
      (Math.random() - 0.1) * 0.5,
      (Math.random() - 0.5) * 2
    );
    return dir.normalize();
  }

  createBirds(texture) {
    for (let i = 0; i < this.birdCount; i++) {
      const geometry = new THREE.PlaneGeometry(2, 2);
      const material = new THREE.MeshBasicMaterial({
        map: texture.clone(),
        transparent: true,
        side: THREE.DoubleSide,
        opacity: 0.5,
      });

      // Clone needs its own texture settings
      material.map.wrapS = THREE.RepeatWrapping;
      material.map.wrapT = THREE.RepeatWrapping;
      material.map.repeat.set(1, 1 / this.totalFrames);

      const mesh = new THREE.Mesh(geometry, material);
      mesh.position.set(
        (Math.random() - 0.5) * this.boundary,
        (Math.random() - 0.5) * (this.maxY - this.minY) / 2 + (this.maxY + this.minY) / 2,
        (Math.random() - 0.5) * this.boundary
      );

      mesh.userData = {
        speed: 0.5 + Math.random() * 0.4,
        offset: Math.random() * 100,
        direction: this.randomDirection(),
        turnTimer: 0,
      };

      this.birds.push(mesh);
      this.scene.add(mesh);
    }
  }

  applyFlockingRules(bird) {
    let separation = new THREE.Vector3();
    let alignment = new THREE.Vector3();
    let cohesion = new THREE.Vector3();
    let neighborCount = 0;

    this.birds.forEach(otherBird => {
      if (otherBird !== bird) {
        const distance = bird.position.distanceTo(otherBird.position);

        if (distance < this.separationDistance) {
          const diff = bird.position.clone().sub(otherBird.position);
          separation.add(diff.normalize().divideScalar(distance));
        }

        if (distance < this.alignmentDistance) {
          alignment.add(otherBird.userData.direction);
          neighborCount++;
        }

        if (distance < this.cohesionDistance) {
          cohesion.add(otherBird.position);
        }
      }
    });

    if (neighborCount > 0) {
      alignment.divideScalar(neighborCount).normalize();
      cohesion.divideScalar(neighborCount).sub(bird.position).normalize();
    }

    bird.userData.direction.add(separation.multiplyScalar(this.separationFactor));
    bird.userData.direction.add(alignment.multiplyScalar(this.alignmentFactor));
    bird.userData.direction.add(cohesion.multiplyScalar(this.cohesionFactor));

    if (bird.userData.direction.lengthSq() < 0.001) {
      bird.userData.direction.copy(this.randomDirection());
    }
    bird.userData.direction.normalize();
  }

  applyBoundaryAvoidance(bird) {
    let boundaryAvoidance = new THREE.Vector3();

    if (bird.position.x > this.boundary - this.boundaryMargin) {
      boundaryAvoidance.x -= (bird.position.x - (this.boundary - this.boundaryMargin)) / this.boundaryMargin * this.boundaryForceStrength;
    } else if (bird.position.x < -this.boundary + this.boundaryMargin) {
      boundaryAvoidance.x += ((-this.boundary + this.boundaryMargin) - bird.position.x) / this.boundaryMargin * this.boundaryForceStrength;
    }

    if (bird.position.y > this.maxY - this.boundaryMargin) {
      boundaryAvoidance.y -= (bird.position.y - (this.maxY - this.boundaryMargin)) / this.boundaryMargin * this.boundaryForceStrength;
    } else if (bird.position.y < this.minY + this.boundaryMargin) {
      boundaryAvoidance.y += ((this.minY + this.boundaryMargin) - bird.position.y) / this.boundaryMargin * this.boundaryForceStrength;
    }

    if (bird.position.z > this.boundary - this.boundaryMargin) {
      boundaryAvoidance.z -= (bird.position.z - (this.boundary - this.boundaryMargin)) / this.boundaryMargin * this.boundaryForceStrength;
    } else if (bird.position.z < -this.boundary + this.boundaryMargin) {
      boundaryAvoidance.z += ((-this.boundary + this.boundaryMargin) - bird.position.z) / this.boundaryMargin * this.boundaryForceStrength;
    }

    bird.userData.direction.add(boundaryAvoidance);
    bird.userData.direction.normalize();
  }

  animate() {
    this.clock += 0.016;

    this.birds.forEach((bird) => {
      const { speed, offset, direction } = bird.userData;

      this.applyFlockingRules(bird);
      this.applyBoundaryAvoidance(bird);

      // Animate sprite frame
      const frame = Math.floor((this.clock * 10 + offset) % this.totalFrames);
      bird.material.map.offset.y = 1 - (frame + 1) / this.totalFrames;

      // Add sway movement
      const sway = new THREE.Vector3(
        Math.sin(this.clock * 0.7 + offset) * 0.01,
        Math.cos(this.clock * 0.3 + offset) * 0.005,
        Math.sin(this.clock * 0.5 + offset) * 0.01
      );

      const moveDir = direction.clone().add(sway).normalize();
      bird.position.addScaledVector(moveDir, speed * 0.4);

      // Make bird face direction
      bird.lookAt(bird.position.clone().add(moveDir));
      bird.rotateX(Math.PI / 2);

      // Random direction changes
      bird.userData.turnTimer += 0.016;
      if (bird.userData.turnTimer > 5 + Math.random() * 5) {
        const newDir = this.randomDirection();
        bird.userData.direction.lerp(newDir, 0.2).normalize();
        bird.userData.turnTimer = 0;
      }
    });

    this.renderer.render(this.scene, this.camera);
    requestAnimationFrame(() => this.animate());
  }

  setupParallax() {
    const firstSection = document.querySelector('.hero-parallax__section--first');
    const secondSection = document.querySelector('.hero-parallax__section--second');
    const boatSection = document.querySelector('.hero-parallax__section--boat');
    const clouds = document.querySelectorAll('.hero-parallax__cloud');

    if (!firstSection || !secondSection || !boatSection) return;

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

      // Posições iniciais das nuvens (fora da tela, embaixo)
      const cloudStartPositions = [
        { left: -15, top: 110 },   // cloud--1
        { left: 55, top: 110 },    // cloud--2
        { left: 5, top: 110 },     // cloud--3
        { left: 70, top: 110 },    // cloud--4
        { left: -10, top: 110 }    // cloud--5
      ];

      // Posições finais das nuvens (cobrindo o barco - mais à esquerda)
      const cloudEndPositions = [
        { left: -15, top: 5 },     // cloud--1: topo esquerda
        { left: 55, top: 20 },     // cloud--2: direita
        { left: 5, top: 35 },      // cloud--3: esquerda centro
        { left: 70, top: 45 },     // cloud--4: direita baixo
        { left: -10, top: 55 }     // cloud--5: esquerda baixo
      ];

      // Posições de saída (para fora da tela pelos lados)
      const cloudExitPositions = [
        { left: -120, top: 5 },    // cloud--1 sai pela esquerda
        { left: 130, top: 20 },    // cloud--2 sai pela direita
        { left: -120, top: 35 },   // cloud--3 sai pela esquerda
        { left: 130, top: 45 },    // cloud--4 sai pela direita
        { left: -120, top: 55 }    // cloud--5 sai pela esquerda
      ];

      // Nuvens começam a subir na segunda dobra
      const cloudRiseStart = windowHeight * 1.2;
      const cloudRiseEnd = windowHeight * 2.5;
      const thirdFoldStart = windowHeight * 2.5;

      // Fase 1: Primeira dobra - nuvens fora da tela (embaixo)
      if (scrollY < cloudRiseStart) {
        clouds.forEach((cloud, index) => {
          const start = cloudStartPositions[index];
          cloud.style.left = `${start.left}%`;
          cloud.style.top = `${start.top}%`;
          cloud.style.right = 'auto';
          cloud.style.opacity = 1;
        });

        this.container.style.opacity = 1;
      }
      // Fase 2: Nuvens sobem de baixo para cima
      else if (scrollY < thirdFoldStart) {
        const riseProgress = (scrollY - cloudRiseStart) / (cloudRiseEnd - cloudRiseStart);

        clouds.forEach((cloud, index) => {
          const start = cloudStartPositions[index];
          const end = cloudEndPositions[index];

          const currentLeft = start.left + (end.left - start.left) * riseProgress;
          const currentTop = start.top + (end.top - start.top) * riseProgress;

          cloud.style.left = `${currentLeft}%`;
          cloud.style.top = `${currentTop}%`;
          cloud.style.right = 'auto';
          cloud.style.opacity = 1;
        });

        this.container.style.opacity = 1;
      }
      // Fase 3: Terceira dobra em diante - nuvens saem para os lados com fade out
      else {
        const exitProgress = Math.min((scrollY - thirdFoldStart) / (windowHeight * 1.5), 1);

        clouds.forEach((cloud, index) => {
          const end = cloudEndPositions[index];
          const exit = cloudExitPositions[index];

          const currentLeft = end.left + (exit.left - end.left) * exitProgress;
          const currentTop = end.top + (exit.top - end.top) * exitProgress;

          cloud.style.left = `${currentLeft}%`;
          cloud.style.top = `${currentTop}%`;
          cloud.style.right = 'auto';
          cloud.style.opacity = 1 - exitProgress;
        });

        // Fade out birds junto com as nuvens
        this.container.style.opacity = Math.max(0, 1 - exitProgress);
      }

    });
  }

  setupResize() {
    window.addEventListener('resize', () => {
      this.camera.aspect = window.innerWidth / window.innerHeight;
      this.camera.updateProjectionMatrix();
      this.renderer.setSize(window.innerWidth, window.innerHeight);
    });
  }
}
