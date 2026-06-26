// Fintriva homepage interactions: scroll reveal, 3D tilt, animated counters, mobile nav.

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initTilt();
    initCounters();
    initMobileNav();
    initNavScrollState();
    initTradePanel();
    initScrollProgress();
    initSpotlight();
    initConstellation();
    initRotatingWord();
    initMagnetic();
    initLivePrices();
    initFaq();
});

/* Reveal elements as they scroll into view */
function initScrollReveal() {
    const items = document.querySelectorAll('.reveal');
    if (reduceMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.delay || 0;
                    setTimeout(() => entry.target.classList.add('is-visible'), delay);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12 }
    );
    items.forEach((el) => observer.observe(el));
}

/* Mouse-driven 3D tilt on [data-tilt] cards */
function initTilt() {
    if (reduceMotion) return;
    document.querySelectorAll('[data-tilt]').forEach((card) => {
        const max = 12;
        card.addEventListener('mousemove', (e) => {
            const r = card.getBoundingClientRect();
            const px = (e.clientX - r.left) / r.width;
            const py = (e.clientY - r.top) / r.height;
            card.style.setProperty('--ry', `${(px - 0.5) * max}deg`);
            card.style.setProperty('--rx', `${(0.5 - py) * max}deg`);
        });
        card.addEventListener('mouseleave', () => {
            card.style.setProperty('--ry', '0deg');
            card.style.setProperty('--rx', '0deg');
        });
    });
}

/* Count-up stat numbers when they enter view */
function initCounters() {
    const counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;

    const run = (el) => {
        const target = parseFloat(el.dataset.count);
        const decimals = parseInt(el.dataset.decimals || '0', 10);
        const prefix = el.dataset.prefix || '';
        const suffix = el.dataset.suffix || '';
        if (reduceMotion) {
            el.textContent = prefix + target.toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + suffix;
            return;
        }
        const duration = 1600;
        const start = performance.now();
        const tick = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            const val = target * eased;
            el.textContent = prefix + val.toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + suffix;
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                run(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach((el) => observer.observe(el));
}

/* Full-screen mobile navigation */
function initMobileNav() {
    const btn = document.querySelector('[data-nav-toggle]');
    const menu = document.querySelector('[data-nav-menu]');
    if (!btn || !menu) return;

    const closeBtn = menu.querySelector('[data-nav-close]');

    const setOpen = (open) => {
        menu.classList.toggle('hidden', !open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
    };

    btn.addEventListener('click', () => setOpen(true));
    closeBtn?.addEventListener('click', () => setOpen(false));
    menu.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => setOpen(false)));

    // Close on Escape or when resizing up to desktop.
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') setOpen(false);
    });
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) setOpen(false);
    });
}

