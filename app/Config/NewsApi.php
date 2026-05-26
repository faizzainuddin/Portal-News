<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class NewsApi extends BaseConfig
{
    // Daftar di https://newsapi.org dan masukkan API key kamu di sini
    public string $apiKey    = '3c54fdd898eb49c9aacffd3857f7dca9';
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
}
