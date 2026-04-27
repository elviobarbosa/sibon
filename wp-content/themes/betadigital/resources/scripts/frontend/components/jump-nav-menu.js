export default class JumpNavMenu {
  constructor(options = {}) {
    this.selector = document.querySelector("nav");
    if (!this.selector) return;

    this.options = {
      scrollSpeed: 800,
      offset: 50,
      ...options,
    };

    this.init();
  }

  init() {
    this.selector.querySelectorAll("a").forEach((link) => {
      const href = link.getAttribute("href");
      if (href && href.startsWith("#")) {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          this.scrollToTarget(href);
        });
      }
    });
  }

  scrollToTarget(targetId) {
    const target = document.querySelector(targetId);
    if (!target) {
      console.warn(`Elemento com ID ${targetId} não encontrado`);
      return;
    }

    this.closeMobileMenu();

    const targetPosition =
      target.getBoundingClientRect().top + window.scrollY - this.options.offset;

    window.scrollTo({
      top: targetPosition,
      behavior: "smooth",
    });

    if (history.pushState) {
      history.pushState(null, null, targetId);
    }
  }

  closeMobileMenu() {
    const toggle = document.querySelector(".nav-container__toggle");
    if (toggle && toggle.checked) {
      toggle.checked = false;
    }
  }

  updateActiveMenuItem() {
    const scrollPos = window.scrollY + this.options.offset + 10;

    this.selector.querySelectorAll('a[href^="#"]').forEach((link) => {
      const targetId = link.getAttribute("href");
      const target = document.querySelector(targetId);

      if (target) {
        const targetTop =
          target.getBoundingClientRect().top + window.scrollY;
        const targetBottom = targetTop + target.offsetHeight;

        if (scrollPos >= targetTop && scrollPos < targetBottom) {
          link.classList.add("active");
        } else {
          link.classList.remove("active");
        }
      }
    });
  }

  enableActiveHighlight() {
    window.addEventListener("scroll", () => {
      this.updateActiveMenuItem();
    });
    this.updateActiveMenuItem();
  }

  enableOverlayClose() {
    const overlay = document.querySelector(".nav-overlay");
    if (overlay) {
      overlay.addEventListener("click", () => {
        this.closeMobileMenu();
      });
    }
  }

  enableEscapeClose() {
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        this.closeMobileMenu();
      }
    });
  }
}
