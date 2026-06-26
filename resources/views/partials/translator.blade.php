{{-- ============ LANGUAGE TRANSLATOR (every supported language, searchable) ============ --}}
@php
    // English-name fallback list (also used for English-language search of native names).
    $languages = [
        ['af', 'Afrikaans'], ['sq', 'Albanian'], ['am', 'Amharic'], ['ar', 'Arabic'], ['hy', 'Armenian'],
        ['as', 'Assamese'], ['ay', 'Aymara'], ['az', 'Azerbaijani'], ['bm', 'Bambara'], ['eu', 'Basque'],
        ['be', 'Belarusian'], ['bn', 'Bengali'], ['bho', 'Bhojpuri'], ['bs', 'Bosnian'], ['bg', 'Bulgarian'],
        ['ca', 'Catalan'], ['ceb', 'Cebuano'], ['ny', 'Chichewa'], ['zh-CN', 'Chinese (Simplified)'], ['zh-TW', 'Chinese (Traditional)'],
        ['co', 'Corsican'], ['hr', 'Croatian'], ['cs', 'Czech'], ['da', 'Danish'], ['dv', 'Dhivehi'],
        ['doi', 'Dogri'], ['nl', 'Dutch'], ['en', 'English'], ['eo', 'Esperanto'], ['et', 'Estonian'],
        ['ee', 'Ewe'], ['tl', 'Filipino'], ['fi', 'Finnish'], ['fr', 'French'], ['fy', 'Frisian'],
        ['gl', 'Galician'], ['ka', 'Georgian'], ['de', 'German'], ['el', 'Greek'], ['gn', 'Guarani'],
        ['gu', 'Gujarati'], ['ht', 'Haitian Creole'], ['ha', 'Hausa'], ['haw', 'Hawaiian'], ['iw', 'Hebrew'],
        ['hi', 'Hindi'], ['hmn', 'Hmong'], ['hu', 'Hungarian'], ['is', 'Icelandic'], ['ig', 'Igbo'],
        ['ilo', 'Ilocano'], ['id', 'Indonesian'], ['ga', 'Irish'], ['it', 'Italian'], ['ja', 'Japanese'],
        ['jw', 'Javanese'], ['kn', 'Kannada'], ['kk', 'Kazakh'], ['km', 'Khmer'], ['rw', 'Kinyarwanda'],
        ['gom', 'Konkani'], ['ko', 'Korean'], ['kri', 'Krio'], ['ku', 'Kurdish (Kurmanji)'], ['ckb', 'Kurdish (Sorani)'],
        ['ky', 'Kyrgyz'], ['lo', 'Lao'], ['la', 'Latin'], ['lv', 'Latvian'], ['ln', 'Lingala'],
        ['lt', 'Lithuanian'], ['lg', 'Luganda'], ['lb', 'Luxembourgish'], ['mk', 'Macedonian'], ['mai', 'Maithili'],
        ['mg', 'Malagasy'], ['ms', 'Malay'], ['ml', 'Malayalam'], ['mt', 'Maltese'], ['mi', 'Maori'],
        ['mr', 'Marathi'], ['mni-Mtei', 'Meiteilon (Manipuri)'], ['lus', 'Mizo'], ['mn', 'Mongolian'], ['my', 'Myanmar (Burmese)'],
        ['ne', 'Nepali'], ['no', 'Norwegian'], ['or', 'Odia (Oriya)'], ['om', 'Oromo'], ['ps', 'Pashto'],
        ['fa', 'Persian'], ['pl', 'Polish'], ['pt', 'Portuguese'], ['pa', 'Punjabi'], ['qu', 'Quechua'],
        ['ro', 'Romanian'], ['ru', 'Russian'], ['sm', 'Samoan'], ['sa', 'Sanskrit'], ['gd', 'Scots Gaelic'],
        ['nso', 'Sepedi'], ['sr', 'Serbian'], ['st', 'Sesotho'], ['sn', 'Shona'], ['sd', 'Sindhi'],
        ['si', 'Sinhala'], ['sk', 'Slovak'], ['sl', 'Slovenian'], ['so', 'Somali'], ['es', 'Spanish'],
        ['su', 'Sundanese'], ['sw', 'Swahili'], ['sv', 'Swedish'], ['tg', 'Tajik'], ['ta', 'Tamil'],
        ['tt', 'Tatar'], ['te', 'Telugu'], ['th', 'Thai'], ['ti', 'Tigrinya'], ['ts', 'Tsonga'],
        ['tr', 'Turkish'], ['tk', 'Turkmen'], ['ak', 'Twi'], ['uk', 'Ukrainian'], ['ur', 'Urdu'],
        ['ug', 'Uyghur'], ['uz', 'Uzbek'], ['vi', 'Vietnamese'], ['cy', 'Welsh'], ['xh', 'Xhosa'],
        ['yi', 'Yiddish'], ['yo', 'Yoruba'], ['zu', 'Zulu'],
    ];
