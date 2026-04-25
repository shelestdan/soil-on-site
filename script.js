/* ═══════════════════════════════════════════════════════
   Soil On Site — Main Script
   ─ Mobile nav
   ─ Smooth scroll
   ─ Calculator
   ─ FAQ accordion
   ─ Contact form validation + success state
═══════════════════════════════════════════════════════ */

/* ── Mobile nav ──────────────────────────────────────── */
const hamburger = document.getElementById('hamburger');
const mobileNav  = document.getElementById('mobile-nav');

hamburger.addEventListener('click', () => {
  const isOpen = mobileNav.classList.toggle('open');
  hamburger.setAttribute('aria-expanded', String(isOpen));
});

/* Close mobile nav when any link clicked */
mobileNav.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    mobileNav.classList.remove('open');
    hamburger.setAttribute('aria-expanded', 'false');
  });
});

/* ── Smooth scroll (all anchor links) ───────────────── */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', e => {
    const id     = anchor.getAttribute('href');
    const target = document.querySelector(id);
    if (!target) return;
    e.preventDefault();
    const offset = 72; // header height + buffer
    const top    = target.getBoundingClientRect().top + window.scrollY - offset;
    window.scrollTo({ top, behavior: 'smooth' });
  });
});

/* ═══════════════════════════════════════════════════════
   CALCULATOR PRICING CONFIGURATION
   ─────────────────────────────────────────────────────
   Edit these values before launch to confirm final pricing.
   All values are in Australian dollars (AUD).
   The calculator shows an ESTIMATE ONLY — not a fixed quote.
═══════════════════════════════════════════════════════ */
const PRICING = {
  // Base price for a standard residential site ─ UPDATE before launch
  base: 1500,

  // ── LOCATION SURCHARGE ────────────────────────────
  // Add to base based on council area.
  // Sorted roughly by distance from Queanbeyan base.
  location: {
    'queanbeyan-palerang': 0,     // Local — no surcharge
    'yass-valley':          50,   // Close regional
    'goulburn':             75,   // Close regional
    'shoalhaven':           100,  // Moderate travel
    'snowy-monaro':         200,  // Further regional
    'eurobodalla':          200,  // Further regional — coastal
    'bega-valley':          300,  // Extended regional
    'hilltops':             250,  // Western regional
    'wagga-wagga':          500,  // Extended western
    'other':                500,  // Placeholder — assess per enquiry
  },

  // ── PROJECT TYPE SURCHARGE ────────────────────────
  project: {
    'new-dwelling':       0,    // Standard residential scope
    'septic-upgrade':     250,  // Existing system replacement
    'bedroom-extension':  200,  // Load change assessment
    'council-rfi':        300,  // Responding to council RFI
    'subdivision':        500,  // Multiple lots — more complex
  },

  // ── SYSTEM TYPE SURCHARGE ─────────────────────────
  system: {
    'standard-septic':   0,    // Standard scope
    'not-sure':          0,    // Determined on site assessment
    'greywater':         150,  // Greywater system complexity
    'composting':        200,  // Composting system assessment
    'awts':              250,  // Secondary treatment assessment
    'biological-filter': 250,  // Biological filter assessment
  },

  // ── COMPLEXITY SURCHARGE ──────────────────────────
  complexity: {
    'standard':   0,    // Flat, accessible standard site
    'sloping':    300,  // Sloped or constrained — more fieldwork
    'poor-soil':  300,  // High clay / poor drainage — extra testing
    'remote':     400,  // Remote access — additional travel time
  },

  // ── URGENCY SURCHARGE ─────────────────────────────
  urgency: {
    'standard': 0,    // Standard 10–15 business day turnaround
    'priority': 300,  // Faster turnaround — UPDATE based on capacity
  },

  // ── ESTIMATE BUFFER ───────────────────────────────
  // Added to calculated total to produce the upper range bound.
  // Represents unknowns: access variation, lab results, council specifics.
  buffer: 300,
};

/* Store last calculator selections so form can be pre-filled */
let lastCalcSelections = {};

