<?php

namespace App\Controllers;

use App\Models\NewsModel;

class NewsController extends BaseController
{
    protected NewsModel $news;

    public function __construct()
    {
        $this->news = new NewsModel();
    }

    // ─── Halaman kategori ─────────────────────────────────────────────────────
    public function kategori(string $slug): string
    {
        $config    = config('NewsApi');
        $page      = (int) ($this->request->getGet('page') ?? 1);

        if (!array_key_exists($slug, $config->categories)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data     = $this->news->getByCategory($slug, $page);
        $articles = $data['articles'] ?? [];

        return view('layouts/main', [
            'title'        => ucfirst($slug) . ' — Portal Berita',
            'activePage'   => $slug,
            'heroArticles' => array_slice($articles, 0, 2),
            'restArticles' => array_slice($articles, 2),
            'totalResults' => $data['totalResults'] ?? 0,
            'currentPage'  => $page,
            'kategori'     => $slug,
            'newsModel'    => $this->news,
        ]);
    }

    // ─── Halaman pencarian ────────────────────────────────────────────────────
    public function cari(): string
    {
        $query    = trim($this->request->getGet('q') ?? '');
        $page     = (int) ($this->request->getGet('page') ?? 1);
        $articles = [];
        $total    = 0;

        if ($query !== '') {
            $data     = $this->news->search($query, $page);
            $articles = $data['articles'] ?? [];
            $total    = $data['totalResults'] ?? 0;
        }

        return view('layouts/main', [
            'title'        => $query ? "Hasil: \"$query\" — Portal Berita" : 'Cari Berita',
            'activePage'   => 'cari',
            'heroArticles' => [],
            'restArticles' => $articles,
            'totalResults' => $total,
            'currentPage'  => $page,
            'searchQuery'  => $query,
            'newsModel'    => $this->news,
        ]);
    }

    // ─── Halaman detail artikel ───────────────────────────────────────────────
    public function detail(string $slug): string
    {
        $article = $this->news->getArticleBySlug($slug);

        if ($article === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('layouts/main', [
            'title'      => ($article['title'] ?? 'Detail Berita') . ' — Portal Berita',
            'activePage' => '',
            'article'    => $article,
            'newsModel'  => $this->news,
            'isDetail'   => true,
        ]);
    }
}
