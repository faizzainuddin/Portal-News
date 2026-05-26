<?php
/** @var array $heroArticles */
/** @var array $restArticles */
/** @var int   $totalResults */
/** @var int   $currentPage  */
/** @var \App\Models\NewsModel $newsModel */
?>

<!-- ── HERO SECTION ───────────────────────────────────────────────────────── -->
<?php if (!empty($heroArticles)): ?>
<section class="hero-section">

  <?php $main = $heroArticles[0]; ?>
  <article class="hero-main">
    <a href="/berita/<?= esc($newsModel->makeSlug($main['title'])) ?>" class="hero-main__link">
      <?php if (!empty($main['urlToImage'])): ?>
        <div class="hero-main__img-wrap">
          <img src="<?= esc($main['urlToImage']) ?>" alt="<?= esc($main['title']) ?>" class="hero-main__img" loading="eager">
          <div class="hero-main__overlay"></div>
        </div>
      <?php endif; ?>
      <div class="hero-main__body">
        <span class="tag"><?= esc($main['source']['name'] ?? 'Berita') ?></span>
        <h1 class="hero-main__title"><?= esc($main['title']) ?></h1>
        <?php if (!empty($main['description'])): ?>
          <p class="hero-main__desc"><?= esc($main['description']) ?></p>
        <?php endif; ?>
        <time class="meta-time"><?= formatDate($main['publishedAt'] ?? '') ?></time>
      </div>
    </a>
  </article>

  <div class="hero-side">
    <?php foreach (array_slice($heroArticles, 1, 2) as $art): ?>
    <article class="hero-card">
      <a href="/berita/<?= esc($newsModel->makeSlug($art['title'])) ?>" class="hero-card__link">
        <?php if (!empty($art['urlToImage'])): ?>
          <img src="<?= esc($art['urlToImage']) ?>" alt="<?= esc($art['title']) ?>" class="hero-card__img" loading="lazy">
        <?php endif; ?>
        <div class="hero-card__body">
          <span class="tag tag--sm"><?= esc($art['source']['name'] ?? '') ?></span>
          <h2 class="hero-card__title"><?= esc($art['title']) ?></h2>
          <time class="meta-time meta-time--sm"><?= formatDate($art['publishedAt'] ?? '') ?></time>
        </div>
      </a>
    </article>
    <?php endforeach; ?>
  </div>

</section>
<?php endif; ?>

<!-- ── DIVIDER ─────────────────────────────────────────────────────────────── -->
<?php if (!empty($restArticles)): ?>
<div class="section-divider">
  <span>Berita Lainnya</span>
</div>

<!-- ── GRID BERITA ────────────────────────────────────────────────────────── -->
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
          <div class="news-card__img-wrap news-card__img-wrap--empty">
            <span>▣</span>
          </div>
        <?php endif; ?>
        <div class="news-card__body">
          <span class="tag tag--sm"><?= esc($art['source']['name'] ?? '') ?></span>
          <h3 class="news-card__title"><?= esc($art['title']) ?></h3>
          <?php if (!empty($art['description'])): ?>
            <p class="news-card__desc"><?= esc(mb_substr($art['description'], 0, 100)) ?>…</p>
          <?php endif; ?>
          <time class="meta-time meta-time--sm"><?= formatDate($art['publishedAt'] ?? '') ?></time>
        </div>
      </a>
    </article>
  <?php endforeach; ?>
</section>
<?php elseif (empty($heroArticles)): ?>
  <div class="empty-state">
    <div class="empty-state__icon">◎</div>
    <p>Belum ada berita yang diterima dari NewsAPI untuk ditampilkan.</p>
    <a href="/cari?q=Indonesia" class="btn-primary">Coba pencarian Indonesia</a>
  </div>
<?php endif; ?>

<!-- ── PAGINATION ─────────────────────────────────────────────────────────── -->
<?= view('home/pagination', [
  'currentPage'  => $currentPage,
  'totalResults' => $totalResults,
  'pageSize'     => config('NewsApi')->pageSize,
  'baseUrl'      => '/',
]) ?>

<?php
function formatDate(string $iso): string {
  if (!$iso) return '';
  try {
    $dt = new DateTime($iso);
    $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
    return $dt->format('d M Y, H:i') . ' WIB';
  } catch (Exception $e) {
    return $iso;
  }
}
?>
