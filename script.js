/* ═══════════════════════════════════════════════════════
   Soil On Site — Main Script
   ─ Mobile nav
   ─ Smooth scroll
   ─ FAQ accordion
   ─ Contact form validation + spam checks + Netlify submit
═══════════════════════════════════════════════════════ */

/* ── Footer year ─────────────────────────────────────── */
const yearEl = document.getElementById('footer-year');
if (yearEl) yearEl.textContent = new Date().getFullYear();

/* ── Honeypot timestamp (set on page load) ───────────── */
const tsField = document.getElementById('f-ts');
if (tsField) tsField.value = Date.now();

/* ── Mobile nav ──────────────────────────────────────── */
const hamburger = document.getElementById('hamburger');
const mobileNav  = document.getElementById('mobile-nav');

if (hamburger && mobileNav) {
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
}

/* ── Smooth scroll (all anchor links) ───────────────── */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', e => {
    const id     = anchor.getAttribute('href');
    if (!id || id === '#') return;
    const target = document.querySelector(id);
    if (!target) return;
    e.preventDefault();
    const offset = 72; // header height + buffer
    const top    = target.getBoundingClientRect().top + window.scrollY - offset;
    window.scrollTo({ top, behavior: 'smooth' });
  });
});

/* ── FAQ accordion ───────────────────────────────────── */
document.querySelectorAll('.faq-question').forEach(btn => {
  btn.addEventListener('click', () => {
    const isExpanded = btn.getAttribute('aria-expanded') === 'true';

    /* Close all open items */
    document.querySelectorAll('.faq-question').forEach(b => {
      b.setAttribute('aria-expanded', 'false');
      const panel = document.getElementById(b.getAttribute('aria-controls'));
      if (panel) panel.classList.remove('open');
    });

    /* Open the clicked item (if it was closed) */
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
   • submit          → honeypot check, timestamp check,
                       validate all required, scroll to first error
═══════════════════════════════════════════════════════ */

/* ── Validators ──────────────────────────────────────── */
/* Australian phone: 10 digits starting with 0 (local) or 11 starting with 61 (intl) */
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

const MAX_FILE_BYTES = 8 * 1024 * 1024;

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
      if (!v)            return 'Name is required.';
      if (v.length < 2)  return 'Name must be at least 2 characters.';
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
  'f-files': {
    test: el => !el.files.length || el.files[0].size <= MAX_FILE_BYTES,
    ok:  '',
    err: () => 'File must be 8 MB or less. Please email larger files directly.',
  },
  'f-captcha': {
    test: el => el.value.trim() === '7',
    ok:  'Spam check passed.',
    err: el => el.value.trim() ? 'Please check the answer.' : 'Spam check is required.',
  },
};

/* ── State setter ────────────────────────────────────── */
function setFieldState(id, state, msg) {
  const el    = document.getElementById(id);
  const grp   = el?.closest('.form-group');
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
    /* 'reset' — pristine state */
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
    const isEmpty = el.type === 'checkbox' ? !el.checked : !String(el.value).trim();
    if (isEmpty && !el.required) return; /* skip optional untouched */
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
      fileLabelEl.textContent = 'Attach one plan set, survey, or existing report (PDF, DWG, JPG - max 8 MB)';
      setFieldState('f-files', 'reset');
      return;
    }
    const file = files[0];
    const total = (file.size / 1024 / 1024).toFixed(1);
    fileLabelEl.textContent = `${file.name} selected (${total} MB)`;
    validateField('f-files');
  });
}

/* ── Form submit ─────────────────────────────────────── */
const quoteForm     = document.getElementById('quote-form');
const formSuccessEl = document.getElementById('form-success');
const formErrorEl   = document.getElementById('form-error');
const submitBtn     = document.getElementById('form-submit-btn');
const formFieldsEl  = quoteForm?.querySelector('.contact-form-grid');
const formFooterEl  = quoteForm?.querySelector('.form-footer');

if (quoteForm) {
  quoteForm.addEventListener('submit', async e => {
    e.preventDefault();
    if (formErrorEl) formErrorEl.classList.remove('visible');

    /* ── Spam checks ──────────────────────────────────── */

    /* 1. Honeypot: bot filled the hidden field → silently discard */
    const honeypot = document.getElementById('f-website');
    if (honeypot && honeypot.value.trim() !== '') {
      showSuccess(); /* fake success to confuse bots */
      return;
    }

    /* 2. Timestamp: form filled in under 3 seconds → likely bot */
    const tsEl   = document.getElementById('f-ts');
    const loadTs = parseInt(tsEl?.value || '0', 10);
    if (loadTs && (Date.now() - loadTs) < 3000) {
      showSuccess(); /* fake success */
      return;
    }

    /* ── Field validation ─────────────────────────────── */
    const failed = validateAll();

    if (failed.length) {
      /* Shake submit button */
      if (submitBtn) {
        submitBtn.classList.remove('shake');
        void submitBtn.offsetWidth; /* reflow to restart animation */
        submitBtn.classList.add('shake');
        submitBtn.addEventListener('animationend', () => submitBtn.classList.remove('shake'), { once: true });
      }

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
    if (submitBtn) {
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;
    }

    const isLocalPreview = ['localhost', '127.0.0.1', ''].includes(window.location.hostname);
    if (isLocalPreview) {
      setTimeout(showSuccess, 350);
      return;
    }

    try {
      const data = new FormData(quoteForm);
      const res = await fetch('/', { method: 'POST', body: data });
      if (!res.ok) throw new Error(`Form submit failed: ${res.status}`);
      showSuccess();
    } catch (err) {
      showNetworkError();
    }
  });
}

function showSuccess() {
  if (formFieldsEl) formFieldsEl.style.display = 'none';
  if (formFooterEl) formFooterEl.style.display = 'none';
  if (formErrorEl) formErrorEl.classList.remove('visible');
  if (formSuccessEl) {
    formSuccessEl.classList.add('visible');
    formSuccessEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    formSuccessEl.querySelector('h3')?.focus();
  }
}

function showNetworkError() {
  if (submitBtn) {
    submitBtn.classList.remove('loading');
    submitBtn.disabled = false;
  }
  if (formErrorEl) {
    formErrorEl.classList.add('visible');
    formErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
}