/* Interactive demo trade panel with a simulated live price */
function initTradePanel() {
    const panel = document.querySelector('[data-trade]');
    if (!panel) return;

    const priceEl = panel.querySelector('[data-trade-price]');
    const changeEl = panel.querySelector('[data-trade-change]');
    const amountEl = panel.querySelector('[data-trade-amount]');
    const qtyEl = panel.querySelector('[data-trade-qty]');
    const feeEl = panel.querySelector('[data-trade-fee]');
    const submitEl = panel.querySelector('[data-trade-submit]');
    const buyBtn = panel.querySelector('[data-trade-side="buy"]');
    const sellBtn = panel.querySelector('[data-trade-side="sell"]');

    const symbol = panel.dataset.trade || 'BTCUSDT';
    let price = parseFloat(panel.dataset.tradePrice) || 0;
    let side = 'buy';

    const fmt = (n, d = 2) => n.toLocaleString(undefined, { minimumFractionDigits: d, maximumFractionDigits: d });

    function recalc() {
        const amount = parseFloat(amountEl.value) || 0;
        qtyEl.textContent = (price > 0 ? (amount / price).toFixed(5) : '0.00000') + ' BTC';
        feeEl.textContent = '$' + fmt(amount * 0.001);
    }

    function paintSide() {
        const buying = side === 'buy';
        buyBtn.classList.toggle('bg-emerald', buying);
        buyBtn.classList.toggle('text-emerald-950', buying);
        buyBtn.classList.toggle('text-white/60', !buying);
        sellBtn.classList.toggle('bg-rose-500', !buying);
        sellBtn.classList.toggle('text-rose-950', !buying);
        sellBtn.classList.toggle('text-white/60', buying);
        submitEl.textContent = buying ? 'Buy BTC' : 'Sell BTC';
        submitEl.classList.toggle('btn-glow', buying);
        submitEl.classList.toggle('bg-rose-500', !buying);
    }

    buyBtn.addEventListener('click', () => { side = 'buy'; paintSide(); });
    sellBtn.addEventListener('click', () => { side = 'sell'; paintSide(); });

    amountEl.addEventListener('input', recalc);
    panel.querySelectorAll('[data-trade-quick]').forEach((b) =>
        b.addEventListener('click', () => { amountEl.value = b.dataset.tradeQuick; recalc(); })
    );
    panel.querySelectorAll('[data-trade-lev]').forEach((b) =>
        b.addEventListener('click', () => {
            panel.querySelectorAll('[data-trade-lev]').forEach((x) => {
                x.classList.remove('bg-brand/20', 'text-brand-bright', 'ring-brand/40');
                x.classList.add('bg-white/5', 'text-white/60');
            });
            b.classList.remove('bg-white/5', 'text-white/60');
            b.classList.add('bg-brand/20', 'text-brand-bright', 'ring-brand/40');
        })
    );

    submitEl.addEventListener('click', () => {
        const original = submitEl.textContent;
        submitEl.textContent = (side === 'buy' ? 'Buy' : 'Sell') + ' order placed ✓';
        setTimeout(() => { submitEl.textContent = original; }, 1800);
    });

    // Real live price from Binance (free, no key, accurate).
    async function fetchPrice() {
        try {
            const res = await fetch('https://api.binance.com/api/v3/ticker/24hr?symbol=' + symbol);
            if (!res.ok) return;
            const d = await res.json();
            const prev = price;
            price = parseFloat(d.lastPrice);
            const pct = parseFloat(d.priceChangePercent);
            priceEl.textContent = fmt(price);
            changeEl.textContent = (pct >= 0 ? '+' : '') + pct.toFixed(2) + '%';
            changeEl.classList.toggle('text-emerald', pct >= 0);
            changeEl.classList.toggle('text-rose-400', pct < 0);
            priceEl.classList.remove('text-emerald', 'text-rose-400');
            if (prev && price !== prev) {
                priceEl.classList.add(price >= prev ? 'text-emerald' : 'text-rose-400');
                setTimeout(() => priceEl.classList.remove('text-emerald', 'text-rose-400'), 500);
            }
            recalc();
        } catch (e) {
            /* keep last known price on network error */
        }
    }

    recalc();
    paintSide();
    fetchPrice();
    setInterval(fetchPrice, 15000);
}

/* Thin gradient bar showing how far down the page the user is */
function initScrollProgress() {
    const bar = document.getElementById('scroll-progress');
    if (!bar) return;
    const update = () => {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.width = (max > 0 ? (window.scrollY / max) * 100 : 0) + '%';
    };
    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
}

/* Soft glow that follows the cursor inside the hero */
function initSpotlight() {
    const el = document.querySelector('[data-spotlight]');
    if (!el || reduceMotion) return;
    const section = el.closest('section') || el.parentElement;
    section.addEventListener('mousemove', (e) => {
        const r = section.getBoundingClientRect();
        el.style.setProperty('--mx', ((e.clientX - r.left) / r.width) * 100 + '%');
        el.style.setProperty('--my', ((e.clientY - r.top) / r.height) * 100 + '%');
    });
}

/* Lightweight particle constellation in the hero background */
function initConstellation() {
    const canvas = document.getElementById('constellation');
    if (!canvas || reduceMotion) return;
    const ctx = canvas.getContext('2d');
    const host = canvas.parentElement;
    let w, h, points, raf;

    const COUNT = () => Math.min(70, Math.floor(window.innerWidth / 22));

    function resize() {
        w = canvas.width = host.offsetWidth;
        h = canvas.height = host.offsetHeight;
        points = Array.from({ length: COUNT() }, () => ({
            x: Math.random() * w,
            y: Math.random() * h,
            vx: (Math.random() - 0.5) * 0.4,
            vy: (Math.random() - 0.5) * 0.4,
        }));
    }

    function draw() {
        ctx.clearRect(0, 0, w, h);
        for (const p of points) {
            p.x += p.vx; p.y += p.vy;
            if (p.x < 0 || p.x > w) p.vx *= -1;
            if (p.y < 0 || p.y > h) p.vy *= -1;
        }
        for (let i = 0; i < points.length; i++) {
            const a = points[i];
            ctx.fillStyle = 'rgba(150,180,255,0.6)';
            ctx.beginPath();
            ctx.arc(a.x, a.y, 1.4, 0, Math.PI * 2);
            ctx.fill();
            for (let j = i + 1; j < points.length; j++) {
                const b = points[j];
                const d = Math.hypot(a.x - b.x, a.y - b.y);
                if (d < 120) {
                    ctx.strokeStyle = `rgba(130,150,255,${0.14 * (1 - d / 120)})`;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.stroke();
                }
            }
        }
        raf = requestAnimationFrame(draw);
    }

    // Pause when the hero scrolls out of view to save battery.
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) { draw(); }
            else { cancelAnimationFrame(raf); }
        });
    });

    resize();
    window.addEventListener('resize', resize);
    io.observe(canvas);
}

