<section class="hero-parallax">
  <!-- Container dos pássaros 3D -->
  <div id="birds-3d-container" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;"></div>

  <!-- Primeira dobra -->
  <div class="hero-parallax__section hero-parallax__section--first" data-section="1">
    <div class="hero-parallax__content">
      <h1 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline">Enjoy in the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight">Wildest nature</span>
      </h1>
    </div>
  </div>

  <!-- Segunda dobra -->
  <div class="hero-parallax__section hero-parallax__section--second" data-section="2">
    <div class="hero-parallax__content">
      <h2 class="hero-parallax__title">
        <span class="hero-parallax__title-line hero-parallax__title-line--headline">Experience the</span>
        <span class="hero-parallax__title-line hero-parallax__title-line--highlight">Adventure of a lifetime</span>
      </h2>
    </div>
  </div>

  <!-- Transição com nuvens -->
  <div class="hero-parallax__transition">
    <div class="hero-parallax__clouds">
      <div class="hero-parallax__cloud hero-parallax__cloud--1"></div>
      <div class="hero-parallax__cloud hero-parallax__cloud--2"></div>
      <div class="hero-parallax__cloud hero-parallax__cloud--3"></div>
    </div>
  </div>

  <!-- Terceira dobra - Barco -->
  <div class="hero-parallax__section hero-parallax__section--boat" data-section="3">
    <div class="hero-parallax__boat-image">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/dist/images/bmp/boat.jpg'); ?>" alt="Boat adventure" class="hero-parallax__boat-img">
    </div>
  </div>
</section>

<script type="module">
import * as THREE from 'https://unpkg.com/three@0.128.0/build/three.module.js';

const container = document.getElementById('birds-3d-container');
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 1000);
camera.position.set(0, 5, 80);
camera.lookAt(0, 5, 0);

