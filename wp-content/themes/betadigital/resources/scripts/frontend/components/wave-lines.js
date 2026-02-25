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

  generateRandomPositions(count) {
    const positions = [];
    const minGap = 18;

    for (let i = 0; i < count; i++) {
      let top;
      let attempts = 0;

      do {
        top = 5 + Math.random() * 80;
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
    const bands = [
      { topColor: 'rgba(118,166,222,0.26)' },
      { topColor: 'rgba(168,200,232,0.20)' },
      { topColor: 'rgba(94,149,206,0.24)'  },
      { topColor: 'rgba(192,216,240,0.18)' },
      { topColor: 'rgba(139,186,224,0.28)' },
    ];

    const positions = this.generateRandomPositions(bands.length);

    bands.forEach((bandDef, index) => {
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.setAttribute('class', 'wave-line');
      svg.setAttribute('viewBox', '0 0 1200 100');
      svg.setAttribute('preserveAspectRatio', 'none');

      // Gradient: blue at top → transparent at bottom
      const defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
      const grad = document.createElementNS('http://www.w3.org/2000/svg', 'linearGradient');
      const gradId = `wg-${index}`;
      grad.setAttribute('id', gradId);
      grad.setAttribute('x1', '0'); grad.setAttribute('y1', '0');
      grad.setAttribute('x2', '0'); grad.setAttribute('y2', '1');

      const s1 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
      s1.setAttribute('offset', '0%');
      s1.setAttribute('stop-color', bandDef.topColor);

      const s2 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
      s2.setAttribute('offset', '100%');
      s2.setAttribute('stop-color', 'rgba(255,255,255,0)');

      grad.appendChild(s1);
      grad.appendChild(s2);
      defs.appendChild(grad);
      svg.appendChild(defs);

      // Filled band path
      const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttribute('fill', `url(#${gradId})`);
      path.setAttribute('stroke', 'none');

      svg.appendChild(path);
      this.container.appendChild(svg);

      const topBaseY = 16 + Math.random() * 10;       // top edge baseline ~16–26
      const bandH    = 30 + Math.random() * 26;       // band height ~30–56
      const botBaseY = topBaseY + bandH;

      const topAmp   = 6 + Math.random() * 9;
      const botAmp   = 4 + Math.random() * 7;

      const initialTop      = positions[index];
      // Distribui horizontalmente pela largura toda usando o índice como base
      const initialLeft     = -60 + index * 18 + (-5 + Math.random() * 10);
      const initialRotation = -45 + (-3 + Math.random() * 6);

      this.waves.push({
        svg,
        path,
        // top edge params
        topBaseY,
        topAmplitude: topAmp,
        topAmpVar:    topAmp * 0.2,
        topAmpPhase:  Math.random() * Math.PI * 2,
        topAmpSpeed:  0.00015 + Math.random() * 0.0002,
        topFreq:      0.004 + Math.random() * 0.005,
        topPhase:     Math.random() * Math.PI * 2,
        topSpeed:     0.006 + Math.random() * 0.006,
        // bottom edge params
        botBaseY,
        botAmplitude: botAmp,
        botAmpVar:    botAmp * 0.2,
        botAmpPhase:  Math.random() * Math.PI * 2,
        botAmpSpeed:  0.0001 + Math.random() * 0.0002,
        botFreq:      0.003 + Math.random() * 0.004,
        botPhase:     Math.random() * Math.PI * 2,
        botSpeed:     0.005 + Math.random() * 0.005,
        // positioning
        currentTop:         initialTop,
        currentLeft:        initialLeft,
        currentRotation:    initialRotation,
        targetTop:          initialTop,
        targetLeft:         initialLeft,
        targetRotation:     initialRotation,
        repositionTimer:    Math.random() * 700,
        repositionInterval: 800 + Math.random() * 600,
        transitionSpeed:    0.001 + Math.random() * 0.002,
      });

      svg.style.top       = `${initialTop}%`;
      svg.style.left      = `${initialLeft}%`;
      svg.style.transform = `rotate(${initialRotation}deg)`;
    });
  }

  lerp(current, target, speed) {
    return current + (target - current) * speed;
  }

  animate() {
    this.waves.forEach((wave) => {
      // Periodic repositioning
      wave.repositionTimer++;
      if (wave.repositionTimer >= wave.repositionInterval) {
        wave.targetTop      = wave.currentTop      + (-3 + Math.random() * 6);
        wave.targetLeft     = wave.currentLeft     + (-2 + Math.random() * 4);
        wave.targetRotation = -45 + (-3 + Math.random() * 6);

        wave.targetTop  = Math.max(5,   Math.min(88,  wave.targetTop));
        wave.targetLeft = Math.max(-65, Math.min(22, wave.targetLeft));

        wave.repositionTimer    = 0;
        wave.repositionInterval = 500 + Math.random() * 400;
      }

      // Smooth interpolation
      wave.currentTop      = this.lerp(wave.currentTop,      wave.targetTop,      wave.transitionSpeed);
      wave.currentLeft     = this.lerp(wave.currentLeft,     wave.targetLeft,     wave.transitionSpeed);
      wave.currentRotation = this.lerp(wave.currentRotation, wave.targetRotation, wave.transitionSpeed);

      wave.svg.style.top       = `${wave.currentTop}%`;
      wave.svg.style.left      = `${wave.currentLeft}%`;
      wave.svg.style.transform = `rotate(${wave.currentRotation}deg)`;

      // Modulate amplitudes
      const topAmp = wave.topAmplitude +
        Math.sin(this.frame * wave.topAmpSpeed + wave.topAmpPhase) * wave.topAmpVar;
      const botAmp = wave.botAmplitude +
        Math.sin(this.frame * wave.botAmpSpeed + wave.botAmpPhase) * wave.botAmpVar;

      // Top edge: left → right
      let d = `M 0 ${wave.topBaseY + Math.sin(wave.topPhase) * topAmp} `;
      for (let x = 5; x <= 1200; x += 5) {
        const y = wave.topBaseY + Math.sin(
          x * wave.topFreq + this.frame * wave.topSpeed + wave.topPhase
        ) * topAmp;
        d += `L ${x} ${y} `;
      }

      // Bottom edge: right → left (closes the filled band)
      for (let x = 1200; x >= 0; x -= 5) {
        const y = wave.botBaseY + Math.sin(
          x * wave.botFreq + this.frame * wave.botSpeed + wave.botPhase
        ) * botAmp;
        d += `L ${x} ${y} `;
      }

      d += 'Z';

      wave.path.setAttribute('d', d);
    });

    this.frame++;
    requestAnimationFrame(() => this.animate());
  }
}
