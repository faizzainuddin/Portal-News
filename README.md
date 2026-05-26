# KabarID — Portal Berita CI4 + NewsAPI

Portal berita Indonesia berbasis **CodeIgniter 4** dengan sumber data dari **NewsAPI.org**.

---

## Fitur
- ✅ Headline utama (hero layout)
- ✅ Kategori berita (umum, bisnis, teknologi, olahraga, hiburan, sains, kesehatan)
- ✅ Pencarian berita
- ✅ Halaman detail artikel
- ✅ Dark mode / Light mode
- ✅ Cache otomatis 15 menit (hemat kuota API)
- ✅ Responsive mobile

---

## Struktur Project

```
portalnews/
├── app/
│   ├── Config/
│   │   ├── NewsApi.php        ← konfigurasi API key & kategori
│   │   └── Routes.php         ← routing
│   ├── Controllers/
│   │   ├── HomeController.php ← halaman utama
│   │   └── NewsController.php ← kategori, pencarian, detail
│   ├── Models/
│   │   └── NewsModel.php      ← semua request ke NewsAPI + cache
│   └── Views/
│       ├── layouts/main.php   ← layout utama (navbar, footer)
│       ├── home/
│       │   ├── index.php      ← tampilan beranda
│       │   └── pagination.php ← komponen pagination
│       └── news/
│           ├── search.php     ← hasil pencarian
│           └── detail.php     ← detail artikel
└── public/
    ├── css/app.css            ← stylesheet
    └── js/app.js              ← dark mode & UX
```

---

## Cara Install

### 1. Buat project CI4 baru
```bash
composer create-project codeigniter4/appstarter portalnews
cd portalnews
```

### 2. Salin file dari repo ini
Salin semua file ke folder CI4 yang baru dibuat (timpa file yang ada).

### 3. Daftar & dapatkan API Key
- Buka https://newsapi.org
- Klik **Get API Key** (gratis, tier developer)
- Salin API key kamu

### 4. Masukkan API Key
Edit file `app/Config/NewsApi.php`:
```php
public string $apiKey = 'MASUKKAN_API_KEY_KAMU_DI_SINI';
```

### 5. Izinkan folder cache
```bash
chmod -R 777 writable/
```

### 6. Jalankan server
```bash
php spark serve
```

Akses di browser: **http://localhost:8080**

---

## Batasan NewsAPI (Free Tier)
| Limit | Keterangan |
|---|---|
| 100 request/hari | Cukup untuk pengembangan |
| Max 5 halaman | Pagination dibatasi |
| Berita maks 1 bulan lalu | Untuk pencarian (`/everything`) |
| `localhost` support | ✅ Bisa dipakai saat development |

---

## Routing

| URL | Controller | Keterangan |
|---|---|---|
| `/` | HomeController::index | Halaman utama |
| `/kategori/:slug` | NewsController::kategori | Berita per kategori |
| `/cari?q=...` | NewsController::cari | Pencarian |
| `/berita/:slug` | NewsController::detail | Detail artikel |

---

## Kategori yang Tersedia
`umum` · `bisnis` · `teknologi` · `olahraga` · `hiburan` · `sains` · `kesehatan`

---

## Tips Pengembangan
- Ganti `YOUR_NEWSAPI_KEY` secepatnya — tanpa key, semua request akan error
- Cache tersimpan di `writable/cache/newsapi/` — aman dihapus kapan saja
- Untuk production, pastikan variabel API key disimpan di `.env`, bukan hardcode