const renderer = new THREE.WebGLRenderer({ alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
container.appendChild(renderer.domElement);

const loader = new THREE.TextureLoader();
const birdTexturePath = '<?php echo esc_url(get_template_directory_uri() . "/dist/images/bmp/birdb.png"); ?>';

loader.load(birdTexturePath, (texture) => {
  texture.wrapS = THREE.RepeatWrapping;
  texture.wrapT = THREE.RepeatWrapping;
  texture.repeat.set(1, 1 / 22);

  const totalFrames = 22;
  const birdCount = 50;
  const birds = [];
  let clock = 0;

  const separationDistance = 5;
  const alignmentDistance = 10;
  const cohesionDistance = 15;
  const separationFactor = 0.03;
  const alignmentFactor = 0.05;
  const cohesionFactor = 0.005;

  const boundary = 70;
  const minY = -5;
  const maxY = 20;
  const boundaryMargin = 15;
  const boundaryForceStrength = 0.05;

  function randomDirection() {
    let dir = new THREE.Vector3(
      (Math.random() - 0.5) * 2,
      (Math.random() - 0.1) * 0.5,
      (Math.random() - 0.5) * 2
    );
    return dir.normalize();
  }

  for (let i = 0; i < birdCount; i++) {
    const geometry = new THREE.PlaneGeometry(2, 2);
    const material = new THREE.MeshBasicMaterial({
      map: texture,
      transparent: true,
      side: THREE.DoubleSide,
      opacity: 0.5,
    });

    const mesh = new THREE.Mesh(geometry, material);
    mesh.position.set(
      (Math.random() - 0.5) * boundary,
      (Math.random() - 0.5) * (maxY - minY) / 2 + (maxY + minY) / 2,
      (Math.random() - 0.5) * boundary
    );

    const direction = randomDirection();
    mesh.userData = {
      speed: 0.5 + Math.random() * 0.4,
      offset: Math.random() * 100,
      direction,
      turnTimer: 0,
    };

    birds.push(mesh);
    scene.add(mesh);
  }

  function applyFlockingRules(bird) {
    let separation = new THREE.Vector3();
    let alignment = new THREE.Vector3();
    let cohesion = new THREE.Vector3();
    let neighborCount = 0;

    birds.forEach(otherBird => {
      if (otherBird !== bird) {
        const distance = bird.position.distanceTo(otherBird.position);

        if (distance < separationDistance) {
          const diff = bird.position.clone().sub(otherBird.position);
          separation.add(diff.normalize().divideScalar(distance));
        }

        if (distance < alignmentDistance) {
          alignment.add(otherBird.userData.direction);
          neighborCount++;
        }

        if (distance < cohesionDistance) {
          cohesion.add(otherBird.position);
        }
      }
    });

    if (neighborCount > 0) {
      alignment.divideScalar(neighborCount).normalize();
      cohesion.divideScalar(neighborCount).sub(bird.position).normalize();
    }

    bird.userData.direction.add(separation.multiplyScalar(separationFactor));
    bird.userData.direction.add(alignment.multiplyScalar(alignmentFactor));
    bird.userData.direction.add(cohesion.multiplyScalar(cohesionFactor));

    if (bird.userData.direction.lengthSq() < 0.001) {
      bird.userData.direction.copy(randomDirection());
    }
    bird.userData.direction.normalize();
  }

  function animate() {
    clock += 0.016;

    birds.forEach((bird) => {
      const { speed, offset, direction } = bird.userData;

      applyFlockingRules(bird);

      let boundaryAvoidance = new THREE.Vector3();

      if (bird.position.x > boundary - boundaryMargin) {
        boundaryAvoidance.x -= (bird.position.x - (boundary - boundaryMargin)) / boundaryMargin * boundaryForceStrength;
      } else if (bird.position.x < -boundary + boundaryMargin) {
        boundaryAvoidance.x += ((-boundary + boundaryMargin) - bird.position.x) / boundaryMargin * boundaryForceStrength;
      }

      if (bird.position.y > maxY - boundaryMargin) {
        boundaryAvoidance.y -= (bird.position.y - (maxY - boundaryMargin)) / boundaryMargin * boundaryForceStrength;
      } else if (bird.position.y < minY + boundaryMargin) {
        boundaryAvoidance.y += ((minY + boundaryMargin) - bird.position.y) / boundaryMargin * boundaryForceStrength;
      }

      if (bird.position.z > boundary - boundaryMargin) {
        boundaryAvoidance.z -= (bird.position.z - (boundary - boundaryMargin)) / boundaryMargin * boundaryForceStrength;
      } else if (bird.position.z < -boundary + boundaryMargin) {
        boundaryAvoidance.z += ((-boundary + boundaryMargin) - bird.position.z) / boundaryMargin * boundaryForceStrength;
      }

      bird.userData.direction.add(boundaryAvoidance);
      bird.userData.direction.normalize();

      const frame = Math.floor((clock * 10 + offset) % totalFrames);
      bird.material.map.offset.y = 1 - (frame + 1) / totalFrames;

      const sway = new THREE.Vector3(
        Math.sin(clock * 0.7 + offset) * 0.01,
        Math.cos(clock * 0.3 + offset) * 0.005,
        Math.sin(clock * 0.5 + offset) * 0.01
      );

      const moveDir = direction.clone().add(sway).normalize();
      bird.position.addScaledVector(moveDir, speed * 0.4);

      bird.lookAt(bird.position.clone().add(moveDir));
      bird.rotateX(Math.PI / 2);

      bird.userData.turnTimer += 0.016;
      if (bird.userData.turnTimer > 5 + Math.random() * 5) {
        const newDir = randomDirection();
        bird.userData.direction.lerp(newDir, 0.2).normalize();
        bird.userData.turnTimer = 0;
      }
    });

    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }

  animate();

  // ===== PARALLAX SCROLL EFFECT =====
  const firstSection = document.querySelector('.hero-parallax__section--first');
  const secondSection = document.querySelector('.hero-parallax__section--second');
  const boatSection = document.querySelector('.hero-parallax__section--boat');
  const clouds = document.querySelectorAll('.hero-parallax__cloud');
  const firstContent = firstSection.querySelector('.hero-parallax__content');
  const secondContent = secondSection.querySelector('.hero-parallax__content');

  // Segunda seção começa invisível
  secondContent.style.opacity = 0;

  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    const windowHeight = window.innerHeight;

    // Primeira seção - fade out ao rolar
    if (scrollY < windowHeight) {
      const opacity = 1 - (scrollY / windowHeight);
      firstContent.style.opacity = opacity;
      firstContent.style.transform = `translateY(${scrollY * 0.3}px)`;
    }

    // Segunda seção - fade in/out
    if (scrollY >= windowHeight * 0.5 && scrollY < windowHeight * 2) {
      const progress = (scrollY - windowHeight * 0.5) / windowHeight;
      const opacity = progress < 0.5 ? progress * 2 : Math.max(0, 2 - progress * 2);
      secondContent.style.opacity = opacity;
    }

    // Transição com nuvens - começa após segunda seção
    if (scrollY >= windowHeight * 1.5 && scrollY < windowHeight * 3) {
      const progress = (scrollY - windowHeight * 1.5) / (windowHeight * 1.5);

      // Nuvens se expandem
      clouds.forEach((cloud, index) => {
        const scale = 1 + progress * (2 + index * 0.5);
        const translateX = (index % 2 === 0 ? -1 : 1) * progress * 100;
        cloud.style.transform = `scale(${scale}) translateX(${translateX}px)`;
        cloud.style.opacity = Math.min(progress * 2, 1);
      });

      // Fade out dos pássaros
      container.style.opacity = 1 - progress;
    }

    // Seção do barco - fade in
    if (scrollY >= windowHeight * 2) {
      const progress = Math.min((scrollY - windowHeight * 2) / windowHeight, 1);
      boatSection.style.opacity = progress;
    } else {
      boatSection.style.opacity = 0;
    }
  });
});

window.addEventListener('resize', () => {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
});
</script>