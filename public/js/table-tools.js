// table-tools.js — sort, search and filter for any table inside [data-table-tools].
//
// Sort    : <th data-type="text|number|date|bool"> with a [data-sort] button (partials/th.blade.php).
//           Cell values come from the first [data-value] inside the cell, else the cell text.
// Search  : <input data-search> matches the text of every cell in the row.
// Filter  : <select data-filter="key"> compares with the row's data-<key> attribute.
//           A select with data-lock="value" is fixed: it cannot be changed and is always applied.
// This works on the rows the page already contains. Enforce permissions on the server too.
(function () {
  document.querySelectorAll('[data-table-tools]').forEach(init);

  function init(root) {
    const table = root.querySelector('table');
    if (!table || !table.tBodies[0]) return;

    const tbody = table.tBodies[0];
    const headers = Array.from(table.tHead.rows[0].cells);
    const rows = Array.from(tbody.rows).filter((r) => !r.classList.contains('empty_row'));
    const search = root.querySelector('[data-search]');
    const fields = Array.from(root.querySelectorAll('[data-filter]'));
    const toggle = root.querySelector('[data-filter-toggle]');
    const panel = root.querySelector('[data-filter-panel]');
    const badge = root.querySelector('[data-filter-count]');
    const clearBtn = root.querySelector('[data-filter-clear]');

    const note = document.createElement('p');
    note.className = 'empty_note';
    note.setAttribute('role', 'status');
    note.hidden = true;
    table.parentElement.after(note);

    let sort = { col: -1, dir: 'asc' };
    let collator = makeCollator();

    function makeCollator() {
      return new Intl.Collator(document.documentElement.lang || 'en', { numeric: true, sensitivity: 'base' });
    }

    const norm = (s) => String(s).toLocaleLowerCase().replace(/\s+/g, ' ').trim();

    // ---------- sort ----------
    function cellValue(row, i, type) {
      const cell = row.cells[i];
      const holder = cell.matches('[data-value]') ? cell : cell.querySelector('[data-value]');
      const raw = (holder ? holder.dataset.value : cell.textContent).trim();
      if (raw === '') return null;
      if (type === 'number' || type === 'bool') {
        const n = parseFloat(raw.replace(/[^\d.-]/g, ''));
        return Number.isNaN(n) ? null : n;
      }
      return raw;
    }

    function sortBy(i) {
      const type = headers[i].dataset.type || 'text';
      const dir = sort.col === i && sort.dir === 'asc' ? 'desc' : 'asc';
      sort = { col: i, dir };

      headers.forEach((h) => { if (h.hasAttribute('aria-sort')) h.setAttribute('aria-sort', 'none'); });
      headers[i].setAttribute('aria-sort', dir === 'asc' ? 'ascending' : 'descending');

      const keyed = rows.map((row) => ({ row, v: cellValue(row, i, type) }));
      keyed.sort((a, b) => {
        if (a.v === null || b.v === null) return a.v === b.v ? 0 : a.v === null ? 1 : -1; // empty values always last
        let c;
        if (type === 'text') c = collator.compare(a.v, b.v);
        else if (type === 'date') c = a.v < b.v ? -1 : a.v > b.v ? 1 : 0; // ISO dates sort as text
        else c = a.v - b.v;
        return dir === 'asc' ? c : -c;
      });
      keyed.forEach(({ row }) => tbody.appendChild(row));
      refresh();
    }

    headers.forEach((th, i) => {
      const btn = th.querySelector('[data-sort]');
      if (btn) btn.addEventListener('click', () => sortBy(i));
    });

    // ---------- filter + search ----------
    function wanted(field) {
      return field.dataset.lock !== undefined ? field.dataset.lock : field.value;
    }

    function matches(row) {
      const q = search ? norm(search.value) : '';
      if (q && !norm(row.textContent).includes(q)) return false;
      return fields.every((f) => {
        const want = wanted(f);
        return want === '' || (row.dataset[f.dataset.filter] ?? '') === want;
      });
    }

    function buildOptions() {
      fields.forEach((f) => {
        if (f.dataset.lock !== undefined) return;
        const current = f.value;
        f.textContent = '';
        const add = (value, label) => f.append(new Option(label, value));
        add('', t('filter_all'));
        if (f.dataset.kind === 'bool') {
          add('1', t('yes'));
          add('0', t('no'));
        } else {
          const key = f.dataset.filter;
          const values = [...new Set(rows.map((r) => r.dataset[key]).filter((v) => v !== undefined && v !== ''))];
          values.sort(collator.compare).forEach((v) => add(v, v));
        }
        f.value = current;
      });
    }

    function refresh() {
      let shown = 0;
      Array.from(tbody.rows).forEach((row) => {
        if (row.classList.contains('empty_row')) return;
        const ok = matches(row);
        row.hidden = !ok;
        row.classList.toggle('zebra', ok && shown % 2 === 1); // zebra stripes only count visible rows
        if (ok) shown += 1;
      });

      const active = fields.filter((f) => f.dataset.lock === undefined && f.value !== '').length;
      if (badge) { badge.textContent = String(active); badge.hidden = active === 0; }
      if (clearBtn) clearBtn.disabled = active === 0;

      const filtered = rows.length > 0 && shown === 0;
      note.hidden = !filtered;
      note.textContent = filtered ? t('no_results') : '';
    }

    if (search) search.addEventListener('input', refresh);
    fields.forEach((f) => f.addEventListener('change', refresh));
    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        fields.forEach((f) => { if (f.dataset.lock === undefined) f.value = ''; });
        refresh();
      });
    }

    // ---------- filter panel open / close ----------
    if (toggle && panel) {
      const open = () => { panel.hidden = false; toggle.setAttribute('aria-expanded', 'true'); };
      const close = (returnFocus) => {
        panel.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
        if (returnFocus) toggle.focus();
      };
      toggle.addEventListener('click', () => (panel.hidden ? open() : close(false)));
      document.addEventListener('click', (e) => {
        if (!panel.hidden && !e.target.closest('.filter_wrap')) close(false);
      });
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !panel.hidden) close(true);
      });
    }

    document.addEventListener('asto:languagechange', () => {
      collator = makeCollator();
      buildOptions();
      refresh();
    });

    buildOptions();
    refresh();
  }
})();
