# Website Portofolio Pribadi Dinamis dengan PHP & Admin Panel

Ini adalah proyek website portofolio pribadi yang dibangun dari awal menggunakan PHP native dan database MySQL. Proyek ini dirancang untuk menampilkan profil, keahlian, riwayat pendidikan, pengalaman, hingga proyek yang pernah dikerjakan. Seluruh konten di website ini bersifat dinamis dan dapat dikelola sepenuhnya melalui panel admin yang fungsional dan aman.

![Tampilan Website Portofolio](https://i.imgur.com/image_99c0dc.png)

## 🌟 Fitur Utama

### Website Publik (Frontend)
* **Desain Modern & Responsif:** Tampilan tema gelap yang elegan dan dapat menyesuaikan diri dengan baik di perangkat desktop maupun mobile.
* **Animasi Scroll:** Efek animasi *fade-in* dan *slide-up* saat pengunjung scroll halaman, memberikan pengalaman pengguna yang lebih hidup.
* **Navigasi Canggih:** Dilengkapi menu dropdown dan fitur *active state* yang menandai halaman atau bagian yang sedang dilihat.
* **Konten Dinamis:** Semua bagian seperti bio, keahlian, proyek, riwayat pendidikan, pengalaman, organisasi, artikel, dan layanan diambil langsung dari database.
* **Halaman Detail:** Pengunjung bisa mengklik "Read More" pada artikel untuk melihat isinya secara penuh di halaman terpisah.
* **Formulir Kontak:** Formulir kontak fungsional yang akan menyimpan pesan dari pengunjung langsung ke database.

### Panel Admin (Backend)
* **Dashboard Informatif:** Halaman utama admin yang menampilkan ringkasan statistik konten website (jumlah proyek, artikel, dll.) dan daftar aktivitas terbaru.
* **Keamanan Sesi:** Dilengkapi sistem keamanan dengan *session timeout*, yang akan otomatis logout jika tidak ada aktivitas selama periode tertentu.
* **Manajemen Konten (CRUD):**
    * **Pengaturan Umum:** Mengubah nama, tagline, bio, dan foto profil.
    * **Kelola Riwayat:** Menambah, mengedit, dan menghapus data Pendidikan, Pengalaman, dan Organisasi dalam satu halaman terpadu.
    * **Kelola Keahlian:** Menambah, mengedit, dan menghapus daftar keahlian, lengkap dengan pilihan ikon dari Font Awesome.
    * **Kelola Proyek:** Manajemen proyek penuh, termasuk fungsionalitas untuk upload gambar proyek.
    * **Kelola Artikel & Layanan:** Manajemen penuh untuk konten artikel dan layanan yang ditawarkan.
    * **Manajemen User:** Mengelola akun yang dapat mengakses panel admin.
* **Antarmuka Interaktif:** Sebagian besar form manajemen menggunakan toggle "Add New" untuk menjaga antarmuka tetap bersih dan rapi.

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP Native
* **Database:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3 (dengan Flexbox & Grid), JavaScript (ES6)
* **Lingkungan Pengembangan:** XAMPP (Apache, MySQL, PHP)

## 🚀 Cara Instalasi & Menjalankan Proyek

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/](https://github.com/)[username-github-anda]/[nama-repository-anda].git
    ```
2.  **Setup Database**
    * Buka **phpMyAdmin**.
    * Buat database baru dengan nama `db_portofolio`.
    * Pilih database tersebut, lalu buka tab **SQL**.
    * Salin seluruh isi dari file `db_portofolio.sql` dan jalankan.

3.  **Konfigurasi Koneksi**
    * Buka file `includes/db.php`.
    * Sesuaikan pengaturan `$db_host`, `$db_user`, `$db_pass`, dan `$db_name` jika berbeda dari pengaturan XAMPP default Anda.

4.  **Pindahkan Folder Proyek**
    * Pindahkan seluruh folder proyek ke dalam direktori `htdocs` di dalam instalasi XAMPP Anda (contoh: `C:\xampp\htdocs\portfolio`).

5.  **Jalankan Server**
    * Buka XAMPP Control Panel dan jalankan service **Apache** dan **MySQL**.

6.  **Akses Website**
    * **Website Publik:** Buka browser dan akses `http://localhost/portfolio/`
    * **Panel Admin:** Akses `http://localhost/portfolio/admin/`
        * **Username:** `hermawan`
        * **Password:** `hermawan_01`

## Kontributor Utama

* **[NAMA ANDA]** - [JURUSAN ANDA]
    * GitHub: [@Hermawan-TI](https://github.com/Hermawan-TI)
    * LinkedIn: [Hermawan](https://www.linkedin.com/in/hermawan-0a3a03357/)

Proyek ini dibuat sebagai bagian dari pemenuhan tugas Ujian Akhir Semester (UAS).
