export default class WaveLines {
  constructor() {
    this.container = document.getElementById('wave-lines-container');
    if (!this.container) return;

    this.waves = [];
    this.frame = 0;
    this.init();
  }

  init() {
    this.createWaves();
    this.animate();
  }

  // Gera posições randômicas evitando sobreposição
  generateRandomPositions(count) {
    const positions = [];
    const minGap = 10;

    for (let i = 0; i < count; i++) {
      let top;
      let attempts = 0;

      do {
        top = 10 + Math.random() * 70;
        attempts++;
      } while (
        positions.some(p => Math.abs(p - top) < minGap) &&
        attempts < 50
      );

      positions.push(top);
    }

    return positions;
  }

  createWaves() {
    const colors = ['#D0E4FA', '#76A6DE', '#C8DCF4', '#76A6DE', '#A8C8E8'];
    const positions = this.generateRandomPositions(colors.length);

    colors.forEach((color, index) => {
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('class', 'wave-line');
      svg.setAttribute('viewBox', '0 0 1200 100');
      svg.setAttribute('preserveAspectRatio', 'none');

      const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttribute('stroke', color);
      path.setAttribute('stroke-width', '1');
      path.setAttribute('fill', 'none');

      svg.appendChild(path);
      this.container.appendChild(svg);

      const baseAmplitude = 6 + Math.random() * 10;

      // Posição e rotação inicial randômica
      const initialTop = positions[index];
      const initialLeft = -20 + Math.random() * 20;
      const initialRotation = -8 + Math.random() * 16; // -8 a +8 graus

      this.waves.push({
        svg,
        path,
        // Amplitude
        amplitude: baseAmplitude,
        amplitudeVariation: baseAmplitude * 0.2,
        amplitudePhase: Math.random() * Math.PI * 2,
        amplitudeSpeed: 0.0002 + Math.random() * 0.0003,
        // Frequência e fase
        frequency: 0.005 + Math.random() * 0.008,
        phaseOffset: Math.random() * Math.PI * 2,
        animationSpeed: 0.010 + Math.random() * 0.012,
        // Opacidade
        opacity: 0.2 + Math.random() * 0.25,
        // Posicionamento dinâmico
        currentTop: initialTop,
        currentLeft: initialLeft,
        currentRotation: initialRotation,
        targetTop: initialTop,
        targetLeft: initialLeft,
        targetRotation: initialRotation,
        // Timing para reposicionamento
        repositionTimer: Math.random() * 700,
        repositionInterval: 800 + Math.random() * 600,
        transitionSpeed: 0.001 + Math.random() * 0.002
      });

      // Aplicar posição inicial
      svg.style.top = `${initialTop}%`;
      svg.style.left = `${initialLeft}%`;
      svg.style.transform = `rotate(${initialRotation}deg)`;
    });
  }

  lerp(current, target, speed) {
    return current + (target - current) * speed;
  }

  animate() {
    this.waves.forEach((wave) => {
      wave.repositionTimer++;

      // Definir novos targets periodicamente
      if (wave.repositionTimer >= wave.repositionInterval) {
        wave.targetTop = wave.currentTop + (-3 + Math.random() * 6);
        wave.targetLeft = wave.currentLeft + (-2 + Math.random() * 4);
        wave.targetRotation = -8 + Math.random() * 16;

        // Limitar dentro dos bounds
        wave.targetTop = Math.max(5, Math.min(85, wave.targetTop));
        wave.targetLeft = Math.max(-25, Math.min(15, wave.targetLeft));

        wave.repositionTimer = 0;
        wave.repositionInterval = 500 + Math.random() * 400;
      }

      // Interpolar suavemente
      wave.currentTop = this.lerp(wave.currentTop, wave.targetTop, wave.transitionSpeed);
      wave.currentLeft = this.lerp(wave.currentLeft, wave.targetLeft, wave.transitionSpeed);
      wave.currentRotation = this.lerp(wave.currentRotation, wave.targetRotation, wave.transitionSpeed);

      // Aplicar transformações
      wave.svg.style.top = `${wave.currentTop}%`;
      wave.svg.style.left = `${wave.currentLeft}%`;
      wave.svg.style.transform = `rotate(${wave.currentRotation}deg)`;

      // Gerar path da onda
      let d = 'M 0 50 ';

      const amplitudeModulation = Math.sin(
        this.frame * wave.amplitudeSpeed + wave.amplitudePhase
      ) * wave.amplitudeVariation;

      const currentAmplitude = wave.amplitude + amplitudeModulation;

      for (let x = 0; x <= 1200; x += 5) {
        const y = 50 + Math.sin(
          x * wave.frequency +
          this.frame * wave.animationSpeed +
          wave.phaseOffset
        ) * currentAmplitude;
        d += `L ${x} ${y} `;
      }

      wave.path.setAttribute('d', d);
      wave.path.setAttribute('opacity', wave.opacity);
    });

    this.frame++;
    requestAnimationFrame(() => this.animate());
  }
}