function updateCalc() {
  const loc  = document.getElementById('calc-location').value;
  const proj = document.getElementById('calc-project').value;
  const sys  = document.getElementById('calc-system').value;
  const comp = document.getElementById('calc-complexity').value;
  const urg  = document.querySelector('input[name="urgency"]:checked')?.value || 'standard';

  lastCalcSelections = { location: loc, project: proj, system: sys, complexity: comp, urgency: urg };

  const rangeEl = document.getElementById('result-range');
  const noteEl  = document.getElementById('result-note');
  const ctaEl   = document.getElementById('calc-cta');

  if (!loc || !proj) {
    rangeEl.textContent = 'Select options above';
    noteEl.textContent  = 'Select your location and project type to see an estimate.';
    ctaEl.style.display = 'none';
    return;
  }

  const total =
    PRICING.base +
    (PRICING.location[loc]    ?? 0) +
    (PRICING.project[proj]    ?? 0) +
    (PRICING.system[sys]      ?? 0) +
    (PRICING.complexity[comp] ?? 0) +
    (PRICING.urgency[urg]     ?? 0);

  // Round both ends to nearest $50 for cleaner presentation
  const low  = Math.round(total / 50) * 50;
  const high = Math.round((total + PRICING.buffer) / 50) * 50;

  rangeEl.textContent = `$${low.toLocaleString('en-AU')} – $${high.toLocaleString('en-AU')}`;
  noteEl.textContent  = 'Estimate only. Final price confirmed in your fixed-fee quote.';
  ctaEl.style.display = 'inline-flex';
}

/* Pre-fill contact form from calculator selections */
function prefillFromCalc() {
  const councilMap = {
    'queanbeyan-palerang': 'Queanbeyan-Palerang',
    'snowy-monaro':        'Snowy Monaro',
    'eurobodalla':         'Eurobodalla',
    'bega-valley':         'Bega Valley',
    'shoalhaven':          'Shoalhaven',
    'yass-valley':         'Yass Valley',
    'goulburn':            'Goulburn Mulwaree',
    'hilltops':            'Hilltops',
    'wagga-wagga':         'Wagga Wagga',
    'other':               'Other NSW / ACT',
  };
  const projectMap = {
    'new-dwelling':       'New dwelling',
    'subdivision':        'Subdivision',
    'septic-upgrade':     'Septic upgrade / replacement',
    'bedroom-extension':  'Additional bedroom / extension',
    'council-rfi':        'Council RFI / report update',
  };
  const systemMap = {
    'standard-septic':   'Standard septic tank',
    'awts':              'AWTS / secondary treatment',
    'greywater':         'Greywater system',
    'composting':        'Composting toilet system',
    'biological-filter': 'Biological filter',
    'not-sure':          'Not sure yet',
  };

  const setByText = (selectId, text) => {
    if (!text) return;
    const el = document.getElementById(selectId);
    if (!el) return;
    Array.from(el.options).forEach(opt => {
      if (opt.value === text || opt.text === text) el.value = opt.value;
    });
  };

  setByText('f-council', councilMap[lastCalcSelections.location]);
  setByText('f-project', projectMap[lastCalcSelections.project]);
  setByText('f-system',  systemMap[lastCalcSelections.system]);
}

/* ── FAQ accordion ───────────────────────────────────── */
document.querySelectorAll('.faq-question').forEach(btn => {
  btn.addEventListener('click', () => {
    const isExpanded = btn.getAttribute('aria-expanded') === 'true';

    // Close all open items
    document.querySelectorAll('.faq-question').forEach(b => {
      b.setAttribute('aria-expanded', 'false');
      const panel = document.getElementById(b.getAttribute('aria-controls'));
      if (panel) panel.classList.remove('open');
    });

    // Open the clicked item (if it was closed)
    if (!isExpanded) {
      btn.setAttribute('aria-expanded', 'true');
      const panel = document.getElementById(btn.getAttribute('aria-controls'));
      if (panel) panel.classList.add('open');
    }
  });
});

/* ═══════════════════════════════════════════════════════
   CONTACT FORM — full validation
   ─────────────────────────────────────────────────────
   Architecture:
   • VALIDATORS map: field ID → { test(el), msg(el) }
   • setFieldState(id, 'valid'|'invalid'|'reset', msg?)
     — toggles CSS class, aria-invalid, inline message
   • blur listeners  → validate on leave
   • input listeners → revalidate if already marked invalid (live fix)
   • phone input     → auto-format as user types (AU format)
   • file input      → show selected filename(s)
   • textarea        → character counter
   • submit          → validate all required, scroll to first error, shake btn
═══════════════════════════════════════════════════════ */

/* ── Validators ──────────────────────────────────────── */
/* Australian phone: 10 digits starting with 0 (local) or 11 digits starting with 61 (intl) */
const isAustralianPhone = raw => {
  const d = raw.replace(/\D/g, '');
  if (d.length === 11 && d.startsWith('61')) return true;
  if (d.length === 10 && d.startsWith('0'))  return true;
  return false;
};

/* RFC-5321 inspired email regex — catches 99.9% of real-world invalids */
const isEmail = v =>
  /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,63}$/.test(v.trim()) &&
  !v.includes('..') && v.indexOf('@') > 0;

