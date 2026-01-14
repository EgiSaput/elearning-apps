# 📊 DOKUMENTASI UML - SISTEM E-LEARNING CBT

Dokumen ini berisi diagram UML lengkap untuk Sistem Informasi E-Learning Ujian Online (Computer Based Test).

---

## 📑 DAFTAR ISI

1. [Use Case Diagram](#1-use-case-diagram)
2. [Class Diagram](#2-class-diagram)
3. [Activity Diagram](#3-activity-diagram)
4. [Sequence Diagram](#4-sequence-diagram)

---

## 1. USE CASE DIAGRAM

### 1.1 Use Case Diagram - Keseluruhan Sistem

```plantuml
@startuml Use_Case_Diagram_Sistem_CBT

left to right direction
skinparam packageStyle rectangle
skinparam actorStyle awesome

' === ACTORS ===
actor "Admin" as Admin #LightBlue
actor "Guru" as Guru #LightGreen
actor "Siswa" as Siswa #LightYellow

' === SYSTEM BOUNDARY ===
rectangle "Sistem E-Learning CBT" {
    
    ' --- Authentication ---
    usecase "Login" as UC_Login
    usecase "Logout" as UC_Logout
    usecase "Ubah Password" as UC_UbahPassword
    
    ' --- Admin Use Cases ---
    package "Manajemen Admin" {
        usecase "Kelola User" as UC_KelolaUser
        usecase "Kelola Guru" as UC_KelolaGuru
        usecase "Kelola Siswa" as UC_KelolaSiswa
        usecase "Kelola Kelas" as UC_KelolaKelas
        usecase "Kelola Mata Pelajaran" as UC_KelolaMapel
        usecase "Assign Guru ke Kelas & Mapel" as UC_AssignGuru
        usecase "Kelola Pengumuman" as UC_KelolaPengumuman
        usecase "Lihat Semua Nilai" as UC_LihatSemuaNilai
    }
    
    ' --- Guru Use Cases ---
    package "Manajemen Guru" {
        usecase "Lihat Kelas Diampu" as UC_LihatKelas
        usecase "Kelola Bank Soal" as UC_KelolaSoal
        usecase "Kelola Ujian" as UC_KelolaUjian
        usecase "Lihat Hasil Ujian" as UC_LihatHasil
        usecase "Toggle Visibility Nilai" as UC_ToggleNilai
        usecase "Export Nilai (PDF/Excel)" as UC_ExportNilai
    }
    
    ' --- Siswa Use Cases ---
    package "Aktivitas Siswa" {
        usecase "Lihat Pengumuman" as UC_LihatPengumuman
        usecase "Lihat Daftar Ujian" as UC_LihatUjian
        usecase "Ambil Ujian" as UC_AmbilUjian
        usecase "Mulai Ujian" as UC_MulaiUjian
        usecase "Kerjakan Ujian" as UC_KerjakanUjian
        usecase "Submit Jawaban" as UC_SubmitJawaban
        usecase "Lihat Nilai" as UC_LihatNilai
        usecase "Edit Profil" as UC_EditProfil
    }
}

' === RELATIONSHIPS ===

' All actors can login/logout
Admin --> UC_Login
Guru --> UC_Login
Siswa --> UC_Login

Admin --> UC_Logout
Guru --> UC_Logout
Siswa --> UC_Logout

Admin --> UC_UbahPassword
Guru --> UC_UbahPassword
Siswa --> UC_UbahPassword

' Admin relationships
Admin --> UC_KelolaUser
Admin --> UC_KelolaGuru
Admin --> UC_KelolaSiswa
Admin --> UC_KelolaKelas
Admin --> UC_KelolaMapel
Admin --> UC_AssignGuru
Admin --> UC_KelolaPengumuman
Admin --> UC_LihatSemuaNilai
Admin --> UC_KelolaUjian
Admin --> UC_KelolaSoal

' Guru relationships
Guru --> UC_LihatKelas
Guru --> UC_KelolaSoal
Guru --> UC_KelolaUjian
Guru --> UC_LihatHasil
Guru --> UC_ToggleNilai
Guru --> UC_ExportNilai

' Siswa relationships
Siswa --> UC_LihatPengumuman
Siswa --> UC_LihatUjian
Siswa --> UC_AmbilUjian
Siswa --> UC_MulaiUjian
Siswa --> UC_KerjakanUjian
Siswa --> UC_SubmitJawaban
Siswa --> UC_LihatNilai
Siswa --> UC_EditProfil

' Include relationships
UC_AmbilUjian ..> UC_LihatUjian : <<include>>
UC_MulaiUjian ..> UC_AmbilUjian : <<include>>
UC_KerjakanUjian ..> UC_MulaiUjian : <<include>>
UC_SubmitJawaban ..> UC_KerjakanUjian : <<include>>

' Extend relationships
UC_SubmitJawaban <.. UC_KerjakanUjian : <<extend>>\n(auto-submit saat waktu habis)

@enduml
```

### 1.2 Deskripsi Use Case

| No | Use Case | Aktor | Deskripsi |
|----|----------|-------|-----------|
| 1 | Login | Admin, Guru, Siswa | Masuk ke sistem dengan username & password |
| 2 | Logout | Admin, Guru, Siswa | Keluar dari sistem |
| 3 | Kelola User | Admin | CRUD akun pengguna sistem |
| 4 | Kelola Guru | Admin | CRUD data guru (NIP, nama, dll) |
| 5 | Kelola Siswa | Admin | CRUD data siswa (NISN, nama, kelas, dll) |
| 6 | Kelola Kelas | Admin | CRUD data kelas |
| 7 | Kelola Mata Pelajaran | Admin | CRUD mata pelajaran |
| 8 | Assign Guru ke Kelas | Admin | Menghubungkan guru dengan kelas & mapel |
| 9 | Kelola Pengumuman | Admin | CRUD pengumuman untuk siswa |
| 10 | Kelola Bank Soal | Admin, Guru | CRUD soal pilihan ganda |
| 11 | Kelola Ujian | Admin, Guru | CRUD ujian (jadwal, durasi, soal) |
| 12 | Lihat Hasil Ujian | Guru | Melihat nilai siswa per ujian |
| 13 | Toggle Visibility | Guru | Show/hide nilai ke siswa |
| 14 | Ambil Ujian | Siswa | Mendaftar sebagai peserta ujian |
| 15 | Mulai Ujian | Siswa | Memulai mengerjakan ujian |
| 16 | Kerjakan Ujian | Siswa | Menjawab soal-soal ujian |
| 17 | Submit Jawaban | Siswa | Mengirim jawaban (manual/auto) |
| 18 | Lihat Nilai | Siswa | Melihat nilai ujian (jika visible) |

---

## 2. CLASS DIAGRAM

### 2.1 Class Diagram - Model Utama

```plantuml
@startuml Class_Diagram_E-Learning

skinparam classAttributeIconSize 0
skinparam class {
    BackgroundColor White
    BorderColor Black
    ArrowColor Black
}

' === CLASSES ===

class User {
    - id_user : int <<PK>>
    - name : string
    - username : string
    - email : string
    - password : string
    - level : int
    - remember_token : string
    - created_at : timestamp
    - updated_at : timestamp
    --
    + siswa() : Siswa
}

class Guru {
    - nip_guru : string <<PK>>
    - nama_guru : string
    - ttl_guru : string
    - jns_kelamin_guru : string
    - agama_guru : string
    - no_telp_guru : string
    - email_guru : string
    - alamat_guru : string
    - jabatan_guru : string
    - foto_guru : string
    - status_guru : string
    - id_user : int <<FK>>
    --
    + mataPelajaran() : Collection<MataPelajaran>
}

class Siswa {
    - nisn_siswa : string <<PK>>
    - nama_siswa : string
    - email_siswa : string
    - no_hp_siswa : string
    - ttl_siswa : string
    - jns_kelamin_siswa : string
    - alamat_siswa : string
    - foto_siswa : string
    - status_siswa : string
    - id_user : int <<FK>>
    - id_kelas : int <<FK>>
    --
    + user() : User
    + kelas() : Kelas
}

class Kelas {
    - id : int <<PK>>
    - nama_kelas : string
    - created_at : timestamp
    - updated_at : timestamp
    --
    + siswas() : Collection<Siswa>
    + mataPelajarans() : Collection<MataPelajaran>
}

class MataPelajaran {
    - id_mapel : int <<PK>>
    - nama_mapel : string
    - created_at : timestamp
    - updated_at : timestamp
    --
    + gurus() : Collection<Guru>
}

class Ujian {
    - id_ujian : int <<PK>>
    - nama_ujian : string
    - jenis_ujian : string
    - id_mapel : int <<FK>>
    - nama_kelas : string
    - durasi : int
    - tgl_mulai : date
    - tgl_selesai : date
    - jam_mulai : time
    - jam_selesai : time
    - kkm : int
    - acak : boolean
    - nilai_visible : boolean
    - status : string
    --
    + soals() : Collection<Soal>
    + nilaiUjians() : Collection<NilaiUjianPilihanGandaSiswa>
}

class Soal {
    - id_soal : int <<PK>>
    - jenis_soal : string
    - pertanyaan : text
    - jwb_a : string
    - jwb_b : string
    - jwb_c : string
    - jwb_d : string
    - jwb_e : string
    - kunci : string
    - gambar : string
    - poin : int
    - id_mapel : int <<FK>>
    --
    + ujians() : Collection<Ujian>
    + jawabans() : Collection<JawabanSoalUjian>
}

class SoalHasUjian {
    - id : int <<PK>>
    - id_soal : int <<FK>>
    - id_ujian : int <<FK>>
    --
    <<Pivot Table>>
}

class SiswaJawabUjianPilihanGanda {
    - id : int <<PK>>
    - nisn_siswa : string <<FK>>
    - id_ujian : int <<FK>>
    - id_soal : int <<FK>>
    - jawaban : string
    - status : string
    --
    + siswa() : Siswa
    + ujian() : Ujian
    + soal() : Soal
}

class NilaiUjianPilihanGandaSiswa {
    - id_nilai_ujian_pilgan : int <<PK>>
    - nisn_siswa : string <<FK>>
    - id_ujian : int <<FK>>
    - nilai : decimal
    - waktu_mulai : datetime
    - waktu_selesai : datetime
    - status : string
    --
    + siswa() : Siswa
    + ujian() : Ujian
}

class Pengumuman {
    - id_pengumuman : int <<PK>>
    - judul_pengumuman : string
    - isi_pengumuman : text
    - created_at : timestamp
    - updated_at : timestamp
}

class GuruMapel {
    - id : int <<PK>>
    - nip_guru : string <<FK>>
    - id_mapel : int <<FK>>
    - nama_kelas : string
    --
    <<Pivot Table>>
}

class KelasHaveMataPelajaran {
    - id : int <<PK>>
    - id_kelas : int <<FK>>
    - id_mapel : int <<FK>>
    --
    <<Pivot Table>>
}

class PengambilanUjian {
    - id : int <<PK>>
    - nisn_siswa : string <<FK>>
    - id_ujian : int <<FK>>
    - status : string
    - waktu_ambil : datetime
    --
    + siswa() : Siswa
    + ujian() : Ujian
}

' === RELATIONSHIPS ===

User "1" -- "0..1" Siswa : has >
User "1" -- "0..1" Guru : has >
Kelas "1" -- "*" Siswa : contains >
Kelas "*" -- "*" MataPelajaran : has >
Guru "*" -- "*" MataPelajaran : teaches >
MataPelajaran "1" -- "*" Ujian : has >
MataPelajaran "1" -- "*" Soal : contains >
Ujian "*" -- "*" Soal : contains >
Ujian "1" -- "*" SiswaJawabUjianPilihanGanda : has >
Ujian "1" -- "*" NilaiUjianPilihanGandaSiswa : produces >
Ujian "1" -- "*" PengambilanUjian : has >
Siswa "1" -- "*" SiswaJawabUjianPilihanGanda : answers >
Siswa "1" -- "*" NilaiUjianPilihanGandaSiswa : earns >
Siswa "1" -- "*" PengambilanUjian : takes >
Soal "1" -- "*" SiswaJawabUjianPilihanGanda : answered in >

' Pivot tables
Ujian .. SoalHasUjian
Soal .. SoalHasUjian
Guru .. GuruMapel
MataPelajaran .. GuruMapel
Kelas .. KelasHaveMataPelajaran
MataPelajaran .. KelasHaveMataPelajaran

@enduml
```

### 2.2 Keterangan Atribut Level User

| Level | Role | Keterangan |
|-------|------|------------|
| 11 | Admin | Full access ke semua fitur |
| 12 | Guru | Kelola ujian & soal mapel yang diampu |
| 13 | Siswa | Mengerjakan ujian & lihat nilai |

---

## 3. ACTIVITY DIAGRAM

### 3.1 Activity Diagram - Proses Login

```plantuml
@startuml Activity_Diagram_Login

|User|
start
:Akses Halaman Login;
:Input Username & Password;
:Klik Tombol Login;

|Sistem|
:Validasi Input;
if (Input Valid?) then (ya)
    :Cek Kredensial di Database;
    if (Username & Password Cocok?) then (ya)
        :Ambil Level User;
        if (Level = 11?) then (ya)
            :Redirect ke Dashboard Admin;
        elseif (Level = 12?) then (ya)
            :Redirect ke Dashboard Guru;
        else (Level = 13)
            :Redirect ke Dashboard Siswa;
        endif
        :Set Session Login;
    else (tidak)
        :Tampilkan Error "Username/Password Salah";
        |User|
        :Kembali ke Form Login;
    endif
else (tidak)
    :Tampilkan Validasi Error;
    |User|
    :Perbaiki Input;
endif

stop

@enduml
```

### 3.2 Activity Diagram - Mengerjakan Ujian (Siswa)

```plantuml
@startuml Activity_Diagram_Mengerjakan_Ujian

|Siswa|
start
:Login ke Sistem;
:Akses Menu Ujian;
:Lihat Daftar Ujian Tersedia;

|Sistem|
:Tampilkan Ujian Sesuai Kelas Siswa;
:Filter: Dalam Rentang Waktu Ujian;

|Siswa|
:Pilih Ujian;
:Klik "Ambil Ujian";

|Sistem|
:Cek Waktu Ujian;
if (Dalam Rentang Waktu?) then (ya)
    :Simpan Pengambilan Ujian;
    :Tampilkan Konfirmasi;
else (tidak)
    :Tampilkan "Ujian Belum/Sudah Berakhir";
    stop
endif

|Siswa|
:Klik "Mulai Ujian";

|Sistem|
:Catat Waktu Mulai;
:Load Soal Ujian;
if (Acak Soal = True?) then (ya)
    :Randomize Urutan Soal;
else (tidak)
    :Tampilkan Urutan Normal;
endif
:Start Timer Countdown;
:Tampilkan Soal Pertama;

|Siswa|
repeat
    :Baca Soal;
    :Pilih Jawaban (A/B/C/D/E);
    :Klik Simpan/Next;
    
    |Sistem|
    :Simpan Jawaban ke Database;
    :Update Navigasi Soal;
    
    |Siswa|
repeat while (Masih Ada Soal & Waktu Tersisa?) is (ya)
-> tidak;

|Siswa|
if (Manual Submit?) then (ya)
    :Klik Tombol "Selesai";
    :Konfirmasi Submit;
else (tidak)
    |Sistem|
    :Auto Submit (Waktu Habis);
endif

|Sistem|
:Catat Waktu Selesai;
:Hitung Nilai Otomatis;
note right
    Nilai = (Jawaban Benar × Poin) 
            / Total Poin × 100
end note
:Simpan Nilai ke Database;
:Tentukan Status (Lulus/Tidak);
:Tampilkan Hasil Ujian;

|Siswa|
:Lihat Nilai & Status;
if (Nilai Visible?) then (ya)
    :Tampilkan Nilai & Detail;
else (tidak)
    :Tampilkan "Nilai Tersembunyi";
endif

stop

@enduml
```

### 3.3 Activity Diagram - Admin Membuat Ujian

```plantuml
@startuml Activity_Diagram_Buat_Ujian

|Admin/Guru|
start
:Login ke Sistem;
:Akses Menu Ujian;
:Klik "Tambah Ujian";

|Sistem|
:Load Form Tambah Ujian;
:Load Daftar Mata Pelajaran;
:Load Daftar Kelas;
:Load Bank Soal;

|Admin/Guru|
:Input Nama Ujian;
:Pilih Mata Pelajaran;
:Pilih Kelas (Multiple);
:Pilih Jenis Ujian;
note right
    - Ujian Harian
    - UTS
    - UAS
end note
:Set Tanggal Mulai & Selesai;
:Set Jam Mulai & Jam Selesai;
:Set Durasi (menit);
:Set KKM;
:Set Opsi Acak Soal (Ya/Tidak);

fork
    :Pilih Soal dari Bank Soal;
fork again
    :Buat Soal Baru (Opsional);
end fork

:Klik "Simpan";

|Sistem|
:Validasi Input;
if (Input Valid?) then (ya)
    :Simpan Data Ujian;
    :Hubungkan Soal ke Ujian;
    :Set nilai_visible = false (Default);
    :Tampilkan Success Message;
else (tidak)
    :Tampilkan Validation Error;
    |Admin/Guru|
    :Perbaiki Input;
endif

stop

@enduml
```

### 3.4 Activity Diagram - Kelola Nilai (Guru)

```plantuml
@startuml Activity_Diagram_Kelola_Nilai

|Guru|
start
:Login ke Sistem;
:Akses Menu Nilai Siswa;

|Sistem|
:Load Kelas yang Diampu;
:Load Mata Pelajaran yang Diampu;

|Guru|
:Pilih Kelas;
:Pilih Mata Pelajaran;
:Klik "Tampilkan";

|Sistem|
:Query Nilai Siswa;
:Grouping per Jenis Ujian;
:Tampilkan Tabel Nilai;
note right
    Kolom:
    - Nama Siswa
    - Ujian Harian
    - UTS
    - UAS
    - Status Visibility
end note

|Guru|
if (Ingin Toggle Visibility?) then (ya)
    :Pilih Jenis Ujian;
    :Klik Toggle Show/Hide;
    
    |Sistem|
    :Update nilai_visible di Database;
    if (nilai_visible = true?) then (sebelumnya)
        :Set nilai_visible = false;
        :Siswa Tidak Bisa Lihat;
    else (sebelumnya false)
        :Set nilai_visible = true;
        :Siswa Bisa Lihat Nilai;
    endif
    :Refresh Tampilan;
else (tidak)
endif

|Guru|
if (Ingin Export?) then (ya)
    :Pilih Format (PDF/Excel);
    :Klik Export;
    
    |Sistem|
    :Generate File;
    :Download File;
else (tidak)
endif

|Guru|
if (Ingin Lihat Detail?) then (ya)
    :Klik Nama Siswa;
    
    |Sistem|
    :Tampilkan Detail Jawaban;
    :Tampilkan Soal & Jawaban Siswa;
    :Highlight Benar/Salah;
else (tidak)
endif

stop

@enduml
```

---

## 4. SEQUENCE DIAGRAM

### 4.1 Sequence Diagram - Proses Login

```plantuml
@startuml Sequence_Diagram_Login

actor User
participant "Browser" as Browser
participant "AuthController" as Auth
participant "User Model" as UserModel
database "Database" as DB

User -> Browser : Akses /login
Browser -> Auth : showLoginForm()
Auth --> Browser : Return login view

User -> Browser : Input username & password
User -> Browser : Submit form
Browser -> Auth : login(request)

Auth -> Auth : validate(request)
alt Validasi Gagal
    Auth --> Browser : Return with errors
    Browser --> User : Tampilkan error
end

Auth -> UserModel : where('username', $username)->first()
UserModel -> DB : SELECT * FROM users WHERE username = ?
DB --> UserModel : User data
UserModel --> Auth : User object

Auth -> Auth : Hash::check(password, user->password)
alt Password Salah
    Auth --> Browser : Redirect with error
    Browser --> User : "Username/Password salah"
end

Auth -> Auth : Auth::login(user)
Auth -> Auth : Check user->level

alt Level = 11 (Admin)
    Auth --> Browser : Redirect to /admin
else Level = 12 (Guru)
    Auth --> Browser : Redirect to /guru
else Level = 13 (Siswa)
    Auth --> Browser : Redirect to /siswa
end

Browser --> User : Dashboard sesuai level

@enduml
```

### 4.2 Sequence Diagram - Siswa Mengerjakan Ujian

```plantuml
@startuml Sequence_Diagram_Mengerjakan_Ujian

actor Siswa
participant "Browser" as Browser
participant "UjianController" as UjianCtrl
participant "SoalUjianController" as SoalCtrl
participant "Ujian Model" as UjianModel
participant "Soal Model" as SoalModel
participant "SiswaJawab Model" as JawabModel
participant "NilaiUjian Model" as NilaiModel
database "Database" as DB

== Ambil Ujian ==

Siswa -> Browser : Klik "Ambil Ujian"
Browser -> UjianCtrl : ambilUjian($id)
UjianCtrl -> UjianModel : find($id)
UjianModel -> DB : SELECT * FROM ujians WHERE id = ?
DB --> UjianModel : Ujian data
UjianModel --> UjianCtrl : Ujian object

UjianCtrl -> UjianCtrl : Cek waktu ujian
alt Diluar Waktu
    UjianCtrl --> Browser : Error "Ujian tidak tersedia"
end

UjianCtrl --> Browser : Tampilkan konfirmasi

Siswa -> Browser : Konfirmasi ambil
Browser -> UjianCtrl : simpanAmbilUjian($id)
UjianCtrl -> DB : INSERT INTO pengambilan_ujians
UjianCtrl --> Browser : Redirect ke halaman ujian

== Mulai Ujian ==

Siswa -> Browser : Klik "Mulai Ujian"
Browser -> UjianCtrl : mulaiUjian($id)
UjianCtrl -> UjianCtrl : Catat waktu_mulai
UjianCtrl -> SoalModel : getSoalByUjian($id)
SoalModel -> DB : SELECT soals.* FROM soals JOIN soal_has_ujians
DB --> SoalModel : List Soal
SoalModel --> UjianCtrl : Collection Soal

alt Acak = true
    UjianCtrl -> UjianCtrl : shuffle(soals)
end

UjianCtrl --> Browser : Tampilkan soal pertama + timer

== Menjawab Soal ==

loop Untuk setiap soal
    Siswa -> Browser : Pilih jawaban
    Siswa -> Browser : Klik "Simpan & Next"
    Browser -> SoalCtrl : update($ujian_id, $soal_id)
    
    SoalCtrl -> JawabModel : updateOrCreate()
    JawabModel -> DB : INSERT/UPDATE siswa_jawab_ujian_pilihan_gandas
    DB --> JawabModel : Success
    JawabModel --> SoalCtrl : Saved
    
    SoalCtrl --> Browser : Load soal berikutnya
end

== Submit Ujian ==

alt Manual Submit
    Siswa -> Browser : Klik "Selesai"
else Auto Submit (Waktu Habis)
    Browser -> Browser : Timer = 0
end

Browser -> UjianCtrl : submitUjian($id)
UjianCtrl -> UjianCtrl : Catat waktu_selesai

UjianCtrl -> JawabModel : getJawabanSiswa($ujian_id, $siswa_id)
JawabModel -> DB : SELECT * FROM siswa_jawab_ujian_pilihan_gandas
DB --> JawabModel : Jawaban siswa

UjianCtrl -> SoalModel : getKunciJawaban($ujian_id)
SoalModel -> DB : SELECT kunci FROM soals
DB --> SoalModel : Kunci jawaban

UjianCtrl -> UjianCtrl : hitungNilai()
note right
    for each jawaban:
        if jawaban == kunci:
            benar += poin
    nilai = (benar / total_poin) * 100
end note

UjianCtrl -> NilaiModel : create(nilai_data)
NilaiModel -> DB : INSERT INTO nilai_ujian_pilihan_ganda_siswas
DB --> NilaiModel : Saved

UjianCtrl --> Browser : Tampilkan hasil
Browser --> Siswa : Nilai & Status (Lulus/Tidak)

@enduml
```

### 4.3 Sequence Diagram - Admin Membuat Ujian

```plantuml
@startuml Sequence_Diagram_Buat_Ujian

actor "Admin/Guru" as Admin
participant "Browser" as Browser
participant "UjianController" as UjianCtrl
participant "Ujian Model" as UjianModel
participant "Soal Model" as SoalModel
participant "SoalHasUjian Model" as PivotModel
database "Database" as DB

Admin -> Browser : Akses menu Ujian
Browser -> UjianCtrl : index()
UjianCtrl -> UjianModel : all()
UjianModel -> DB : SELECT * FROM ujians
DB --> UjianModel : List ujian
UjianCtrl --> Browser : Tampilkan daftar ujian

Admin -> Browser : Klik "Tambah Ujian"
Browser -> UjianCtrl : showTambahUjian()
UjianCtrl -> DB : SELECT * FROM mata_pelajarans
UjianCtrl -> DB : SELECT * FROM kelas
UjianCtrl -> DB : SELECT * FROM soals
UjianCtrl --> Browser : Form tambah ujian + data

Admin -> Browser : Isi form ujian
note right
    - Nama Ujian
    - Mata Pelajaran
    - Kelas (multiple)
    - Jenis Ujian
    - Tanggal & Jam
    - Durasi
    - KKM
    - Pilih Soal
end note

Admin -> Browser : Submit form
Browser -> UjianCtrl : tambah(request)

UjianCtrl -> UjianCtrl : validate(request)
alt Validasi Gagal
    UjianCtrl --> Browser : Return with errors
end

UjianCtrl -> UjianModel : create(ujian_data)
UjianModel -> DB : INSERT INTO ujians
DB --> UjianModel : id_ujian

loop Untuk setiap soal yang dipilih
    UjianCtrl -> PivotModel : create(soal_ujian)
    PivotModel -> DB : INSERT INTO soal_has_ujians
end

UjianCtrl --> Browser : Redirect with success message
Browser --> Admin : "Ujian berhasil ditambahkan"

@enduml
```

### 4.4 Sequence Diagram - Toggle Visibility Nilai

```plantuml
@startuml Sequence_Diagram_Toggle_Nilai

actor Guru
participant "Browser" as Browser
participant "NilaiController" as NilaiCtrl
participant "Ujian Model" as UjianModel
database "Database" as DB

Guru -> Browser : Akses menu Nilai Siswa
Browser -> NilaiCtrl : showKelasNilai()
NilaiCtrl -> DB : SELECT kelas, mapel (sesuai guru)
NilaiCtrl --> Browser : Form pilih kelas & mapel

Guru -> Browser : Pilih Kelas & Mapel
Browser -> NilaiCtrl : showKelasNilai(request)

NilaiCtrl -> DB : SELECT nilai siswa
NilaiCtrl -> DB : SELECT ujians dengan nilai_visible
NilaiCtrl --> Browser : Tabel nilai + status visibility

Guru -> Browser : Klik Toggle Visibility
note right
    Toggle per jenis ujian:
    - Ujian Harian
    - UTS
    - UAS
end note

Browser -> NilaiCtrl : toggleNilaiVisibility(request)
NilaiCtrl -> UjianModel : where(conditions)->first()
UjianModel -> DB : SELECT * FROM ujians
DB --> UjianModel : Ujian object

NilaiCtrl -> NilaiCtrl : Toggle nilai_visible
alt Sebelumnya TRUE
    NilaiCtrl -> UjianModel : update(['nilai_visible' => false])
else Sebelumnya FALSE
    NilaiCtrl -> UjianModel : update(['nilai_visible' => true])
end

UjianModel -> DB : UPDATE ujians SET nilai_visible = ?
DB --> UjianModel : Updated

NilaiCtrl --> Browser : JSON response (success)
Browser -> Browser : Update UI (icon berubah)
Browser --> Guru : Nilai visibility updated

== Dampak ke Siswa ==

note over Browser, DB
    Saat siswa mengakses menu Nilai:
    - Jika nilai_visible = true: Tampilkan nilai
    - Jika nilai_visible = false: Tampilkan "Tersembunyi"
end note

@enduml
```

---

## 📝 CATATAN PENGGUNAAN

### Cara Render Diagram PlantUML:

1. **Online**: 
   - Kunjungi https://www.plantuml.com/plantuml/uml/
   - Copy-paste kode diagram
   - Klik "Submit"

2. **VS Code Extension**:
   - Install extension "PlantUML"
   - Buka file .puml atau .md dengan kode PlantUML
   - Tekan `Alt + D` untuk preview

3. **Export ke Image**:
   - Gunakan PlantUML online untuk download PNG/SVG
   - Atau gunakan command line: `java -jar plantuml.jar diagram.puml`

### Tools Alternatif:

- **Draw.io** (https://draw.io) - Manual drawing
- **Lucidchart** - Professional diagrams
- **StarUML** - UML modeling tool
- **Visual Paradigm** - Full UML suite

---

## 📚 REFERENSI

- Laravel 8.x Documentation
- UML 2.5 Specification
- PlantUML Language Reference

---

*Dokumen ini dibuat untuk Sistem E-Learning CBT - Laravel*
*Last Updated: January 2026*
