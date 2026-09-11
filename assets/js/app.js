(() => {
  const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function glyph(charset, i) {
    return charset.charAt(((i % charset.length) + charset.length) % charset.length);
  }

  function scramble(text, charset, tick) {
    let out = "";
    for (let i = 0; i < text.length; i += 1) {
      const ch = text[i];
      out += ch === " " || ch === "\n" ? ch : glyph(charset, i * 17 + tick * 13);
    }
    return out;
  }

  function playEncrypt(el) {
    const text = el.getAttribute("data-encrypt") || "";
    const charset = el.getAttribute("data-charset") || "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    const encClass = el.getAttribute("data-enc-class") || "text-primary";
    const revClass = el.getAttribute("data-rev-class") || "text-fg";
    const delay = Math.max(40, Number(el.getAttribute("data-delay") || 70));
    if (!text) return;

    let revealed = 0;
    let tick = 0;
    const render = () => {
      const scrambled = scramble(text, charset, tick);
      el.replaceChildren();
      for (let i = 0; i < text.length; i += 1) {
        const done = i < revealed;
        const span = document.createElement("span");
        span.dataset.scrambled = done ? "0" : "1";
        span.className = done ? revClass : encClass;
        const ch = text[i];
        span.textContent = ch === " " || ch === "\n" ? ch : done ? ch : scrambled[i];
        el.appendChild(span);
      }
    };

    revealed = 0;
    tick = 0;
    render();
    if (reduce) {
      revealed = text.length;
      render();
      return;
    }
    const flip = window.setInterval(() => {
      tick += 1;
      render();
    }, 45);
    const step = window.setInterval(() => {
      revealed += 1;
      render();
      if (revealed >= text.length) {
        window.clearInterval(step);
        window.clearInterval(flip);
      }
    }, delay);
  }

  document.querySelectorAll("[data-encrypt]").forEach((el) => {
    let last = 0;
    const io = new IntersectionObserver(
      ([entry]) => {
        if (!entry.isIntersecting) return;
        const now = Date.now();
        if (now - last < 1600) return;
        last = now;
        playEncrypt(el);
      },
      { threshold: 0.3 },
    );
    io.observe(el);
  });

  function burstGlitch(root) {
    root.querySelectorAll("[data-glitch-overlay]").forEach((n) => n.remove());
    const jitter = root.querySelector("[data-glitch-body]") || root.firstElementChild;
    if (jitter) {
      jitter.classList.remove("bp-glitch-jitter");
      void jitter.offsetWidth;
      jitter.classList.add("bp-glitch-jitter");
    }
    const wrap = document.createElement("span");
    wrap.setAttribute("data-glitch-overlay", "1");
    wrap.innerHTML =
      '<span class="bp-glitch-slice bp-glitch-slice-1 pointer-events-none absolute inset-0 z-20 overflow-hidden" aria-hidden="true"></span>' +
      '<span class="bp-glitch-slice bp-glitch-slice-2 pointer-events-none absolute inset-0 z-20 overflow-hidden" aria-hidden="true"></span>' +
      '<span class="bp-glitch-slice bp-glitch-slice-3 pointer-events-none absolute inset-0 z-20 overflow-hidden" aria-hidden="true"></span>' +
      '<span class="bp-glitch-scanlines pointer-events-none absolute inset-0 z-30" aria-hidden="true"></span>' +
      '<span class="bp-glitch-static pointer-events-none absolute inset-0 z-30" aria-hidden="true"></span>';
    root.appendChild(wrap);
    window.setTimeout(() => wrap.remove(), 700);
  }

  document.querySelectorAll("[data-glitch]").forEach((root) => {
    const mode = root.getAttribute("data-glitch");
    if (mode === "hover" || mode === "scroll") {
      root.addEventListener("pointerenter", () => burstGlitch(root));
    }
    if (mode === "always") {
      window.setInterval(() => burstGlitch(root), 4200);
    }
  });

  document.querySelectorAll("[data-hero-glitch]").forEach((root) => {
    const src = root.querySelector("img")?.getAttribute("src");
    if (!src) return;
    const replay = () => {
      root.querySelectorAll("[data-hero-burst]").forEach((n) => n.remove());
      const mk = (cls) => {
        const img = document.createElement("img");
        img.src = src;
        img.alt = "";
        img.setAttribute("aria-hidden", "true");
        img.className = "absolute inset-0 size-full object-cover object-right";
        const span = document.createElement("span");
        span.setAttribute("data-hero-burst", "1");
        span.className = cls;
        span.appendChild(img);
        return span;
      };
      root.appendChild(mk("bp-glitch-slice bp-glitch-slice-1 pointer-events-none absolute inset-0 z-20 overflow-hidden"));
      root.appendChild(mk("bp-glitch-slice bp-glitch-slice-2 pointer-events-none absolute inset-0 z-20 overflow-hidden"));
      const scan = document.createElement("span");
      scan.setAttribute("data-hero-burst", "1");
      scan.className = "bp-glitch-scanlines pointer-events-none absolute inset-0 z-30";
      scan.setAttribute("aria-hidden", "true");
      root.appendChild(scan);
    };
    replay();
    window.setInterval(replay, 7800);
    root.addEventListener("pointerenter", replay);
  });

  document.querySelectorAll("[data-ticker]").forEach((el) => {
    const value = Number(el.getAttribute("data-ticker") || 0);
    const suffix = el.getAttribute("data-suffix") || "";
    const locale = el.hasAttribute("data-locale");
    const io = new IntersectionObserver(
      ([entry]) => {
        if (!entry.isIntersecting) return;
        io.disconnect();
        const start = performance.now();
        const dur = 900;
        const tick = (t) => {
          const p = Math.min(1, (t - start) / dur);
          const eased = 1 - (1 - p) ** 3;
          const n = Math.round(value * eased);
          el.textContent = (locale ? n.toLocaleString() : String(n)) + suffix;
          if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
      },
      { threshold: 0.2 },
    );
    io.observe(el);
  });

  const progress = document.querySelector("[data-scroll-progress]");
  if (progress) {
    const onScroll = () => {
      const max = document.documentElement.scrollHeight - window.innerHeight;
      const p = max > 0 ? window.scrollY / max : 0;
      progress.style.transform = `scaleX(${p})`;
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  const pin = document.querySelector("[data-scroll-strip]");
  const row = document.querySelector("[data-scroll-strip-row]");
  if (pin && row) {
    const onScroll = () => {
      const rect = pin.getBoundingClientRect();
      const travel = pin.offsetHeight - window.innerHeight;
      if (travel <= 0) return;
      const scrolled = Math.min(travel, Math.max(0, -rect.top));
      const maxShift = Math.max(0, row.scrollWidth - window.innerWidth + 32);
      row.style.transform = `translateX(${-(scrolled / travel) * maxShift}px)`;
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll);
  }

  const cd = document.querySelector("[data-countdown]");
  if (cd) {
    const target = Date.parse(cd.getAttribute("data-countdown") || "");
    const pad = (n, len = 2) => String(Math.max(0, n)).padStart(len, "0");
    const tick = () => {
      const ms = Math.max(0, target - Date.now());
      const days = Math.floor(ms / 86400000);
      const hours = Math.floor((ms % 86400000) / 3600000);
      const minutes = Math.floor((ms % 3600000) / 60000);
      const seconds = Math.floor((ms % 60000) / 1000);
      const d = cd.querySelector("[data-cd=days]");
      const h = cd.querySelector("[data-cd=hours]");
      const m = cd.querySelector("[data-cd=minutes]");
      const s = cd.querySelector("[data-cd=seconds]");
      if (d) d.textContent = pad(days, 3);
      if (h) h.textContent = pad(hours);
      if (m) m.textContent = pad(minutes);
      if (s) s.textContent = pad(seconds);
    };
    tick();
    window.setInterval(tick, 1000);
  }
})();
