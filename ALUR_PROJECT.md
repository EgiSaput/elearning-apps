# 📚 ALUR PROJECT SISTEM UJIAN ONLINE (CBT)

## Deskripsi Singkat
Sistem Ujian Online (Computer Based Test) berbasis Laravel untuk mengelola ujian pilihan ganda dengan 3 level pengguna: **Admin**, **Guru**, dan **Siswa**.

---

## 🔐 LEVEL PENGGUNA

| Level | Kode | Akses |
|-------|------|-------|
| Admin | 11 | Full access - kelola semua data |
| Guru | 12 | Kelola ujian & soal mapel yang diampu |
| Siswa | 13 | Mengerjakan ujian & melihat nilai |

---

## 👨‍💼 ALUR ADMIN

### 1. Login sebagai Admin
- Akses halaman login
- Masukkan username & password (level 11)
- Redirect ke Dashboard Admin

### 2. Menambahkan Data Guru
```
Menu: Kelola Guru → Tambah Guru
```
- Input: NIP, Nama, Alamat, No HP, Foto
- Sistem otomatis membuat akun login untuk guru
- Username & password digenerate

### 3. Menambahkan Data Kelas
```
Menu: Kelola Kelas → Tambah Kelas
```
- Input: Nama Kelas (contoh: X IPA 1, XI IPS 2)
- Kelas digunakan untuk grouping siswa

### 4. Menambahkan Data Mata Pelajaran
```
Menu: Kelola Mata Pelajaran → Kelola Mata Pelajaran → Tambah
```
- Input: Nama Mata Pelajaran
- Contoh: Matematika, Bahasa Indonesia, Fisika

### 5. Assign Guru ke Mata Pelajaran & Kelas
```
Menu: Kelola Kelas → Edit Kelas → Pilih Tab "Guru & Mata Pelajaran"
```
- Pilih Guru yang akan mengajar
- Pilih Mata Pelajaran yang diajarkan
- Klik "Tambah Guru Mapel"
- **Satu guru bisa mengajar beberapa mapel di beberapa kelas**

### 6. Menambahkan Data Siswa
```
Menu: Kelola Siswa → Tambah Siswa
```
- Input: NIS, Nama, Kelas, Jenis Kelamin, Alamat, No HP, Foto
- Sistem otomatis membuat akun login untuk siswa
- Siswa terhubung ke kelas tertentu

### 7. Mengelola User/Pengguna
```
Menu: Kelola Pengguna
```
- Melihat semua akun (Admin, Guru, Siswa)
- Edit username/password
- Hapus akun
- Tambah akun baru

### 8. Mengelola Pengumuman
```
Menu: Kelola Pengumuman → Tambah Pengumuman
```
- Input: Judul, Isi Pengumuman
- Pengumuman tampil di dashboard siswa

### 9. Melihat Nilai Siswa
```
Menu: Kelola Mata Pelajaran → Nilai Siswa
```
- Pilih Kelas dan Mata Pelajaran
- Lihat nilai Ujian Harian, UTS, UAS
- **Toggle Visibility**: Sembunyikan/Tampilkan nilai ke siswa

---

## 👨‍🏫 ALUR GURU

### 1. Login sebagai Guru
- Akses halaman login
- Masukkan username & password (level 12)
- Redirect ke Dashboard Guru

### 2. Melihat Kelas yang Diampu
```
Menu: Kelola Mata Pelajaran → Kelas Anda
```
- Melihat daftar kelas & mapel yang diajar
- Berdasarkan assignment dari Admin

### 3. Menambah Soal Ujian
```
Menu: Kelola Mata Pelajaran → Soal Ujian Siswa → Tambah Soal
```
**Input:**
- Mata Pelajaran (sesuai yang diampu)
- Pertanyaan Soal
- Pilihan Jawaban (A, B, C, D, E)
- Kunci Jawaban
- Gambar (opsional)
- Poin/Bobot soal

**Catatan:** Soal disimpan di bank soal, bisa dipakai untuk beberapa ujian

### 4. Menambah/Membuat Ujian
```
Menu: Kelola Mata Pelajaran → Ujian Siswa → Tambah Ujian
```
**Input:**
- Nama Ujian
- Mata Pelajaran
- Kelas Ujian (bisa multiple: X IPA 1, X IPA 2, dst)
- Jenis Ujian: Ujian Harian / UTS / UAS
- Jenis Soal: Pilihan Ganda
- Tanggal & Waktu Mulai
- Tanggal & Waktu Selesai
- Durasi Ujian (menit)
- KKM (Kriteria Ketuntasan Minimal)
- Pilih Soal dari Bank Soal

### 5. Melihat Detail Ujian
```
Menu: Ujian Siswa → Klik "Detail"
```
- Melihat daftar siswa yang sudah mengerjakan
- Status: Sudah Selesai / Belum Mengerjakan
- Nilai masing-masing siswa
- Waktu pengerjaan

### 6. Melihat Nilai Siswa
```
Menu: Kelola Mata Pelajaran → Nilai Siswa
```
- Pilih Kelas dan Mata Pelajaran
- Lihat rekap nilai per jenis ujian
- **Toggle Visibility**: Sembunyikan/Tampilkan nilai

