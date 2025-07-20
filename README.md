# SIPATEX – Tes

## Persyaratan Sistem

Sebelum menjalankan aplikasi ini, pastikan perangkat telah memenuhi persyaratan berikut:

- PHP versi 8.1 atau lebih baru
- Composer
- MySQL atau MariaDB
- Git

## Langkah Instalasi

### 1. Kloning Repository

Unduh kode sumber dari GitHub:

```bash
git clone https://github.com/LianPermadi/sipatex.git
cd sipatex
```

### 2. Instalasi Dependensi Backend

Jalankan perintah berikut untuk mengunduh dependensi PHP:

```bash
composer install
```

### 3. Konfigurasi File Lingkungan

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Kemudian buka file `.env` dan sesuaikan konfigurasi database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipatex
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Buat Database

Masuk ke MySQL dan buat database baru:

```sql
CREATE DATABASE sipatex;
```

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 7. Menjalankan Aplikasi

Jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Akses aplikasi melalui browser di:

```
http://localhost:8000
```

## Struktur Direktori Penting

| Direktori              | Deskripsi                                  |
|------------------------|--------------------------------------------|
| `app/Http/Controllers` | Berisi logika controller aplikasi          |
| `resources/views`      | Template Blade untuk tampilan aplikasi     |
| `routes/web.php`       | Seluruh definisi route tersedia di sini    |
| `database/migrations`  | File migrasi untuk struktur database       |
| `public/`              | Folder yang digunakan untuk akses publik   |

## Informasi Tambahan

- Sistem ini belum menerapkan fitur autentikasi.
- Untuk keperluan produksi, direkomendasikan untuk mengatur konfigurasi `.env` sesuai dengan server yang digunakan.

## Lisensi

Aplikasi ini menggunakan lisensi MIT dan bebas digunakan, dimodifikasi, serta disesuaikan untuk kebutuhan pengembangan lebih lanjut.
