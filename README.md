# 🎓 SI-MAGANG  
**Sistem Informasi Manajemen Magang Berbasis Web**

> Aplikasi web untuk mengelola seluruh proses magang — mulai dari pendaftaran, verifikasi, monitoring kegiatan, hingga laporan dan penilaian — secara terstruktur, efisien, dan terdokumentasi.

### 🖥️ Preview Antarmuka Admin
Dashboard Admin

<p align="center">
  <img src="public/Docs/Screenshot%202025-11-02%20100514.png" alt="Tampilan Dashboard Admin" width="800"/>
</p>


### 🖥️ Preview Antarmuka Mahasiswa
Dashboard Mahasiswa

<p align="center">
  <img src="public/Docs/Screenshot%202025-11-02%20100514.png" alt="Tampilan Dashboard Mahasiswa" width="800"/>
</p>
---

## 📌 Deskripsi Umum

**SI-MAGANG** adalah sistem informasi berbasis web yang dirancang untuk membantu **institusi pendidikan, perusahaan, maupun organisasi** dalam mengelola program magang secara digital.

Sistem ini menggantikan proses manual (Excel, Google Form, dokumen fisik) menjadi **satu platform terintegrasi** yang mudah digunakan oleh:
- Admin
- Pembimbing / Koordinator
- Peserta Magang (Mahasiswa)

---

## 🎯 Tujuan Sistem

- Menyederhanakan proses pendaftaran magang
- Mempermudah pengelolaan data peserta
- Memantau progres dan aktivitas magang
- Menyediakan laporan & dokumentasi yang rapi
- Meningkatkan transparansi dan efisiensi

---

## 👥 Role Pengguna

### 1️⃣ Admin
- Mengelola data pengguna
- Mengelola data peserta magang
- Verifikasi pendaftaran
- Monitoring aktivitas
- Mengelola penilaian & laporan

### 2️⃣ Pembimbing / Koordinator
- Memantau logbook peserta
- Memberikan catatan & evaluasi
- Melihat laporan magang

### 3️⃣ Peserta Magang (Mahasiswa)
- Mendaftar magang
- Mengunggah berkas persyaratan
- Mengisi logbook harian
- Melihat status & hasil penilaian

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Login & Logout
- Manajemen role (Admin / Pembimbing / Peserta)
- Proteksi akses berbasis role

### 📝 Pendaftaran Magang
- Input data diri peserta
- Upload dokumen persyaratan
- Status pendaftaran (Pending / Diterima / Ditolak)

### 📊 Manajemen Data
- CRUD data peserta
- CRUD data pembimbing
- Manajemen periode magang

### 📒 Logbook & Monitoring
- Pengisian kegiatan harian
- Catatan pembimbing
- Riwayat aktivitas magang

### 🧾 Penilaian & Laporan
- Penilaian peserta magang
- Rekap hasil magang
- Laporan dalam format terstruktur

### 📈 Dashboard
- Statistik jumlah peserta
- Status magang real-time
- Tampilan ringkas & informatif

---

## 🧰 Teknologi yang Digunakan

| Komponen | Teknologi |
|--------|----------|
| Backend | **Laravel (PHP Framework)** |
| Frontend | Blade Template, HTML, CSS, JavaScript |
| Database | MySQL |
| ORM | Eloquent |
| Auth | Laravel Authentication |
| Package Manager | Composer, NPM |

---

## 🧱 Arsitektur Sistem

- Menggunakan pola **MVC (Model–View–Controller)**
- Routing terpisah dan terstruktur
- Database relasional
- Validasi data di sisi backend

---

## 📂 Struktur Direktori
```
SI-MAGANG/
├── app/ # Logic utama aplikasi
│ ├── Models/
│ ├── Http/
│ └── Controllers/
├── bootstrap/
├── config/
├── database/
│ ├── migrations/
│ └── seeders/
├── public/
├── resources/
│ ├── views/
│ ├── css/
│ └── js/
├── routes/
│ └── web.php
├── storage/
├── tests/
├── .env.example
└── artisan
```

## 🚀 Instalasi & Menjalankan Aplikasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/HazelnutDev/SI-MAGANG.git
cd SI-MAGANG
```

### 2️⃣ Install Dependency
```
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
```
### 3️⃣ Konfigurasi Environment
```
Sesuaikan konfigurasi database di file .env:
DB_DATABASE=si_magang
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Migrasi Database
```
php artisan migrate --seed
```
### 5️⃣ Jalankan Server
```
php artisan serve
```

Akses aplikasi di:
```
http://127.0.0.1:8000
```

## 📌 Status Pengembangan
```
🟡 Development / Academic Project
Masih dapat dikembangkan lebih lanjut:

Export PDF

Notifikasi email

Multi-periode magang

API integration
```

### 📜 Lisensi
```
Proyek ini menggunakan lisensi MIT License
Bebas digunakan untuk pembelajaran, pengembangan, dan modifikasi.
```

### 🙌 Penutup
```
SI-MAGANG dibuat untuk menjadi solusi praktis, rapi, dan scalable dalam pengelolaan program magang.
Cocok untuk tugas akhir, portfolio, maupun sistem internal organisasi.

Kalau kamu suka, jangan lupa ⭐ repository ini!
```
### 🔥 Happy coding & keep building!
```
Kalau mau next level:
- ✅ Tambahin **badge (Laravel, PHP, License)**
- ✅ Versi **README Bahasa Inggris**
- ✅ Diagram **ERD / Flow Sistem**
- ✅ Screenshot UI mockup
```
