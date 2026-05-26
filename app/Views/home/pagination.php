<?php
$totalPages = (int) ceil($totalResults / $pageSize);
$totalPages = min($totalPages, 5); // NewsAPI free tier max 5 pages
if ($totalPages <= 1) return;
?>
<nav class="pagination" aria-label="Navigasi halaman">
  <?php if ($currentPage > 1): ?>
    <a href="<?= $baseUrl ?>?page=<?= $currentPage - 1 ?>" class="pagination__btn">← Sebelumnya</a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="<?= $baseUrl ?>?page=<?= $i ?>"
       class="pagination__num <?= $i === $currentPage ? 'active' : '' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>

  <?php if ($currentPage < $totalPages): ?>
    <a href="<?= $baseUrl ?>?page=<?= $currentPage + 1 ?>" class="pagination__btn">Berikutnya →</a>
  <?php endif; ?>
</nav>
