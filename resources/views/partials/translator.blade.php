{{-- ============ LANGUAGE TRANSLATOR (floating widget, custom UI) ============ --}}
@php
    $languages = [
        ['en', 'English', '🇬🇧'], ['es', 'Español', '🇪🇸'], ['fr', 'Français', '🇫🇷'],
        ['de', 'Deutsch', '🇩🇪'], ['pt', 'Português', '🇵🇹'], ['ar', 'العربية', '🇸🇦'],
        ['zh-CN', '中文', '🇨🇳'], ['hi', 'हिन्दी', '🇮🇳'], ['ru', 'Русский', '🇷🇺'],
        ['ja', '日本語', '🇯🇵'], ['it', 'Italiano', '🇮🇹'], ['tr', 'Türkçe', '🇹🇷'],
    ];
@endphp
<div class="fixed bottom-5 left-5 z-[60]" data-lang translate="no">
    {{-- Dropdown (opens upward) --}}
    <div data-lang-menu class="mb-2 hidden max-h-72 w-52 overflow-y-auto rounded-2xl border border-black/5 bg-white p-1.5 shadow-2xl shadow-black/30">
        @foreach ($languages as [$code, $name, $flag])
            <button type="button" data-lang-option="{{ $code }}" data-lang-flag="{{ $flag }}" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                <span class="text-lg leading-none">{{ $flag }}</span>
                <span>{{ $name }}</span>
            </button>
        @endforeach
    </div>

    {{-- Pill trigger --}}
    <button data-lang-toggle class="flex items-center gap-2 rounded-full bg-white px-4 py-2.5 shadow-2xl shadow-black/30 ring-1 ring-black/5 transition hover:shadow-black/40" aria-haspopup="true" aria-expanded="false">
        <span data-lang-flag class="text-xl leading-none">🇬🇧</span>
        <span data-lang-label class="text-base font-bold tracking-wide text-gray-800">EN</span>
        <svg data-lang-caret class="h-4 w-4 text-gray-500 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m18 15-6-6-6 6"/></svg>
    </button>
</div>

<div id="google_translate_element" class="sr-only" aria-hidden="true"></div>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,es,fr,de,pt,ar,zh-CN,hi,ru,ja,it,tr',
            autoDisplay: false,
        }, 'google_translate_element');
    }

    (function () {
        const labels = { en: 'EN', es: 'ES', fr: 'FR', de: 'DE', pt: 'PT', ar: 'AR', 'zh-CN': '中文', hi: 'HI', ru: 'RU', ja: 'JA', it: 'IT', tr: 'TR' };
        const flags = { en: '🇬🇧', es: '🇪🇸', fr: '🇫🇷', de: '🇩🇪', pt: '🇵🇹', ar: '🇸🇦', 'zh-CN': '🇨🇳', hi: '🇮🇳', ru: '🇷🇺', ja: '🇯🇵', it: '🇮🇹', tr: '🇹🇷' };

        function paintTrigger(lang) {
            document.querySelectorAll('[data-lang-label]').forEach((el) => (el.textContent = labels[lang] || lang.toUpperCase()));
            document.querySelectorAll('[data-lang-toggle] [data-lang-flag]').forEach((el) => (el.textContent = flags[lang] || '🌐'));
        }

        function setCookie(value) {
            const host = location.hostname;
            document.cookie = 'googtrans=' + value + ';path=/';
            document.cookie = 'googtrans=' + value + ';path=/;domain=.' + host;
        }

        // Drive Google's hidden <select> to translate without a banner.
        function translateTo(lang, attempt = 0) {
            const combo = document.querySelector('.goog-te-combo');
            if (!combo) {
                if (attempt < 40) { return setTimeout(() => translateTo(lang, attempt + 1), 150); }
                return;
            }
            combo.value = lang;
            combo.dispatchEvent(new Event('change'));
        }

        function selectLanguage(lang) {
            paintTrigger(lang);
            if (lang === 'en') {
                // Clear translation back to the original and reload.
                setCookie('/en/en');
                localStorage.removeItem('wamo_lang');
                location.reload();
                return;
            }
            setCookie('/en/' + lang);
            translateTo(lang);
            localStorage.setItem('wamo_lang', lang);
        }

        function bindMenus() {
            // Toggle open/close for any language dropdown (desktop + mobile share the logic).
            document.querySelectorAll('[data-lang]').forEach((wrap) => {
                const toggle = wrap.querySelector('[data-lang-toggle]');
                const menu = wrap.querySelector('[data-lang-menu]');
                const caret = wrap.querySelector('[data-lang-caret]');
                if (!toggle || !menu) return;
                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                    const open = !menu.classList.contains('hidden');
                    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                    if (caret) { caret.classList.toggle('rotate-180', open); }
                });
                menu.querySelectorAll('[data-lang-option]').forEach((opt) => {
                    opt.addEventListener('click', () => {
                        selectLanguage(opt.dataset.langOption);
                        menu.classList.add('hidden');
                    });
                });
            });
            document.addEventListener('click', () => {
                document.querySelectorAll('[data-lang-menu]').forEach((m) => m.classList.add('hidden'));
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            bindMenus();
            const saved = localStorage.getItem('wamo_lang');
            if (saved && saved !== 'en') {
                paintTrigger(saved);
                translateTo(saved);
            }
        });
    })();
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>
