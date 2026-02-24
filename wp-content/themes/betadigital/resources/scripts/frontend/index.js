import $ from "jquery";
import Menu from "./components/menu";
import Hero from "./components/hero";
import HeroParallax from "./components/hero-parallax";
import Carrosel from "./components/carrosel";
import FaqToggle from "./components/faq";
import JumpNavMenu from "./components/jump-nav-menu";
import TextAnimation from "./components/text-animation";
import WaveLines from "./components/wave-lines";
import RandomImages from "./components/random-images";
import Unforgettable from "./components/unforgettable";
import FeatureSlide from "./components/feature-slide";
import HeroCharters from "./components/hero-charters";
import PhotoSlide from "./components/photo-slide";
import ScheduleBooking from "./components/schedule-booking";
import Depoiments from "./components/depoiments";
import CtaBoatAnimation from "./components/cta-boat-animation";

function domReady(fn) {
  document.addEventListener("DOMContentLoaded", fn);
  if (
    document.readyState === "interactive" ||
    document.readyState === "complete"
  ) {
    new Menu();
    new Hero();
    new WaveLines();
    new HeroParallax();
    new Carrosel();
    new FaqToggle();
    new JumpNavMenu();
    new TextAnimation();
    new RandomImages();
    new Unforgettable();
    new FeatureSlide();
    new HeroCharters();
    new PhotoSlide();
    new ScheduleBooking();
    new Depoiments();
    new CtaBoatAnimation();
  } else {
    setTimeout(() => {
      domReady(fn);
    }, 100);
  }
}

domReady(() => {});
