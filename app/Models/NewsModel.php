<?php

namespace App\Models;

use Config\NewsApi;

class NewsModel
{
    protected NewsApi $config;
    protected string  $cacheDir;

    public function __construct()
    {
        $this->config   = config('NewsApi');
        $this->cacheDir = WRITEPATH . 'cache/newsapi/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    // ─── Headline utama ────────────────────────────────────────────────────────
    public function getHeadlines(int $page = 1): array
    {
        $params = [
            'country'  => $this->config->country,
            'pageSize' => $this->config->pageSize,
            'page'     => $page,
        ];
        return $this->fetchTopHeadlinesOrFallback($params, 'Indonesia');
    }

    // ─── Berita per kategori ───────────────────────────────────────────────────
    public function getByCategory(string $kategori, int $page = 1): array
    {
        $category = $this->config->categories[$kategori] ?? 'general';
        $fallbackQueries = [
            'umum'      => 'Indonesia',
            'bisnis'    => 'bisnis Indonesia',
            'teknologi' => 'teknologi Indonesia',
            'olahraga'  => 'olahraga Indonesia',
            'hiburan'   => 'hiburan Indonesia',
            'sains'     => 'sains Indonesia',
            'kesehatan' => 'kesehatan Indonesia',
        ];
        $params   = [
            'country'  => $this->config->country,
            'category' => $category,
            'pageSize' => $this->config->pageSize,
            'page'     => $page,
        ];
        return $this->fetchTopHeadlinesOrFallback($params, $fallbackQueries[$kategori] ?? $kategori);
    }

    // ─── Pencarian berita ──────────────────────────────────────────────────────
    public function search(string $query, int $page = 1): array
    {
        $params = [
            'q'          => $query,
            'language'   => $this->config->language,
            'sortBy'     => 'publishedAt',
            'pageSize'   => $this->config->pageSize,
            'page'       => $page,
        ];
        return $this->fetch('everything', $params);
    }

    // ─── Ambil artikel tunggal berdasarkan index cache ─────────────────────────
    public function getArticleBySlug(string $slug): ?array
    {
        // Cari di semua cache yang tersedia
        $files = glob($this->cacheDir . '*.json');
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);
            if (!empty($data['articles'])) {
                foreach ($data['articles'] as $article) {
                    if ($this->makeSlug($article['title']) === $slug) {
                        return $article;
                    }
                }
            }
        }
        return null;
    }

    // ─── Helper: buat slug dari judul ─────────────────────────────────────────
    public function makeSlug(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return substr($slug, 0, 80);
    }

    // ─── HTTP fetch dengan cache 15 menit ─────────────────────────────────────
    protected function fetch(string $endpoint, array $params): array
    {
        $cacheKey  = $this->cacheDir . md5($endpoint . serialize($params)) . '.json';
        $cacheTTL  = 900; // 15 menit

        if (file_exists($cacheKey) && (time() - filemtime($cacheKey)) < $cacheTTL) {
            return json_decode(file_get_contents($cacheKey), true);
        }

        $url     = $this->config->baseUrl . $endpoint . '?' . http_build_query($params);
        $context = stream_context_create([
            'http' => [
                'header'  => "X-Api-Key: {$this->config->apiKey}\r\nUser-Agent: PortalBeritaCI4/1.0\r\n",
                'timeout' => 10,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            return ['status' => 'error', 'message' => 'Gagal menghubungi NewsAPI', 'articles' => [], 'totalResults' => 0];
        }

        $data = json_decode($response, true);
        if ($data['status'] === 'ok') {
            file_put_contents($cacheKey, $response);
        }

        return $data;
    }

    protected function fetchTopHeadlinesOrFallback(array $params, string $query): array
    {
        $data = $this->fetch('top-headlines', $params);

        if (($data['status'] ?? '') !== 'ok' || !empty($data['articles'])) {
            return $data;
        }

        return $this->fetch('everything', [
            'q'        => $query,
            'language' => $this->config->language,
            'sortBy'   => 'publishedAt',
            'pageSize' => $params['pageSize'] ?? $this->config->pageSize,
            'page'     => $params['page'] ?? 1,
        ]);
    }
}
