// ui.js — behaviour for the language select (the only interactive chrome).
(function () {
  const btn = document.getElementById('lang_btn');
  const menu = document.getElementById('lang_menu');
  if (!btn || !menu) return;

  const label = document.getElementById('lang_current');
  const options = Array.from(menu.querySelectorAll('[data-lang]'));

  function open() {
    menu.hidden = false;
    btn.setAttribute('aria-expanded', 'true');
    (menu.querySelector('[aria-checked="true"]') || options[0]).focus();
  }

  function close(returnFocus) {
    menu.hidden = true;
    btn.setAttribute('aria-expanded', 'false');
    if (returnFocus) btn.focus();
  }

  function sync() {
    const lang = getLanguage();
    label.textContent = LANGS[lang].label;
    options.forEach((o) => o.setAttribute('aria-checked', String(o.dataset.lang === lang)));
  }

  btn.addEventListener('click', () => (menu.hidden ? open() : close(false)));

  menu.addEventListener('click', (e) => {
    const option = e.target.closest('[data-lang]');
    if (!option) return;
    setLanguage(option.dataset.lang);
    close(true);
  });

  document.addEventListener('click', (e) => {
    if (!menu.hidden && !e.target.closest('.lang_switch')) close(false);
  });

  document.addEventListener('keydown', (e) => {
    if (menu.hidden) return;
    if (e.key === 'Escape') {
      close(true);
    } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
      e.preventDefault();
      const i = options.indexOf(document.activeElement);
      const next = e.key === 'ArrowDown' ? (i + 1) % options.length : (i - 1 + options.length) % options.length;
      options[next].focus();
    }
  });

  document.addEventListener('asto:languagechange', sync);
  sync();
})();
