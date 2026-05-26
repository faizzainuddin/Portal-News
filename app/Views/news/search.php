<?php
/** @var string $searchQuery  */
/** @var array  $restArticles */
/** @var int    $totalResults */
/** @var int    $currentPage  */
/** @var \App\Models\NewsModel $newsModel */

if (!function_exists('formatDate')) {
  function formatDate(string $iso): string {
    if (!$iso) return '';
    try { $dt = new DateTime($iso); $dt->setTimezone(new DateTimeZone('Asia/Jakarta')); return $dt->format('d M Y, H:i') . ' WIB'; }
    catch (Exception $e) { return $iso; }
  }
}
?>

<div class="page-header">
  <?php if (!empty($searchQuery)): ?>
    <p class="page-header__eyebrow">Hasil pencarian</p>
    <h1 class="page-header__title">"<?= esc($searchQuery) ?>"</h1>
    <p class="page-header__meta"><?= number_format($totalResults) ?> artikel ditemukan</p>
  <?php else: ?>
    <h1 class="page-header__title">Cari Berita</h1>
  <?php endif; ?>
</div>

<?php if (empty($restArticles) && !empty($searchQuery)): ?>
  <div class="empty-state">
    <div class="empty-state__icon">◎</div>
    <p>Tidak ada berita untuk kata kunci <strong>"<?= esc($searchQuery) ?>"</strong></p>
    <a href="/" class="btn-primary">Kembali ke Utama</a>
  </div>
<?php elseif (!empty($restArticles)): ?>
  <section class="news-grid">
    <?php foreach ($restArticles as $art): ?>
      <?php if (empty($art['title']) || $art['title'] === '[Removed]') continue; ?>
      <article class="news-card">
        <a href="/berita/<?= esc($newsModel->makeSlug($art['title'])) ?>" class="news-card__link">
          <?php if (!empty($art['urlToImage'])): ?>
            <div class="news-card__img-wrap">
              <img src="<?= esc($art['urlToImage']) ?>" alt="<?= esc($art['title']) ?>" class="news-card__img" loading="lazy">
            </div>
          <?php else: ?>
            <div class="news-card__img-wrap news-card__img-wrap--empty"><span>▣</span></div>
          <?php endif; ?>
          <div class="news-card__body">
            <span class="tag tag--sm"><?= esc($art['source']['name'] ?? '') ?></span>
            <h3 class="news-card__title"><?= esc($art['title']) ?></h3>
            <time class="meta-time meta-time--sm"><?= formatDate($art['publishedAt'] ?? '') ?></time>
          </div>
        </a>
      </article>
    <?php endforeach; ?>
  </section>

  <?= view('home/pagination', [
    'currentPage'  => $currentPage,
    'totalResults' => $totalResults,
    'pageSize'     => config('NewsApi')->pageSize,
    'baseUrl'      => '/cari?q=' . urlencode($searchQuery) . '&',
  ]) ?>
<?php endif; ?>
