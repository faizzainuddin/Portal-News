# Portal News

Portal berita Indonesia berbasis CodeIgniter 4 yang mengambil data dari NewsAPI.org.

## Fitur

- Headline berita utama
- Kategori berita: umum, bisnis, teknologi, olahraga, hiburan, sains, kesehatan
- Pencarian berita
- Halaman detail artikel
- Dark mode dan light mode
- Cache otomatis 15 menit untuk menghemat request API
- Tampilan responsif untuk desktop dan mobile

## Teknologi

- PHP 8.2+
- CodeIgniter 4
- Composer
- NewsAPI.org

## Struktur Project

```text
portalnews/
|-- app/
|   |-- Config/
|   |   |-- NewsApi.php
|   |   `-- Routes.php
|   |-- Controllers/
|   |   |-- HomeController.php
|   |   `-- NewsController.php
|   |-- Models/
|   |   `-- NewsModel.php
|   `-- Views/
|       |-- layouts/
|       |-- home/
|       `-- news/
|-- public/
|   |-- css/app.css
|   |-- js/app.js
|   `-- index.php
|-- writable/
|-- composer.json
`-- spark
```

## Instalasi

1. Clone repository.

```bash
git clone https://github.com/faizzainuddin/Portal-News.git
cd Portal-News
```

2. Install dependency.

```bash
composer install
```

3. Buat file `.env` dari file contoh `env`.

```bash
copy env .env
```

4. Isi API key NewsAPI di file `.env`.

```ini
newsapi.apiKey = MASUKKAN_API_KEY_KAMU
```

API key bisa didapatkan dari https://newsapi.org.

5. Jalankan server development.

```bash
php spark serve
```

6. Buka aplikasi di browser.

```text
http://localhost:8080
```

## Routing

| URL | Keterangan |
| --- | --- |
| `/` | Halaman utama |
| `/kategori/:slug` | Berita berdasarkan kategori |
| `/cari?q=keyword` | Pencarian berita |
| `/berita/:slug` | Detail artikel |

## Catatan

- Jangan commit file `.env` karena berisi konfigurasi lokal dan API key.
- Cache NewsAPI tersimpan di `writable/cache/newsapi/` dan aman dihapus saat development.
- Jika Composer meminta ekstensi `intl`, aktifkan `extension=intl` di `php.ini`.
