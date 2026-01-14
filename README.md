<h2 align="center">Sistem Informasi E-Learning untuk Ujian Online</h2>

## Spesifikasi Project

- Laravel 8.x
- PHP 7.3+ / PHP 8.x
- MySQL Database

## Instalasi

### Persyaratan Sistem
- PHP >= 7.3 (disarankan PHP 8.0+)
- Composer
- MySQL 5.7+
- Node.js & NPM (opsional, untuk compile assets)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd laravel-elearning-master
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   - Buat database MySQL baru dengan nama `elearning`
   - Edit file `.env` dan sesuaikan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=elearning
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Jalankan Migrasi dan Seeder**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Buat Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Server**
   ```bash
   php artisan serve
   ```

8. **Akses Aplikasi**
   - Buka browser dan akses: `http://localhost:8000`

### Akun Default (setelah db:seed)
| Role  | Username    | Password |
|-------|-------------|----------|
| Admin | admin       | rahasia  |
| Guru  | 111         | rahasia  |
| Siswa | 13312233    | rahasia  |

## Fitur Utama

- ✅ Manajemen User (Admin, Guru, Siswa)
- ✅ Manajemen Ujian dengan Waktu (Jam Mulai - Jam Selesai)
- ✅ Ujian Online dengan Timer Countdown
- ✅ Auto Submit saat Waktu Habis
- ✅ Acak Soal (Randomize)
- ✅ Nilai Otomatis untuk Pilihan Ganda
- ✅ Detail Jawaban Siswa per Ujian
- ✅ Export Nilai ke PDF/Excel
- ✅ Dashboard Statistik
- ✅ Responsive untuk Mobile

## Screenshot

1. Dashboard Siswa
   <img src="screenshot/0-dashboard-siswa.png" >
2. Detail Soal Ujian Siswa
   <img src="screenshot/0-detail-soalujian-siswa.png" >
3. Ujian Online Siswa
   <img src="screenshot/1-ujian-online.png" >
4. Hasil Ujian Online Siswa
   <img src="screenshot/2-hasil-ujian-online.png" >
5. Nilai Semua Ujian Online Siswa
   <img src="screenshot/3-nilai-semua-ujian-online.png" >
6. Diskusi Tugas Siswa
   <img src="screenshot/4-diskusi-tugas-siswa.png" >
7. Dashboard Guru
   <img src="screenshot/5-dashboard-guru.png" >
8. Data Tugas Siswa
   <img src="screenshot/6-data-tugas-siswa.png" >
9. Tambah Soal Ujian Online
   <img src="screenshot/7-guru-tambah-soal-ujian.png" >
10. Detail Soal Ujian Online
    <img src="screenshot/8-guru-detaildatasoal-ujian.png" >
11. Edit Soal ujian Online
    <img src="screenshot/9-guru-editdatasoal-ujian.png" >
