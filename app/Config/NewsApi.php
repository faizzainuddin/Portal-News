<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class NewsApi extends BaseConfig
{
    // Daftar di https://newsapi.org dan simpan API key di file .env.
    public string $apiKey    = '';
    public string $baseUrl   = 'https://newsapi.org/v2/';
    public string $language  = 'id';
    public string $country   = 'id';
    public int    $pageSize  = 20;

    // Mapping kategori NewsAPI
    public array $categories = [
        'umum'      => 'general',
        'bisnis'    => 'business',
        'teknologi' => 'technology',
        'olahraga'  => 'sports',
        'hiburan'   => 'entertainment',
        'sains'     => 'science',
        'kesehatan' => 'health',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->apiKey = (string) env('newsapi.apiKey', $this->apiKey);
    }
}
