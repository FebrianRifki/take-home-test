# Aplikasi Manajemen Perpustakaan (Take-Home Test)

Aplikasi ini adalah sistem manajemen perpustakaan yang dibangun menggunakan **Laravel 13** dengan antarmuka bergaya *Glassmorphism*. Aplikasi ini dilengkapi dengan fitur Master Data (Buku dan Anggota) serta Transaksi (Peminjaman dan Pengembalian).

## Fitur Utama
1. **Dashboard**: Menampilkan metrik utama dan grafik peminjaman buku.
2. **Master Anggota**: CRUD data anggota perpustakaan lengkap dengan limit peminjaman buku (*stock*).
3. **Master Buku**: CRUD data buku beserta manajemen kuantitas stok fisik.
4. **Peminjaman**:
   - Memungkinkan peminjaman **banyak buku sekaligus** secara dinamis menggunakan *Vanilla JS*.
   - **Validasi Otomatis**: Memastikan kuantitas peminjaman tidak melebihi stok buku fisik, serta membatasi total buku yang dipinjam agar tidak melampaui limit *stock* anggota.
   - Stok buku terpotong secara otomatis (*auto-decrement*) di *database* saat transaksi berhasil (menggunakan *Database Transaction*).
5. **Pengembalian**:
   - Buku dikembalikan berdasarkan transaksi.
   - Menggunakan mekanisme tabel `returns` untuk menyimpan rekam jejak tanggal pengembalian.
   - Stok buku otomatis dipulihkan (*auto-increment*) secara aman (juga dibungkus dalam *Database Transaction*).

---

## Persyaratan Sistem (Requirements)

Pastikan lingkungan lokal (komputer) Anda sudah terinstal *software* berikut sebelum menjalankan aplikasi:

1. **PHP**: Versi `^8.3`
2. **Composer**: Versi `2.x`
3. **Node.js**: Versi `>= 18.x` (berserta `npm` untuk kompilasi *asset* Vite)
4. **Database**: SQLite (default) atau MySQL / PostgreSQL.

---

## Panduan Instalasi (Installation Guide)

Ikuti langkah-langkah di bawah ini secara berurutan untuk menjalankan aplikasi di mesin lokal Anda:

### 1. Clone Repository
```bash
git clone https://github.com/FebrianRifki/take-home-test.git
cd take-home-test
```

### 2. Install Dependensi PHP
Jalankan Composer untuk mengunduh semua *package* Laravel yang dibutuhkan:
```bash
composer install
```

### 3. Konfigurasi Environment (File `.env`)
Salin file `.env.example` menjadi `.env`:
```bash
# Untuk Windows (Command Prompt):
copy .env.example .env

# Untuk Mac/Linux/GitBash:
cp .env.example .env
```
Secara default, Laravel akan menggunakan **SQLite** jika tidak ada konfigurasi database MySQL spesifik. Pastikan konfigurasi di `.env` sudah mengarah ke `DB_CONNECTION=sqlite` (sudah default di Laravel 11/13).

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Install Dependensi Frontend & Build Assets
Aplikasi ini menggunakan Vite untuk kompilasi *frontend*. Install Node modules dan jalankan *build*:
```bash
npm install
npm run build
```

### 6. Jalankan Migrasi dan Seeder
Agar database siap digunakan beserta data bawaan (dummy), jalankan migrasi yang telah dipasangkan dengan *seeder*:
```bash
php artisan migrate:fresh --seed
```
*Catatan: Ini akan mengosongkan *database* jika sudah ada, membuat seluruh tabel baru, dan mengisi data awal (Users, Members, Books, dan contoh Borrowings).*

### 7. Jalankan Local Server
Setelah semua selesai, nyalakan *development server* bawaan Laravel:
```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui browser di alamat:
**[http://localhost:8000](http://localhost:8000)**

---

## Penggunaan Singkat
- Saat Anda membuka aplikasi, Anda akan diarahkan ke halaman **Login**.
- Gunakan data *login* bawaan dari `UserSeeder` admin@admin.com | password admin (atau buat *user* baru di *database* jika perlu).
- Jelajahi menu navigasi di sebelah kiri (Menu Master & Menu Transaksi).

Selamat mencoba!