/* Validation rules — each entry: { test(el) → bool, ok, err } */
const VALIDATORS = {
  'f-name': {
    test: el => {
      const v = el.value.trim();
      return v.length >= 2 && v.length <= 100 && !/[<>{}]/.test(v);
    },
    ok:  'Looks good.',
    err: el => {
      const v = el.value.trim();
      if (!v)          return 'Name is required.';
      if (v.length < 2) return 'Name must be at least 2 characters.';
      if (/[<>{}]/.test(v)) return 'Name contains invalid characters.';
      return 'Please enter your full name.';
    },
  },
  'f-phone': {
    test: el => isAustralianPhone(el.value),
    ok:  'Valid Australian number.',
    err: el => {
      const v = el.value.trim();
      if (!v) return 'Phone number is required.';
      const d = v.replace(/\D/g, '');
      if (d.length < 8) return 'Number is too short.';
      return 'Enter a valid Australian mobile (04xx) or landline number.';
    },
  },
  'f-email': {
    test: el => isEmail(el.value),
    ok:  'Email looks good.',
    err: el => {
      const v = el.value.trim();
      if (!v)               return 'Email address is required.';
      if (!v.includes('@')) return 'Email must contain @.';
      if (!v.includes('.')) return 'Email must contain a domain (e.g. .com.au).';
      return 'Enter a valid email address.';
    },
  },
  'f-address': {
    test: el => {
      const v = el.value.trim();
      return v.length >= 5 && v.length <= 200 && !/[<>{}]/.test(v);
    },
    ok:  'Address noted.',
    err: el => {
      const v = el.value.trim();
      if (!v)           return 'Site address or lot description is required.';
      if (v.length < 5) return 'Please enter a more complete address.';
      return 'Address contains invalid characters.';
    },
  },
  'f-council': {
    test: el => el.value !== '',
    ok:  'Council area selected.',
    err: () => 'Please select your council area.',
  },
  'f-consent': {
    test: el => el.checked,
    ok:  '',
    err: () => 'Please tick the box to confirm and proceed.',
  },
};

/* ── State setter ────────────────────────────────────── */
function setFieldState(id, state, msg) {
  const el  = document.getElementById(id);
  const grp = el?.closest('.form-group');
  const msgEl = document.getElementById(`${id}-msg`);
  if (!el || !grp) return;

  grp.classList.remove('field-valid', 'field-invalid');
  el.removeAttribute('aria-invalid');

  if (state === 'valid') {
    grp.classList.add('field-valid');
    el.setAttribute('aria-invalid', 'false');
    if (msgEl) msgEl.textContent = msg ?? '';
  } else if (state === 'invalid') {
    grp.classList.add('field-invalid');
    el.setAttribute('aria-invalid', 'true');
    if (msgEl) msgEl.textContent = msg ?? 'Please check this field.';
  } else {
    // 'reset' — pristine state
    if (msgEl) msgEl.textContent = '';
  }
}

/* ── Validate single field ───────────────────────────── */
function validateField(id) {
  const rule = VALIDATORS[id];
  const el   = document.getElementById(id);
  if (!rule || !el) return true;

  if (rule.test(el)) {
    setFieldState(id, 'valid', typeof rule.ok === 'function' ? rule.ok(el) : rule.ok);
    return true;
  } else {
    const errMsg = typeof rule.err === 'function' ? rule.err(el) : rule.err;
    setFieldState(id, 'invalid', errMsg);
    return false;
  }
}

/* ── Validate all required fields, return list of failed IDs ── */
function validateAll() {
  return Object.keys(VALIDATORS).filter(id => !validateField(id));
}

/* ── Blur listeners — validate on leave ──────────────── */
Object.keys(VALIDATORS).forEach(id => {
  const el = document.getElementById(id);
  if (!el) return;

  el.addEventListener('blur', () => {
    /* Don't mark pristine-empty optional fields on blur — only required */
    const v = el.type === 'checkbox' ? el.checked : el.value;
    const isEmpty = el.type === 'checkbox' ? !el.checked : !String(v).trim();
    if (isEmpty && !el.required) return; // skip optional untouched
    validateField(id);
  });

  /* Live-fix: re-validate while typing if field is already marked invalid */
  const evType = el.type === 'checkbox' ? 'change' : 'input';
  el.addEventListener(evType, () => {
    if (el.closest('.form-group')?.classList.contains('field-invalid')) {
      validateField(id);
    }
  });
});

