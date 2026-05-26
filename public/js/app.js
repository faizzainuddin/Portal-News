/* ── DARK MODE TOGGLE ────────────────────────────────────────────────────── */
const html        = document.documentElement;
const themeToggle = document.getElementById('themeToggle');
const themeIcon   = themeToggle?.querySelector('.theme-icon');

const savedTheme = localStorage.getItem('theme') || 'dark';
html.setAttribute('data-theme', savedTheme);
if (themeIcon) themeIcon.textContent = savedTheme === 'dark' ? '☀' : '☾';

themeToggle?.addEventListener('click', () => {
  const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('theme', next);
  if (themeIcon) themeIcon.textContent = next === 'dark' ? '☀' : '☾';
});

/* ── LAZY IMAGE FALLBACK ─────────────────────────────────────────────────── */
document.querySelectorAll('img').forEach(img => {
  img.addEventListener('error', function () {
    this.closest('.news-card__img-wrap, .hero-card')?.classList.add('img-error');
    this.style.display = 'none';
  });
});

/* ── SEARCH EXPAND ON MOBILE ─────────────────────────────────────────────── */
const searchInput = document.querySelector('.search-input');
if (searchInput) {
  searchInput.addEventListener('focus', () => searchInput.style.width = '220px');
  searchInput.addEventListener('blur', () => searchInput.style.width = '');
}
