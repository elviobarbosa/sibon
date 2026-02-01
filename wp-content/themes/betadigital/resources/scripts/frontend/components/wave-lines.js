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

  createWaves() {
    const colors = ['#D0E4FA', '#76A6DE', '#C8DCF4', '#76A6DE'];

    colors.forEach((color, index) => {
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('class', `wave-line wave-line--${index + 1}`);
      svg.setAttribute('viewBox', '0 0 1200 100');
      svg.setAttribute('preserveAspectRatio', 'none');

      const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttribute('stroke', color);
      path.setAttribute('stroke-width', '1');
      path.setAttribute('fill', 'none');

      svg.appendChild(path);
      this.container.appendChild(svg);

      // Configurações aleatórias para cada linha (orgânico)
      this.waves.push({
        path,
        amplitude: 15 + Math.random() * 25, // 15-40
        frequency: 0.01 + Math.random() * 0.02, // 0.01-0.03
        phaseOffset: Math.random() * Math.PI * 2,
        opacity: 0.4 + Math.random() * 0.4, // 0.4-0.8
        animationSpeed: 0.03 + Math.random() * 0.04 // 0.03-0.07
      });
    });
  }

  animate() {
    this.waves.forEach((wave) => {
      let d = 'M 0 50 ';

      // Gerar path com animação contínua baseada no frame
      for (let x = 0; x <= 1200; x += 5) {
        const y = 50 + Math.sin(
          x * wave.frequency +
          this.frame * wave.animationSpeed +
          wave.phaseOffset
        ) * wave.amplitude;
        d += `L ${x} ${y} `;
      }

      wave.path.setAttribute('d', d);
      wave.path.setAttribute('opacity', wave.opacity);
    });

    this.frame++;
    requestAnimationFrame(() => this.animate());
  }
}
