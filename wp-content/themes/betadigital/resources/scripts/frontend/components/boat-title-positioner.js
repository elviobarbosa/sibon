/**
 * Posiciona o título do hero dinamicamente no céu da imagem dos barcos.
 *
 * A imagem hero-parallax-boats.png tem 1920×1323px.
 * Os barcos começam em Y=882px — tudo acima é céu.
 * O título é centralizado verticalmente nessa área de céu.
 */

const IMG_NATURAL_WIDTH  = 1920;
const BOAT_START_Y_PX    = 520;   // px do topo na imagem original

export default class BoatTitlePositioner {
  constructor() {
    this.section = document.querySelector('.hero-parallax__section--boat');
    this.title   = this.section?.querySelector('.hero-parallax__title');

    if (!this.section || !this.title) return;

    this._onResize = () => this._position();
    window.addEventListener('resize', this._onResize);
    this._position();
  }

  _position() {
    const containerWidth = this.section.offsetWidth;
    const scale          = containerWidth / IMG_NATURAL_WIDTH;
    const boatStartY     = BOAT_START_Y_PX * scale;
    const titleHeight    = this.title.offsetHeight;

    // Centraliza o título na área de céu (entre topo e início dos barcos)
    const titleTop = boatStartY / 2 - titleHeight / 2;

    this.title.style.top       = `${Math.max(titleTop, 16)}px`;
    this.title.style.left      = '50%';
    this.title.style.transform = 'translateX(-50%)';
  }

  destroy() {
    window.removeEventListener('resize', this._onResize);
  }
}
