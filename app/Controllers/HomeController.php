<?php

namespace App\Controllers;

use App\Models\NewsModel;

class HomeController extends BaseController
{
    protected NewsModel $news;

    public function __construct()
    {
        $this->news = new NewsModel();
    }

    public function index(): string
    {
        $page     = (int) ($this->request->getGet('page') ?? 1);
        $data     = $this->news->getHeadlines($page);
        $articles = $data['articles'] ?? [];

        // Pisahkan artikel hero (3 teratas) dan sisanya
        $heroArticles = array_slice($articles, 0, 3);
        $restArticles = array_slice($articles, 3);

        return view('layouts/main', [
            'title'        => 'Portal Berita Indonesia',
            'activePage'   => 'home',
            'heroArticles' => $heroArticles,
            'restArticles' => $restArticles,
            'totalResults' => $data['totalResults'] ?? 0,
            'currentPage'  => $page,
            'newsModel'    => $this->news,
        ]);
    }
}
