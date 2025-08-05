# Koperasi FCFS

Koperasi FCFS adalah aplikasi berbasis web untuk pengelolaan simpanan dan pinjaman anggota koperasi, dengan mekanisme pengajuan pinjaman menggunakan sistem *First Come First Served* (FCFS). Aplikasi ini dikembangkan menggunakan framework Laravel, dirancang untuk memudahkan administrasi koperasi simpan pinjam secara digital, transparan, dan efisien.

## Fitur Utama

- **Manajemen Simpanan Anggota**
  - Pencatatan setoran awal dan bulanan.
  - Penarikan simpanan anggota.
  - Laporan transaksi simpanan dan saldo terkini.

- **Manajemen Pinjaman**
  - Pengajuan pinjaman secara online oleh anggota.
  - Persetujuan pinjaman oleh admin dengan sistem FCFS (First Come First Served).
  - Perhitungan bunga pinjaman (default 1.5% per bulan).
  - Notifikasi status pinjaman dan pembayaran angsuran.
  - Pembayaran angsuran otomatis mengurangi sisa pinjaman.

- **Dashboard Interaktif**
  - Statistik total simpanan dan pinjaman.
  - Riwayat transaksi terbaru untuk anggota maupun admin.
  - Notifikasi aktivitas penting.

- **Keamanan & Hak Akses**
  - Middleware untuk membatasi akses berdasarkan peran (admin/member).
  - Autentikasi pengguna dan pengelolaan sesi yang aman.

## Teknologi

- **Backend:** Laravel Framework
- **Database:** Mendukung MySQL, MariaDB, PostgreSQL, SQLite (disesuaikan via konfigurasi Laravel)
- **Frontend:** Bootstrap 5 & Blade Template
- **Autentikasi:** Laravel Auth & Middleware Role-based
- **Notifikasi:** Sistem notifikasi berbasis database

## Mekanisme FCFS (First Come First Served) Pinjaman

- Pengajuan pinjaman diproses berdasarkan urutan waktu masuk.
- Limit pinjaman: Rp 500.000 s/d Rp 50.000.000.
- Jangka waktu pinjaman: 3–60 bulan.
- Proses persetujuan maksimal 3 hari kerja.
- Tidak dapat mengajukan pinjaman baru jika masih ada pinjaman aktif.

## Instalasi & Konfigurasi

1. **Clone repositori:**
   ```bash
   git clone https://github.com/SirHosen/koperasi-fcfs.git
   cd koperasi-fcfs
   ```

2. **Install dependency:**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Copy file environment & konfigurasi:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Atur koneksi database di file .env
   ```

4. **Migrasi dan seeder database:**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan aplikasi:**
   ```bash
   php artisan serve
   ```

## Lisensi

Aplikasi ini dirilis di bawah [MIT License](LICENSE).

---