@endphp
<div class="fixed bottom-5 left-5 z-[60]" data-lang translate="no">
    {{-- Dropdown (opens upward) --}}
    <div data-lang-menu class="mb-2 hidden w-64 rounded-2xl border border-black/5 bg-white p-2 shadow-2xl shadow-black/30">
        <div class="relative">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3-3"/></svg>
            <input type="text" data-lang-search placeholder="Search any language…" class="w-full rounded-xl bg-gray-100 py-2 pl-9 pr-3 text-sm text-gray-800 outline-none focus:ring-2 focus:ring-brand/40">
        </div>
        <div data-lang-list class="mt-2 max-h-72 overflow-y-auto">
            @foreach ($languages as [$code, $name])
                <button type="button" data-lang-option="{{ $code }}" data-lang-name="{{ $name }}" data-search="{{ strtolower($name.' '.$code) }}" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                    {{ $name }}
                </button>
            @endforeach
        </div>
        <p data-lang-empty class="hidden px-3 py-4 text-center text-sm text-gray-400">No language found</p>
    </div>

    {{-- Pill trigger --}}
    <button data-lang-toggle class="flex items-center gap-2 rounded-full bg-white px-4 py-2.5 shadow-2xl shadow-black/30 ring-1 ring-black/5 transition hover:shadow-black/40" aria-haspopup="true" aria-expanded="false">
        <svg class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M3 12h18M12 3c2.5 2.5 2.5 16.5 0 18M12 3c-2.5 2.5-2.5 16.5 0 18"/></svg>
        <span data-lang-label class="text-sm font-bold tracking-wide text-gray-800">English</span>
        <svg data-lang-caret class="h-4 w-4 text-gray-500 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="m18 15-6-6-6 6"/></svg>
    </button>
</div>

<div id="google_translate_element" class="sr-only" aria-hidden="true"></div>

<script type="text/javascript">
    function googleTranslateElementInit() {
        // No includedLanguages → every language Google Translate offers is available.
        new google.translate.TranslateElement({ pageLanguage: 'en', autoDisplay: false }, 'google_translate_element');
    }

    (function () {
        const EN_NAMES = @json(collect($languages)->pluck(1, 0));
        const menu = document.querySelector('[data-lang-menu]');
        const list = document.querySelector('[data-lang-list]');
        const empty = document.querySelector('[data-lang-empty]');
        const search = document.querySelector('[data-lang-search]');
        const toggle = document.querySelector('[data-lang-toggle]');
        const caret = document.querySelector('[data-lang-caret]');
        if (!menu) return;

        function setCookie(value) {
            const host = location.hostname;
            document.cookie = 'googtrans=' + value + ';path=/';
            document.cookie = 'googtrans=' + value + ';path=/;domain=.' + host;
        }
        function paintLabel(name) {
            document.querySelectorAll('[data-lang-label]').forEach((el) => (el.textContent = name));
        }
        function translateTo(lang, attempt = 0) {
            const combo = document.querySelector('.goog-te-combo');
            if (!combo) { if (attempt < 80) return setTimeout(() => translateTo(lang, attempt + 1), 150); return; }
            combo.value = lang;
            combo.dispatchEvent(new Event('change'));
        }
        function selectLanguage(code, name) {
            paintLabel(name);
            if (code === 'en') {
                setCookie('/en/en');
                localStorage.removeItem('fintriva_lang');
                localStorage.removeItem('fintriva_lang_name');
                location.reload();
                return;
            }
            setCookie('/en/' + code);
            translateTo(code);
            localStorage.setItem('fintriva_lang', code);
            localStorage.setItem('fintriva_lang_name', name);
        }

        function makeButton(code, native) {
            const en = EN_NAMES[code] || '';
            const b = document.createElement('button');
            b.type = 'button';
            b.dataset.langOption = code;
            b.dataset.langName = native;
            b.dataset.search = (native + ' ' + en + ' ' + code).toLowerCase();
            b.className = 'flex w-full items-center justify-between gap-2 rounded-xl px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-100';
            b.innerHTML = '<span>' + native + '</span>' + (en && en.toLowerCase() !== native.toLowerCase() ? '<span class="shrink-0 text-xs text-gray-400">' + en + '</span>' : '');
            return b;
        }

        // Replace the fallback list with the complete native-name list straight from Google.
        function syncFromGoogle(attempt = 0) {
            const combo = document.querySelector('.goog-te-combo');
            if (!combo || combo.options.length <= 1) {
                if (attempt < 100) return setTimeout(() => syncFromGoogle(attempt + 1), 200);
                return;
            }
            const frag = document.createDocumentFragment();
            frag.appendChild(makeButton('en', 'English'));
            [...combo.options].forEach((o) => {
                if (!o.value || o.value === 'en') return;
                frag.appendChild(makeButton(o.value, o.text));
            });
            list.innerHTML = '';
            list.appendChild(frag);
            bindOptions();
            if (search.value) filter(search.value);
        }

        function bindOptions() {
            list.querySelectorAll('[data-lang-option]').forEach((opt) => {
                opt.addEventListener('click', () => {
                    selectLanguage(opt.dataset.langOption, opt.dataset.langName);
                    menu.classList.add('hidden');
                });
            });
        }

        function filter(q) {
            q = q.toLowerCase();
            let shown = 0;
            list.querySelectorAll('[data-lang-option]').forEach((b) => {
                const hay = b.dataset.search || (b.dataset.langName + ' ' + b.dataset.langOption).toLowerCase();
                const match = hay.includes(q);
                b.classList.toggle('hidden', !match);
                if (match) shown++;
            });
            empty.classList.toggle('hidden', shown > 0);
        }

        document.addEventListener('DOMContentLoaded', () => {
            bindOptions();
            syncFromGoogle();

            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
                const open = !menu.classList.contains('hidden');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (caret) caret.classList.toggle('rotate-180', open);
                if (open) { search.value = ''; filter(''); setTimeout(() => search.focus(), 50); }
            });
            search.addEventListener('input', () => filter(search.value));
            search.addEventListener('click', (e) => e.stopPropagation());
            menu.addEventListener('click', (e) => e.stopPropagation());
            document.addEventListener('click', () => menu.classList.add('hidden'));

            const saved = localStorage.getItem('fintriva_lang');
            const savedName = localStorage.getItem('fintriva_lang_name');
            if (saved && saved !== 'en') {
                if (savedName) paintLabel(savedName);
                translateTo(saved);
            }
        });
    })();
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>
