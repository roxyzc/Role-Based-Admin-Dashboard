# Role Based Admin Dashboard
Role Based Admin Dashboard adalah platform manajemen akses berbasis peran yang dirancang untuk mengatur hak akses pengguna sekaligus memantau aktivitas, kinerja, beban kerja, dan waktu idle. Produk ini bertujuan meningkatkan keamanan sistem, efisiensi kerja tim, dan mendukung pengambilan keputusan berbasis data, sekaligus memastikan kepatuhan terhadap kebijakan keamanan.

## Tujuan Utama:
1.	Mengelola akses secara ketat berdasarkan peran untuk meningkatkan keamanan.
2.	Memantau aktivitas pengguna untuk mendukung audit dan pengawasan.
3.	Mengukur kinerja individu dan tim demi pengembangan sumber daya manusia (SDM).
4.	Mengelola beban kerja dan waktu idle guna meningkatkan produktivitas.
   
## Fitur Utama:
1. **Manajemen Akses Berbasis Peran:**  
   Kemudahan mengatur, menambah, dan menghapus peran pengguna dengan hak akses yang disesuaikan.
2. **Monitoring Aktivitas Pengguna:**  
   Log aktivitas real-time, termasuk perubahan pada data sensitif.
3. **Pengukuran Kinerja:**  
   Analitik KPI, grafik kinerja, dan laporan perbandingan individu-tim.
4. **Pemantauan Beban Kerja dan Idle Time:**  
   Monitoring distribusi tugas dan pencatatan waktu idle.
5. **Laporan dan Analitik:**  
   Laporan aktivitas, kinerja, dan tren penggunaan untuk pengambilan keputusan strategis.
    
## Target Pengguna:
Organisasi dengan kebutuhan manajemen akses, termasuk perusahaan IT, lembaga pemerintahan, institusi pendidikan, serta manajer yang ingin meningkatkan produktivitas tim.

## Keuntungan Pengguna:
1.	Pengelolaan akses yang aman dan efisien.
2.	Pemahaman mendalam tentang kinerja tim untuk pengambilan keputusan.
3.	Peningkatan produktivitas melalui pengurangan waktu idle.
4.	Wawasan strategis dari laporan kinerja dan aktivitas.

## Panduan instalasi projek:
## -	Instalasi langsung dengan Laravel:
1.	Pastikan anda sudah menginstall git, php versi 7.4.33, MySQL, phpMyAdmin, dan composer.
2.	Buat folder baru.
3.	Masuk ke dalam folder baru yang telah dibuat.
4.	Clone repository proyek dengan menjalankan perintah “git clone https://github.com/roxyzc/Role-Based-Admin-Dashboard.git”.
5.	Masuk ke direktori projek yang baru di clone.
6.	Jalankan perintah composer install.
7.	Buat database baru di phpmyadmin.
8.	Ubah file .env.example menjadi .env kemudian masukkan konfigurasi database anda. 
9.	Jalankan perintah php artisan key:generate.
10.	Jalankan perintah php artisan storage:link.
11.	Jalankan perintah php artisan migrate.
12.	Jalankan perintah php artisan db:seed.
13.	Terakhir, jalankan proyek dengan perintah php artisan serve.

## -	Instalasi dengan laragon
1.	Pastikan anda sudah menginstall git, php versi 7.4.33 dan composer.
2.	masuk ke dalam folder laragon, kemudian folder www, dan buat folder baru di dalam folder www tersebut.
3.	Masuk ke aplikasi laragon, kemudian start all, lalu masuk ke terminal.
4.	Clone repository proyek dengan menjalankan perintah “git clone https://github.com/roxyzc/Role-Based-Admin-Dashboard.git”.
5.	Masuk ke direktori projek yang baru di clone. 
6.	Jalankan perintah composer install.
7.	Buka phpMyAdmin melalui Laragon untuk membuat database baru.
8.	Ubah file .env.example menjadi .env kemudian masukkan konfigurasi database anda. 
9.	Jalankan perintah php artisan key:generate.
10.	Jalankan perintah php artisan storage:link.
11.	Jalankan perintah php artisan migrate.
12.	Jalankan perintah php artisan db:seed.
13.	Terakhir, jalankan proyek dengan perintah php artisan serve.