/* ── Australian phone auto-formatter ─────────────────── */
const phoneInput = document.getElementById('f-phone');
if (phoneInput) {
  phoneInput.addEventListener('input', () => {
    let raw = phoneInput.value.replace(/\D/g, '');

    /* Cap digits: 11 for +61 intl, 10 for local */
    const cap = raw.startsWith('61') ? 11 : 10;
    raw = raw.slice(0, cap);

    let formatted = raw;

    if (raw.startsWith('04') || raw.startsWith('05')) {
      /* Mobile: 04XX XXX XXX */
      const m = raw.match(/^(\d{4})(\d{0,3})(\d{0,3})$/);
      if (m) formatted = [m[1], m[2], m[3]].filter(Boolean).join(' ');
    } else if (raw.startsWith('61')) {
      /* International: +61 X XXXX XXXX */
      const m = raw.match(/^(61)(\d{1})(\d{0,4})(\d{0,4})$/);
      if (m) formatted = '+' + [m[1], m[2], m[3], m[4]].filter(Boolean).join(' ');
    } else if (raw.startsWith('0') && raw.length > 2) {
      /* Landline: 0X XXXX XXXX */
      const m = raw.match(/^(\d{2})(\d{0,4})(\d{0,4})$/);
      if (m) formatted = [m[1], m[2], m[3]].filter(Boolean).join(' ');
    }

    /* Only update if changed (avoids cursor-jump on non-digit keys) */
    if (phoneInput.value !== formatted) {
      const pos = phoneInput.selectionStart;
      phoneInput.value = formatted;
      /* Restore cursor: if adding, move to end; if deleting, preserve position */
      try { phoneInput.setSelectionRange(pos, pos); } catch(_) {}
    }
  });
}

/* ── Email: lowercase on blur ────────────────────────── */
const emailInput = document.getElementById('f-email');
if (emailInput) {
  emailInput.addEventListener('blur', () => {
    emailInput.value = emailInput.value.trim().toLowerCase();
  });
}

/* ── Textarea character counter ──────────────────────── */
const msgTextarea = document.getElementById('f-message');
const charCountEl = document.getElementById('f-message-count');
const MSG_MAX     = 2000;
if (msgTextarea && charCountEl) {
  const updateCount = () => {
    const len  = msgTextarea.value.length;
    const left = MSG_MAX - len;
    charCountEl.textContent = `${len} / ${MSG_MAX}`;
    charCountEl.classList.toggle('warn', left < 200);
  };
  msgTextarea.addEventListener('input', updateCount);
}

/* ── File input: show selected filenames ─────────────── */
const fileInput   = document.getElementById('f-files');
const fileLabelEl = document.getElementById('file-label-text');
if (fileInput && fileLabelEl) {
  fileInput.addEventListener('change', () => {
    const files = Array.from(fileInput.files);
    if (!files.length) {
      fileLabelEl.textContent = 'Upload site plans, surveys, or existing reports';
      return;
    }
    const names = files.map(f => f.name).join(', ');
    const total = (files.reduce((s, f) => s + f.size, 0) / 1024 / 1024).toFixed(1);
    fileLabelEl.textContent = `${files.length} file${files.length > 1 ? 's' : ''} selected (${total} MB): ${names}`;
  });
}

/* ── Form submit ─────────────────────────────────────── */
const quoteForm    = document.getElementById('quote-form');
const formSuccessEl = document.getElementById('form-success');
const submitBtn    = document.getElementById('form-submit-btn');

quoteForm.addEventListener('submit', e => {
  e.preventDefault();

  const failed = validateAll();

  if (failed.length) {
    /* Shake submit button */
    submitBtn.classList.remove('shake');
    void submitBtn.offsetWidth; // reflow to restart animation
    submitBtn.classList.add('shake');
    submitBtn.addEventListener('animationend', () => submitBtn.classList.remove('shake'), { once: true });

    /* Scroll to first invalid field */
    const firstEl = document.getElementById(failed[0]);
    if (firstEl) {
      const top = firstEl.getBoundingClientRect().top + window.scrollY - 90;
      window.scrollTo({ top, behavior: 'smooth' });
      setTimeout(() => firstEl.focus(), 400);
    }
    return;
  }

  /* All valid — show loading state */
  submitBtn.classList.add('loading');
  submitBtn.disabled = true;

  /*
   * ── BACKEND INTEGRATION ──────────────────────────────
   * Replace the setTimeout block below with a real fetch.
   *
   * Option A — Formspree (recommended, free tier):
   *   const data = new FormData(quoteForm);
   *   fetch('https://formspree.io/f/YOUR_FORM_ID', {
   *     method: 'POST', body: data,
   *     headers: { Accept: 'application/json' }
   *   })
   *   .then(r => r.ok ? showSuccess() : showNetworkError())
   *   .catch(() => showNetworkError());
   *
   * Option B — Netlify Forms:
   *   Add  data-netlify="true"  name="quote"  to <form>.
   *   Netlify intercepts the POST automatically.
   *
   * Option C — EmailJS (emailjs.com, free tier, no backend required).
   * ────────────────────────────────────────────────────
   */
  setTimeout(showSuccess, 800); // remove when wired to real backend
});

function showSuccess() {
  quoteForm.style.display = 'none';
  formSuccessEl.classList.add('visible');
  formSuccessEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
  formSuccessEl.querySelector('h3')?.focus();
}
