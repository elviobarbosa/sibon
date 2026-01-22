import $ from "jquery";
import Menu from "./components/menu";
import Hero from "./components/hero";
import HeroParallax from "./components/hero-parallax";
import Carrosel from "./components/carrosel";
import FaqToggle from "./components/faq";
import JumpNavMenu from "./components/jump-nav-menu";

function domReady(fn) {
  document.addEventListener("DOMContentLoaded", fn);
  if (
    document.readyState === "interactive" ||
    document.readyState === "complete"
  ) {
    new Menu();
    new Hero();
    new HeroParallax();
    new Carrosel();
    new FaqToggle();
    new JumpNavMenu();
  } else {
    setTimeout(() => {
      domReady(fn);
    }, 100);
  }
}

domReady(() => {});
