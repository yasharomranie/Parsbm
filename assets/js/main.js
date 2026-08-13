/* Pars Blow Molding Technology — site interactions */
(() => {
  "use strict";

  /* ---------------------------- Theme (dark/light) --------------------------- */
  const THEME_KEY = "pars-bm-theme";
  const root = document.documentElement;

  function applyTheme(theme) {
    if (theme === "dark" || theme === "light") {
      root.setAttribute("data-theme", theme);
    } else {
      root.removeAttribute("data-theme");
    }
    document
      .querySelectorAll('meta[name="theme-color"]')
      .forEach((m) => m.setAttribute("content", getComputedStyle(root).getPropertyValue("--color-bg").trim() || "#f7f8fc"));
  }

  const storedTheme = localStorage.getItem(THEME_KEY);
  applyTheme(storedTheme);

  function currentIsDark() {
    const attr = root.getAttribute("data-theme");
    if (attr === "dark") return true;
    if (attr === "light") return false;
    return window.matchMedia("(prefers-color-scheme: dark)").matches;
  }

  document.querySelectorAll("[data-theme-toggle]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const next = currentIsDark() ? "light" : "dark";
      applyTheme(next);
      localStorage.setItem(THEME_KEY, next);
    });
  });

  /* --------------------------------- Header state ------------------------------ */
  const header = document.querySelector(".site-header");
  const onScrollHeader = () => {
    if (!header) return;
    header.classList.toggle("is-scrolled", window.scrollY > 12);
  };
  onScrollHeader();
  window.addEventListener("scroll", onScrollHeader, { passive: true });

  /* --------------------------------- Mobile drawer ------------------------------ */
  const drawer = document.querySelector("[data-drawer]");
  const drawerOpeners = document.querySelectorAll("[data-drawer-open]");
  const drawerClosers = document.querySelectorAll("[data-drawer-close]");

  function openDrawer() {
    drawer?.classList.add("is-open");
    document.body.style.overflow = "hidden";
    drawerOpeners.forEach((b) => b.setAttribute("aria-expanded", "true"));
  }
  function closeDrawer() {
    drawer?.classList.remove("is-open");
    document.body.style.overflow = "";
    drawerOpeners.forEach((b) => b.setAttribute("aria-expanded", "false"));
  }
  drawerOpeners.forEach((b) => b.addEventListener("click", openDrawer));
  drawerClosers.forEach((b) => b.addEventListener("click", closeDrawer));
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeDrawer();
  });

  /* Mobile accordion (product categories inside drawer) */
  document.querySelectorAll(".mobile-accordion__trigger").forEach((trigger) => {
    trigger.addEventListener("click", () => {
      trigger.closest(".mobile-accordion")?.classList.toggle("is-open");
      const expanded = trigger.getAttribute("aria-expanded") === "true";
      trigger.setAttribute("aria-expanded", String(!expanded));
    });
  });

  /* ------------------------------------ Hero slider ------------------------------ */
  const heroSlider = document.querySelector("[data-hero-slider]");
  if (heroSlider) {
    const slides = Array.from(heroSlider.querySelectorAll(".hero__slide"));
    const dotsWrap = heroSlider.querySelector("[data-hero-dots]");
    const prevBtn = heroSlider.querySelector("[data-hero-prev]");
    const nextBtn = heroSlider.querySelector("[data-hero-next]");
    let active = slides.findIndex((s) => s.classList.contains("is-active"));
    if (active < 0) active = 0;
    let timer = null;
    const AUTOPLAY_MS = 6500;
    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const dots = slides.map((_, i) => {
      const dot = document.createElement("button");
      dot.type = "button";
      // Plain .hero__dots renders these as small bars (font-size:0 in CSS);
      // .hero__tabs (category hero) shows the number as a visible pill label.
      dot.textContent = (i + 1).toLocaleString("fa-IR");
      dot.setAttribute("aria-label", `اسلاید ${i + 1}`);
      dot.addEventListener("click", () => goTo(i, true));
      dotsWrap?.appendChild(dot);
      return dot;
    });

    function render() {
      slides.forEach((s, i) => s.classList.toggle("is-active", i === active));
      dots.forEach((d, i) => d.classList.toggle("is-active", i === active));
    }

    function goTo(index, userTriggered) {
      active = (index + slides.length) % slides.length;
      render();
      if (userTriggered) restart();
    }

    function next() { goTo(active + 1); }
    function prev() { goTo(active - 1); }

    function restart() {
      if (reduceMotion) return;
      clearInterval(timer);
      timer = setInterval(next, AUTOPLAY_MS);
    }

    prevBtn?.addEventListener("click", () => goTo(active - 1, true));
    nextBtn?.addEventListener("click", () => goTo(active + 1, true));
    heroSlider.addEventListener("mouseenter", () => clearInterval(timer));
    heroSlider.addEventListener("mouseleave", restart);
    heroSlider.addEventListener("focusin", () => clearInterval(timer));
    heroSlider.addEventListener("focusout", restart);

    document.addEventListener("visibilitychange", () => {
      if (document.hidden) clearInterval(timer);
      else restart();
    });

    render();
    restart();
  }

  /* ------------------------------------ Sample filter ------------------------------ */
  const filterTabs = document.querySelectorAll("[data-filter]");
  const sampleCards = document.querySelectorAll("[data-sample-cat]");
  filterTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      filterTabs.forEach((t) => t.classList.remove("is-active"));
      tab.classList.add("is-active");
      const value = tab.getAttribute("data-filter");
      sampleCards.forEach((card) => {
        const match = value === "all" || card.getAttribute("data-sample-cat") === value;
        card.style.display = match ? "" : "none";
      });
    });
  });

  /* ------------------------------------ Scroll reveal ------------------------------ */
  const revealEls = document.querySelectorAll("[data-reveal]");
  if ("IntersectionObserver" in window && revealEls.length) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: "0px 0px -60px 0px" }
    );
    revealEls.forEach((el, i) => {
      el.style.setProperty("--i", i % 6);
      io.observe(el);
    });
  } else {
    revealEls.forEach((el) => el.classList.add("is-visible"));
  }

  /* ------------------------------------ Counters ------------------------------ */
  const counters = document.querySelectorAll("[data-counter]");
  if ("IntersectionObserver" in window && counters.length) {
    const countIo = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          const target = parseFloat(el.getAttribute("data-counter"));
          const suffix = el.getAttribute("data-counter-suffix") || "";
          const duration = 1400;
          const start = performance.now();
          function tick(now) {
            const p = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString("fa-IR") + suffix;
            if (p < 1) requestAnimationFrame(tick);
          }
          requestAnimationFrame(tick);
          countIo.unobserve(el);
        });
      },
      { threshold: 0.6 }
    );
    counters.forEach((el) => countIo.observe(el));
  }

  /* ------------------------------------ Active nav + bottom nav sync -------------- */
  const sections = document.querySelectorAll("main section[id]");
  const navLinks = document.querySelectorAll(".nav-link[href^='#'], .bottom-nav__item[href^='#']");
  if ("IntersectionObserver" in window && sections.length) {
    const navIo = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          const id = entry.target.getAttribute("id");
          navLinks.forEach((link) => {
            link.classList.toggle("is-active", link.getAttribute("href") === `#${id}`);
          });
        });
      },
      { rootMargin: "-45% 0px -50% 0px" }
    );
    sections.forEach((s) => navIo.observe(s));
  }

  /* ------------------------------------ Back to top ------------------------------ */
  const backToTop = document.querySelector("[data-back-to-top]");
  window.addEventListener(
    "scroll",
    () => backToTop?.classList.toggle("is-visible", window.scrollY > 700),
    { passive: true }
  );
  backToTop?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

  /* ------------------------------------ Pagination (category.html grid) ---------- */
  const paginationEls = document.querySelectorAll("[data-pagination]");
  paginationEls.forEach((pagination) => {
    const gridSel = pagination.getAttribute("data-pagination");
    const grid = document.querySelector(gridSel);
    if (!grid) return;
    const pageButtons = Array.from(pagination.querySelectorAll("[data-page]"));
    const prevBtn = pagination.querySelector("[data-page-prev]");
    const nextBtn = pagination.querySelector("[data-page-next]");
    const totalPages = pageButtons.length;

    function showPage(page) {
      grid.querySelectorAll("[data-item-page]").forEach((item) => {
        item.style.display = Number(item.getAttribute("data-item-page")) === page ? "" : "none";
      });
      pageButtons.forEach((b) => b.classList.toggle("is-active", Number(b.getAttribute("data-page")) === page));
      if (prevBtn) prevBtn.disabled = page <= 1;
      if (nextBtn) nextBtn.disabled = page >= totalPages;
      pagination.dataset.current = String(page);
    }

    pageButtons.forEach((b) => {
      b.addEventListener("click", () => {
        showPage(Number(b.getAttribute("data-page")));
        grid.scrollIntoView({ block: "start", behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth" });
      });
    });
    prevBtn?.addEventListener("click", () => showPage(Math.max(1, Number(pagination.dataset.current || 1) - 1)));
    nextBtn?.addEventListener("click", () => showPage(Math.min(totalPages, Number(pagination.dataset.current || 1) + 1)));

    showPage(1);
  });

  /* ------------------------------------ Footer year (Persian calendar) ----------- */
  const yearEl = document.querySelector("[data-year]");
  if (yearEl) {
    try {
      yearEl.textContent = new Intl.DateTimeFormat("fa-IR-u-ca-persian", { year: "numeric" }).format(new Date());
    } catch (e) {
      yearEl.textContent = new Date().getFullYear().toString();
    }
  }

  /* Close mobile drawer automatically when a nav link is clicked */
  document.querySelectorAll(".mobile-nav-list a[href^='#']").forEach((a) => {
    a.addEventListener("click", closeDrawer);
  });
})();
