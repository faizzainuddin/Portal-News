<?php
/** @var array $article   */
/** @var \App\Models\NewsModel $newsModel */

if (!function_exists('formatDate')) {
  function formatDate(string $iso): string {
    if (!$iso) return '';
    try { $dt = new DateTime($iso); $dt->setTimezone(new DateTimeZone('Asia/Jakarta')); return $dt->format('d M Y, H:i') . ' WIB'; }
    catch (Exception $e) { return $iso; }
  }
}
?>

<article class="article-detail">

  <!-- Breadcrumb -->
  <nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="/">Utama</a>
    <span>›</span>
    <span><?= esc($article['source']['name'] ?? 'Berita') ?></span>
  </nav>

  <!-- Header -->
  <header class="article-header">
    <span class="tag"><?= esc($article['source']['name'] ?? '') ?></span>
    <h1 class="article-title"><?= esc($article['title']) ?></h1>

    <div class="article-meta">
      <?php if (!empty($article['author'])): ?>
        <span class="article-meta__author">Oleh <?= esc($article['author']) ?></span>
        <span class="article-meta__sep">·</span>
      <?php endif; ?>
      <time class="meta-time"><?= formatDate($article['publishedAt'] ?? '') ?></time>
    </div>
  </header>

  <!-- Gambar utama -->
  <?php if (!empty($article['urlToImage'])): ?>
  <figure class="article-figure">
    <img src="<?= esc($article['urlToImage']) ?>" alt="<?= esc($article['title']) ?>" class="article-img">
  </figure>
  <?php endif; ?>

  <!-- Isi -->
  <div class="article-body">
    <?php if (!empty($article['description'])): ?>
      <p class="article-lead"><?= esc($article['description']) ?></p>
    <?php endif; ?>

    <?php if (!empty($article['content'])): ?>
      <?php
        // Hapus suffix "[+XXXX chars]" dari NewsAPI
        $content = preg_replace('/\[\+\d+ chars\]$/', '', $article['content']);
      ?>
      <p><?= nl2br(esc(trim($content))) ?></p>
    <?php endif; ?>

    <!-- Tautan ke artikel asli -->
    <?php if (!empty($article['url'])): ?>
    <div class="article-source-box">
      <p>Artikel ini diambil dari <strong><?= esc($article['source']['name'] ?? 'sumber') ?></strong>. Untuk membaca artikel lengkap, kunjungi sumber aslinya.</p>
      <a href="<?= esc($article['url']) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary">
        Baca Artikel Lengkap →
      </a>
    </div>
    <?php endif; ?>
  </div>

  <!-- Kembali -->
  <div class="article-back">
    <a href="javascript:history.back()" class="back-link">← Kembali</a>
  </div>

</article>
