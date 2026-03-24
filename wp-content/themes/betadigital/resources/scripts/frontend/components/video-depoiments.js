import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

export default class VideoDepoiments {
  constructor() {
    this.section = document.querySelector('.video-depoiments');
    if (!this.section) return;
    this.init();
  }

  init() {
    Fancybox.bind('[data-fancybox="video-depoiments"]', {
      type: 'iframe',
      iframe: {
        css: {
          width:  '90vw',
          height: '80vh',
        },
      },
    });
  }
}
