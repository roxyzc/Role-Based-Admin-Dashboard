<div align="center">
  <a href="https://tiket-id.vercel.app" target="_blank">
    <img src="/public/images/tracking.id.png" alt="Logo" width="300">
  </a>
  <h2 align="center"><strong>Role Based Admin Dashboard</strong></h2>
  <p align="center">
    <a href="https://github.com/roxyzc/Role-Based-Admin-Dashboard/issues">Report Bug</a>
    &middot;
    <a href="https://github.com/roxyzc/Role-Based-Admin-Dashboard/issues">Request Feature</a>
  </p>
</div>

## Tentang Projek
Role Based Admin Dashboard adalah platform manajemen akses berbasis peran yang dirancang untuk:
- Mengatur hak akses pengguna.
- Memantau aktivitas, kinerja, beban kerja, dan waktu idle.

Dashboard ini bertujuan untuk meningkatkan keamanan sistem, efisiensi kerja tim, mendukung pengambilan keputusan berbasis data, serta memastikan kepatuhan terhadap kebijakan keamanan.

---

## Tujuan Utama
1. Mengelola akses secara ketat berdasarkan peran untuk meningkatkan keamanan.
2. Memantau aktivitas pengguna guna mendukung audit dan pengawasan.
3. Mengukur kinerja individu dan tim demi pengembangan sumber daya manusia (SDM).
4. Mengelola beban kerja dan waktu idle untuk meningkatkan produktivitas.

---

## Fitur Utama
1. **Manajemen Akses Berbasis Peran**  
   Mengatur, menambah, dan menghapus peran pengguna dengan hak akses yang disesuaikan.
2. **Monitoring Aktivitas Pengguna**  
   Log aktivitas real-time, termasuk perubahan pada data sensitif.
3. **Pengukuran Kinerja**  
   Analitik KPI, grafik kinerja, dan laporan perbandingan individu-tim.
4. **Pemantauan Beban Kerja dan Idle Time**  
   Monitoring distribusi tugas dan pencatatan waktu idle.
5. **Laporan dan Analitik**  
   Laporan aktivitas, kinerja, dan tren penggunaan untuk mendukung pengambilan keputusan strategis.

---

## Target Pengguna
Organisasi yang membutuhkan manajemen akses, termasuk:
1. Perusahaan IT.
2. Lembaga pemerintahan.
3. Institusi pendidikan.
4. Manajer yang ingin meningkatkan produktivitas tim.

---

## Keuntungan Pengguna
1. Pengelolaan akses yang aman dan efisien.
2. Pemahaman mendalam tentang kinerja tim untuk pengambilan keputusan.
3. Peningkatan produktivitas melalui pengurangan waktu idle.
4. Wawasan strategis dari laporan kinerja dan aktivitas.

---

## Panduan Instalasi Projek

### Instalasi dengan Laravel
1. Pastikan Anda sudah menginstall **Git**, **PHP versi 7.4.33**, **MySQL**, **phpMyAdmin**, dan **Composer**.
2. Buat folder baru dan masuk ke dalam folder tersebut.
3. Clone repository proyek:
   ```bash
   git clone https://github.com/roxyzc/Role-Based-Admin-Dashboard.git
   ```
4. Masuk ke direktori proyek:
   ```bash
   cd Role-Based-Admin-Dashboard
   ```
5. Jalankan perintah:
   ```bash
   composer install
   ```
6. Buat database baru di phpMyAdmin.
7. Ubah nama file `.env.example` menjadi `.env`, lalu masukkan konfigurasi database Anda.
8. Masukkan detail konfigurasi database Anda ke dalam file `.env`
9. Jalankan perintah berikut secara berurutan:
   ```bash
   php artisan key:generate
   php artisan storage:link
   php artisan migrate
   php artisan db:seed
   php artisan serve
   ```

### Instalasi dengan Laragon
1. Pastikan Anda sudah menginstall **Laragon**, **Git**, **PHP versi 7.4.33**, **MySQL**, **phpMyAdmin**, dan **Composer**.
2. Masuk ke folder `www` di dalam direktori Laragon, lalu buat folder baru.
3. Buka terminal di aplikasi Laragon dan jalankan perintah:
   ```bash
   git clone https://github.com/roxyzc/Role-Based-Admin-Dashboard.git
   ```
4. Masuk ke direktori proyek:
   ```bash
   cd Role-Based-Admin-Dashboard
   ```
5. Jalankan perintah:
   ```bash
   composer install
   ```
6. Buka phpMyAdmin melalui Laragon untuk membuat database baru.
7. Ubah nama file `.env.example` menjadi `.env`, lalu masukkan konfigurasi database Anda.
8. Jalankan perintah berikut secara berurutan:
   ```bash
   php artisan key:generate
   php artisan storage:link
   php artisan migrate
   php artisan db:seed
   php artisan serve
