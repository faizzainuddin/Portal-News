<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Portal Berita') ?></title>
  <meta name="description" content="Portal berita terkini dari seluruh Indonesia">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<!-- ── NAVBAR ─────────────────────────────────────────────────────────────── -->
<header class="navbar">
  <div class="container navbar__inner">

    <a href="/" class="navbar__brand">
      <span class="brand-icon">▣</span>
      <span class="brand-name">KABAR<strong>ID</strong></span>
    </a>

    <nav class="navbar__links">
      <?php
        $config = config('NewsApi');
        $active = $activePage ?? '';
      ?>
      <a href="/" class="nav-link <?= $active === 'home' ? 'active' : '' ?>">Utama</a>
      <?php foreach (array_keys($config->categories) as $kat): ?>
        <a href="/kategori/<?= $kat ?>" class="nav-link <?= $active === $kat ? 'active' : '' ?>">
          <?= ucfirst($kat) ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="navbar__actions">
      <form action="/cari" method="get" class="search-form" id="searchForm">
        <input type="search" name="q" class="search-input"
               placeholder="Cari berita…"
               value="<?= esc($searchQuery ?? '') ?>"
               autocomplete="off">
        <button type="submit" class="search-btn" aria-label="Cari">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
      </form>
      <button class="theme-toggle" id="themeToggle" aria-label="Toggle tema">
        <span class="theme-icon">☀</span>
      </button>
    </div>

  </div>
</header>

<!-- ── KONTEN UTAMA ───────────────────────────────────────────────────────── -->
<main class="main-content container">

  <?php if (!empty($isDetail) && !empty($article)): ?>
    <?= view('news/detail', ['article' => $article, 'newsModel' => $newsModel]) ?>

  <?php elseif (!empty($searchQuery) || $activePage === 'cari'): ?>
    <?= view('news/search', get_defined_vars()) ?>

  <?php else: ?>
    <?= view('home/index', get_defined_vars()) ?>

  <?php endif; ?>

</main>

<!-- ── FOOTER ─────────────────────────────────────────────────────────────── -->
<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__brand">
      <span class="brand-icon">▣</span> <strong>KABARID</strong>
      <p>Berita terkini dari seluruh Indonesia, didukung NewsAPI.</p>
    </div>
    <div class="footer__nav">
      <?php foreach (array_keys($config->categories) as $kat): ?>
        <a href="/kategori/<?= $kat ?>"><?= ucfirst($kat) ?></a>
      <?php endforeach; ?>
    </div>
    <p class="footer__copy">© <?= date('Y') ?> KabarID — Data dari <a href="https://newsapi.org" target="_blank" rel="noopener">NewsAPI.org</a></p>
  </div>
</footer>

<script src="/js/app.js"></script>
</body>
</html>
