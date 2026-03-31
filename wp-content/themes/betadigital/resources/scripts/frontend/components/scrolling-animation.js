export default class ScrollingAnimation {

    constructor() {
        this.selector = '.js-scroll';
        this.init();
    }

    init() {
        const elements = document.querySelectorAll(this.selector);
        if (elements.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('scrolled');
                } else {
                    entry.target.classList.remove('scrolled');
                }
            });
        }, {
            rootMargin: '-10% 0px -10% 0px',
            threshold: 0
        });

        elements.forEach((el) => observer.observe(el));
    }
}