/* Cycle the highlighted word in the hero headline */
function initRotatingWord() {
    const el = document.querySelector('[data-rotate]');
    if (!el) return;
    let words;
    try { words = JSON.parse(el.dataset.rotate); } catch { return; }
    if (!Array.isArray(words) || words.length < 2 || reduceMotion) return;
    let i = 0;
    setInterval(() => {
        i = (i + 1) % words.length;
        el.classList.add('swap');
        setTimeout(() => {
            el.textContent = words[i];
            el.classList.remove('swap');
        }, 350);
    }, 2600);
}

/* Buttons that gently lean toward the cursor */
function initMagnetic() {
    if (reduceMotion) return;
    document.querySelectorAll('[data-magnetic]').forEach((el) => {
        el.addEventListener('mousemove', (e) => {
            const r = el.getBoundingClientRect();
            const x = e.clientX - r.left - r.width / 2;
            const y = e.clientY - r.top - r.height / 2;
            el.style.transform = `translate(${x * 0.25}px, ${y * 0.35}px)`;
        });
        el.addEventListener('mouseleave', () => { el.style.transform = ''; });
    });
}

/* Real live crypto prices from Binance's public API (free, no key, accurate).
   Price elements: [data-live="BTCUSDT"]  ·  change elements: [data-live-change="BTCUSDT"] */
function initLivePrices() {
    const priceEls = [...document.querySelectorAll('[data-live]')];
    const changeEls = [...document.querySelectorAll('[data-live-change]')];
    if (!priceEls.length && !changeEls.length) return;

    const symbols = [...new Set([
        ...priceEls.map((e) => e.dataset.live),
        ...changeEls.map((e) => e.dataset.liveChange),
    ])];
    if (!symbols.length) return;

    const fmtPrice = (n) => {
        const decimals = n >= 1 ? 2 : 5;
        return n.toLocaleString(undefined, { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
    };

    async function refresh() {
        try {
            const url = 'https://api.binance.com/api/v3/ticker/24hr?symbols=' + encodeURIComponent(JSON.stringify(symbols));
            const res = await fetch(url);
            if (!res.ok) return;
            const rows = await res.json();
            const map = Object.fromEntries(rows.map((r) => [r.symbol, r]));

            priceEls.forEach((el) => {
                const d = map[el.dataset.live];
                if (!d) return;
                const price = parseFloat(d.lastPrice);
                const prev = parseFloat(el.dataset.prev || price);
                el.textContent = (el.dataset.livePrefix || '$') + fmtPrice(price);
                el.dataset.prev = price;
                el.classList.remove('text-emerald', 'text-rose-400');
                if (price !== prev) {
                    el.classList.add(price >= prev ? 'text-emerald' : 'text-rose-400');
                    setTimeout(() => el.classList.remove('text-emerald', 'text-rose-400'), 600);
                }
            });

            changeEls.forEach((el) => {
                const d = map[el.dataset.liveChange];
                if (!d) return;
                const pct = parseFloat(d.priceChangePercent);
                el.textContent = (pct >= 0 ? '+' : '') + pct.toFixed(2) + '%' + (el.dataset.liveSuffix || '');
                el.classList.toggle('text-emerald', pct >= 0);
                el.classList.toggle('text-rose-400', pct < 0);
            });
        } catch (e) {
            /* network/API hiccup — keep last known values */
        }
    }

    refresh();
    setInterval(refresh, 15000);
}

/* Expand/collapse FAQ items */
function initFaq() {
    document.querySelectorAll('[data-faq]').forEach((item) => {
        const toggle = item.querySelector('[data-faq-toggle]');
        if (!toggle) return;
        toggle.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('[data-faq].open').forEach((o) => o.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });
}

/* Add a solid background to the navbar once the user scrolls */
function initNavScrollState() {
    const nav = document.querySelector('[data-nav]');
    if (!nav) return;
    const onScroll = () => {
        nav.classList.toggle('is-scrolled', window.scrollY > 24);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}
