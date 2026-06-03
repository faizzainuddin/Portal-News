# Portal News

Portal News adalah aplikasi portal berita Indonesia berbasis CodeIgniter 4. Aplikasi ini mengambil data berita dari NewsAPI.org, menampilkan headline terbaru, kategori berita, pencarian artikel, halaman detail berita, serta mendukung tampilan dark mode dan light mode.

Project ini dibuat untuk kebutuhan pembelajaran Teknologi Web dan dapat dijalankan secara lokal menggunakan PHP development server bawaan CodeIgniter.

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi](#teknologi)
- [Kebutuhan Sistem](#kebutuhan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi NewsAPI](#konfigurasi-newsapi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Routing](#routing)
- [Struktur Project](#struktur-project)
- [Troubleshooting](#troubleshooting)
- [Catatan Keamanan](#catatan-keamanan)

## Fitur

- Menampilkan headline berita utama.
- Menampilkan berita berdasarkan kategori.
- Pencarian berita berdasarkan kata kunci.
- Halaman detail artikel berita.
- Pagination untuk daftar berita.
- Dark mode dan light mode.
- Cache otomatis selama 15 menit untuk menghemat kuota NewsAPI.
- Layout responsif untuk desktop dan mobile.

## Kategori Berita

Aplikasi menyediakan beberapa kategori berita:

- Umum
- Bisnis
- Teknologi
- Olahraga
- Hiburan
- Sains
- Kesehatan

## Teknologi

- PHP 8.2+
- CodeIgniter 4
- Composer
- HTML
- CSS
- JavaScript
- NewsAPI.org

## Kebutuhan Sistem

Pastikan komputer sudah memiliki:

- PHP minimal versi 8.2
- Composer
- Ekstensi PHP `intl`
- Koneksi internet untuk mengambil data dari NewsAPI
- API key dari NewsAPI.org

Untuk pengguna XAMPP, PHP dan Composer dapat dijalankan dari terminal tanpa harus menyalakan Apache, selama command `php` sudah mengarah ke PHP XAMPP.

## Instalasi

Clone repository:

```bash
git clone https://github.com/faizzainuddin/Portal-News.git
cd Portal-News
```

Install dependency:

```bash
composer install
```

Buat file `.env` dari file contoh `env`:

```bash
copy env .env
```

Untuk Linux atau macOS:

```bash
cp env .env
```

## Konfigurasi NewsAPI

Daftar dan ambil API key dari:

```text
https://newsapi.org
```

Lalu buka file `.env` dan tambahkan API key:

```ini
newsapi.apiKey = MASUKKAN_API_KEY_KAMU
```

Contoh:

```ini
newsapi.apiKey = abcdef1234567890
```

File `.env` tidak boleh di-commit ke GitHub karena berisi konfigurasi lokal dan data sensitif.

## Menjalankan Aplikasi

Jalankan server development CodeIgniter:

```bash
php spark serve
```

Jika berhasil, aplikasi bisa dibuka di:

```text
http://localhost:8080
```

Jika port 8080 sudah digunakan, jalankan dengan port lain:

```bash
php spark serve --port 8081
```

Lalu buka:

```text
http://localhost:8081
```

## Menjalankan Dengan XAMPP Apache

Cara ini opsional. Cara yang direkomendasikan tetap menggunakan `php spark serve`.

Jika ingin menjalankan lewat Apache XAMPP:

1. Pindahkan folder project ke `htdocs`, misalnya `D:\xampp\htdocs\Portal-News`.
2. Jalankan Apache dari XAMPP Control Panel.
3. Buka aplikasi melalui:

```text
http://localhost/Portal-News/public
```

## Routing

| URL | Controller | Keterangan |
| --- | --- | --- |
| `/` | `HomeController::index` | Halaman utama |
| `/kategori/:slug` | `NewsController::kategori` | Berita berdasarkan kategori |
| `/cari?q=keyword` | `NewsController::cari` | Pencarian berita |
| `/berita/:slug` | `NewsController::detail` | Detail artikel |

Contoh penggunaan:

```text
http://localhost:8080/kategori/teknologi
http://localhost:8080/cari?q=politik
```

## Struktur Project

```text
portalnews/
|-- app/
|   |-- Config/
|   |   |-- NewsApi.php
|   |   `-- Routes.php
|   |-- Controllers/
|   |   |-- BaseController.php
|   |   |-- HomeController.php
|   |   `-- NewsController.php
|   |-- Models/
|   |   `-- NewsModel.php
|   `-- Views/
|       |-- layouts/
|       |   `-- main.php
|       |-- home/
|       |   |-- index.php
|       |   `-- pagination.php
|       `-- news/
|           |-- detail.php
|           `-- search.php
|-- public/
|   |-- css/
|   |   `-- app.css
|   |-- js/
|   |   `-- app.js
|   `-- index.php
|-- tests/
|-- writable/
|-- composer.json
|-- env
|-- spark
`-- README.md
```

## Penjelasan Folder

| Folder/File | Fungsi |
| --- | --- |
| `app/Config/NewsApi.php` | Konfigurasi NewsAPI, kategori, bahasa, negara, dan jumlah data |
| `app/Config/Routes.php` | Daftar route aplikasi |
| `app/Controllers/` | Logic untuk halaman utama, kategori, pencarian, dan detail berita |
| `app/Models/NewsModel.php` | Proses request ke NewsAPI dan penyimpanan cache |
| `app/Views/` | Template tampilan aplikasi |
| `public/` | Asset publik seperti CSS, JavaScript, favicon, dan entry point aplikasi |
| `writable/` | Folder cache, log, session, dan file runtime CodeIgniter |

## Testing

Untuk melihat daftar route yang aktif:

```bash
php spark routes
```

Untuk menjalankan unit test:

```bash
composer test
```

## Troubleshooting

### Composer tidak menemukan `composer.json`

Pastikan terminal berada di folder project:

```bash
cd "D:\UNJANI\SEMESTER 6\TEKNOLOGI WEB\TUBES\portalnews"
composer install
```

### Error `ext-intl` belum aktif

Aktifkan ekstensi `intl` di `php.ini`.

Untuk XAMPP, buka:

```text
D:\xampp\php\php.ini
```

Cari baris:

```ini
;extension=intl
```

Ubah menjadi:

```ini
extension=intl
```

Simpan file, lalu ulangi:

```bash
composer install
```

### Port 8080 sudah digunakan

Gunakan port lain:

```bash
php spark serve --port 8081
```

### Berita tidak tampil

Periksa beberapa hal berikut:

- API key NewsAPI sudah benar.
- API key sudah ditulis di file `.env`.
- Koneksi internet aktif.
- Kuota request NewsAPI belum habis.
- Folder `writable/` bisa ditulis oleh aplikasi.

## Catatan Keamanan

- Jangan commit file `.env`.
- Jangan hardcode API key di source code.
- Untuk production, gunakan environment variable server.
- Folder `writable/cache/newsapi/` aman dihapus saat development.

## Author

Repository:

```text
https://github.com/faizzainuddin/Portal-News
```