---

## 👨‍🎓 ALUR SISWA

### 1. Login sebagai Siswa
- Akses halaman login
- Masukkan username & password (level 13)
- Redirect ke Dashboard Siswa

### 2. Melihat Pengumuman
```
Menu: Pengumuman
```
- Melihat pengumuman dari Admin/Sekolah

### 3. Melihat Daftar Ujian
```
Menu: Ujian
```
- Melihat ujian yang tersedia untuk kelasnya
- Status ujian: Tersedia / Sudah Dikerjakan / Belum Dimulai / Sudah Berakhir

### 4. Mengambil Ujian
```
Klik tombol "Ambil Ujian"
```
- Konfirmasi pengambilan ujian
- Siswa terdaftar sebagai peserta ujian
- **Catatan:** Harus dalam rentang waktu ujian

### 5. Memulai Ujian
```
Klik tombol "Mulai Ujian"
```
- Konfirmasi memulai ujian
- Timer/countdown dimulai
- **Tidak bisa di-pause setelah dimulai**

### 6. Mengerjakan Ujian
- Soal ditampilkan satu per satu atau semua (tergantung setting)
- Pilih jawaban (A/B/C/D/E)
- Navigasi: Previous / Next
- Bisa review jawaban sebelum submit
- **Auto-submit jika waktu habis**

### 7. Submit Ujian
```
Klik tombol "Selesai/Submit"
```
- Konfirmasi submit
- Sistem menghitung nilai otomatis
- Redirect ke halaman hasil

### 8. Melihat Nilai
```
Menu: Nilai
```
**Jika nilai DITAMPILKAN (visible):**
- Melihat nilai per mata pelajaran
- Nilai Ujian Harian, UTS, UAS
- Status: Lulus / Tidak Lulus (berdasarkan KKM)

**Jika nilai DISEMBUNYIKAN (hidden):**
- Tampil tulisan "Tersembunyi"
- Siswa tidak bisa melihat nilai
- Menunggu guru/admin menampilkan

---

## 🔄 FLOW DIAGRAM

```
┌─────────────────────────────────────────────────────────────────┐
│                         ADMIN                                    │
├─────────────────────────────────────────────────────────────────┤
│  1. Tambah Guru ──→ 2. Tambah Kelas ──→ 3. Tambah Mapel         │
│         │                  │                   │                 │
│         └──────────────────┴───────────────────┘                 │
│                            │                                     │
│                   4. Assign Guru ke Kelas & Mapel                │
│                            │                                     │
│                   5. Tambah Siswa (pilih Kelas)                  │
└─────────────────────────────────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                          GURU                                    │
├─────────────────────────────────────────────────────────────────┤
│  1. Lihat Kelas Diampu                                          │
│         │                                                        │
│  2. Buat Soal Ujian (Bank Soal)                                 │
│         │                                                        │
│  3. Buat Ujian ──→ Pilih Kelas ──→ Pilih Soal                   │
│         │                                                        │
│  4. Lihat Hasil & Nilai ──→ Toggle Visibility                   │
└─────────────────────────────────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                         SISWA                                    │
├─────────────────────────────────────────────────────────────────┤
│  1. Lihat Daftar Ujian                                          │
│         │                                                        │
│  2. Ambil Ujian ──→ 3. Mulai Ujian ──→ 4. Kerjakan              │
│                                              │                   │
│                                        5. Submit                 │
│                                              │                   │
│  6. Lihat Nilai ◄────────────────────────────┘                  │
│         │                                                        │
│         ├── Jika Visible: Tampil Nilai & Status                 │
│         └── Jika Hidden: Tampil "Tersembunyi"                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## ⚙️ FITUR KHUSUS

### Auto-Hide Nilai (Default)
- Saat ujian dibuat, nilai otomatis **tersembunyi**
- Guru/Admin harus klik "Tampilkan Nilai" agar siswa bisa lihat
- Berguna untuk: pengumuman nilai serentak, review soal dulu

### Toggle Visibility Nilai
- Admin/Guru bisa show/hide nilai per jenis ujian
- Contoh: Tampilkan nilai Ujian Harian, tapi sembunyikan UTS
- Berlaku untuk semua siswa di kelas tersebut

### Jenis Ujian
| Jenis | Keterangan |
|-------|------------|
| Ujian Harian | Ujian rutin per bab/materi |
| UTS | Ujian Tengah Semester |
| UAS | Ujian Akhir Semester |

### Perhitungan Nilai
```
Nilai = (Jawaban Benar × Poin) / Total Poin × 100
```
- Setiap soal bisa punya poin berbeda
- Status Lulus jika Nilai ≥ KKM

---

## 📱 TEKNOLOGI

- **Framework:** Laravel 5.x
- **Database:** MySQL
- **Frontend:** AdminLTE, Bootstrap
- **Authentication:** Laravel Auth

---

## 📞 SUPPORT

Untuk pertanyaan atau bantuan teknis, hubungi administrator sistem.
