export default class ScheduleBooking {
  constructor() {
    this.selector = ".schedule-booking";
    this.tripSelect = null; // custom <select> injetado
    this.tripInput = null;  // input[name="trip-date"] do CF7
    this.init();
  }

  init() {
    const container = document.querySelector(this.selector);
    if (!container) return;

    this.initNavHeight();
    this.initYearTabs(container);
    this.initEnquireSelect(container);
    this.initEnquireLinks(container);
  }

  // ─── Mede o nav e expõe como CSS var para o sticky header ──────────────
  initNavHeight() {
    const nav = document.querySelector(".nav-container");
    if (!nav) return;

    const update = () => {
      document.documentElement.style.setProperty(
        "--nav-h",
        nav.offsetHeight + "px"
      );
    };

    update();
    window.addEventListener("resize", update);
  }

  // ─── Troca de abas por ano ──────────────────────────────────────────────
  initYearTabs(container) {
    const tabs = container.querySelectorAll(".schedule-booking__year-tab");
    const grids = container.querySelectorAll(".schedule-booking__grid");

    if (!tabs.length) return;

    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        const year = tab.dataset.year;

        tabs.forEach((t) => {
          t.classList.remove("is-active");
          t.setAttribute("aria-pressed", "false");
        });

        tab.classList.add("is-active");
        tab.setAttribute("aria-pressed", "true");

        grids.forEach((grid) => {
          if (grid.dataset.year === year) {
            grid.removeAttribute("hidden");
          } else {
            grid.setAttribute("hidden", "");
          }
        });
      });
    });
  }

  // ─── Injeta <select> visual no lugar do [text* trip-date] do CF7 ────────
  // O [select*] do CF7 valida enum server-side e rejeita opções dinâmicas.
  // Usando [text* trip-date] no CF7 + select injetado via JS, o valor é
  // sincronizado para o input antes do envio — sem erro de validação.
  initEnquireSelect(container) {
    const datesJson = container.dataset.dates;
    if (!datesJson) return;

    let dates;
    try {
      dates = JSON.parse(datesJson);
    } catch (e) {
      return;
    }

    if (!dates.length) return;

    requestAnimationFrame(() => {
      const tripInput = document.querySelector(
        '#enquire input[name="trip-date"]'
      );
      if (!tripInput) return;

      // Cria o <select> visual
      const select = document.createElement("select");
      select.className = "wpcf7-form-control enquire-form__trip-select";

      const placeholder = document.createElement("option");
      placeholder.value = "";
      placeholder.textContent = "— Select a trip date —";
      select.appendChild(placeholder);

      dates.forEach((d) => {
        const opt = document.createElement("option");
        opt.value = d.value;
        opt.textContent = d.label;
        select.appendChild(opt);
      });

      // Sincroniza select → input do CF7
      select.addEventListener("change", () => {
        tripInput.value = select.value;
      });

      // Insere o select antes do wrap do CF7 e esconde o input original
      const wrap = tripInput.closest(".wpcf7-form-control-wrap");
      if (wrap) {
        wrap.parentNode.insertBefore(select, wrap);
        wrap.style.display = "none";
      }

      this.tripSelect = select;
      this.tripInput = tripInput;
    });
  }

  // ─── Click na linha: scroll + pré-seleciona a data ─────────────────────
  initEnquireLinks(container) {
    container.querySelectorAll(".schedule-booking__card").forEach((card) => {
      const cta = card.querySelector("a.schedule-booking__cta");
      if (!cta) return; // somente linhas com ação disponível

      card.addEventListener("click", (e) => {
        e.preventDefault();

        const period = cta.dataset.period;
        const target = document.querySelector("#enquire");
        if (!target) return;

        target.scrollIntoView({ behavior: "smooth" });

        if (period) {
          requestAnimationFrame(() => {
            if (this.tripSelect) this.tripSelect.value = period;
            if (this.tripInput) this.tripInput.value = period;
          });
        }
      });
    });
  }
}
