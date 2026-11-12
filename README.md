# Sistem Presensi

------------------------------------------------------------------------

## 1. Penjelasan Website

Website ini memiliki dua jenis pengguna, yaitu **Admin** dan **User
(Pegawai)**. Setiap role memiliki hak akses dan fitur yang berbeda.

### Fitur Admin

Admin bertanggung jawab untuk mengelola dan memantau aktivitas presensi
seluruh pegawai.

Fitur yang tersedia:

-   **Dashboard:** Melihat ringkasan dan seluruh data presensi pegawai.
-   **Data Presensi:** Melihat, memfilter, mengurutkan, dan mengelola
    data kehadiran pegawai.
-   **Pengajuan:** Melihat pengajuan izin dan sakit dari pegawai.
-   **Persetujuan Pengajuan:** Menerima atau menolak pengajuan izin dan
    sakit.
-   **Laporan:** Mengekspor data presensi ke dalam format PDF dan Excel.
-   **Notifikasi:** Melihat informasi pengajuan yang masih menunggu
    persetujuan.

### Fitur User (Pegawai)

User merupakan pegawai yang menggunakan sistem untuk mencatat dan
memantau kehadirannya sendiri.

Fitur yang tersedia:

-   **Dashboard:** Melihat ringkasan dan riwayat presensi pribadi.
-   **Presensi Masuk:** Mencatat waktu kedatangan.
-   **Presensi Pulang:** Mencatat waktu kepulangan.
-   **Pengajuan Izin dan Sakit:** Mengajukan izin atau sakit disertai
    alasan dan bukti pendukung.
-   **Riwayat Pengajuan:** Melihat status pengajuan yang pernah dibuat
    dan membatalkan pengajuan yang masih pending.
-   **Laporan:** Mengekspor riwayat presensi pribadi ke dalam format PDF
    dan Excel.

### Ketentuan Presensi

-   **Batas presensi masuk:** Pukul 07.30 WIB.
-   **Presensi terlambat:** Setelah pukul 07.30 WIB.
-   **Waktu acuan presensi pulang:** Pukul 17.00 WIB.
-   **Presensi masuk:** Hanya dapat dilakukan satu kali dalam sehari.
-   **Presensi pulang:** Hanya dapat dilakukan setelah presensi masuk.
-   **Pengajuan izin/sakit:** Dapat diajukan melalui halaman Presensi.

Status kehadiran yang digunakan:

-   **Hadir:** Pegawai melakukan presensi masuk paling lambat pukul
    07.30 WIB.
-   **Terlambat:** Pegawai melakukan presensi masuk setelah pukul 07.30
    WIB.
-   **Sakit:** Pegawai memiliki pengajuan sakit yang telah diterima.
-   **Izin:** Pegawai memiliki pengajuan izin yang telah diterima.

------------------------------------------------------------------------

## 2. Cara Setup dan Instalasi

Sistem ini menggunakan Laravel versi 13.

### A. Clone Repository

Jalankan perintah berikut untuk mengunduh kode dari GitHub ke laptop/PC:

``` bash
git clone https://github.com/Imshof13/presensi_bappeda.git
cd presensi_bappeda
```

### B. Install Dependency Laravel

Jalankan Composer untuk menginstal seluruh dependency PHP:

composer install

**Catatan dependency:**

-   Carbon digunakan untuk pengolahan tanggal dan waktu. Pada Laravel,
    Carbon umumnya sudah tersedia melalui dependency bawaan sehingga
    tidak perlu diinstal secara terpisah.
-   Jika dependency ekspor Excel belum tersedia, jalankan:

``` bash
composer require maatwebsite/excel
```

-   Jika dependency ekspor PDF belum tersedia, jalankan:

``` bash
composer require barryvdh/laravel-dompdf
```

### C. Konfigurasi Environment

Buat file `.env` berdasarkan file contoh:

``` bash
cp .env.example .env
```

Untuk Windows Command Prompt, gunakan:

``` cmd
copy .env.example .env
```

Generate application key:

``` bash
php artisan key:generate
```

### D. Konfigurasi Database

Buat database baru melalui MySQL atau phpMyAdmin. Setelah itu, sesuaikan
konfigurasi database pada file `.env`:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan
konfigurasi MySQL pada perangkat masing-masing.

### E. Migrasi Database dan Seeder

Jalankan migrasi untuk membuat tabel database:

``` bash
php artisan migrate
```

Kemudian jalankan seeder untuk membuat akun demo:

``` bash
php artisan db:seed
```

Jika ingin membuat ulang seluruh tabel sekaligus mengisi data awal,
gunakan:

``` bash
php artisan migrate:fresh --seed
```

**Perhatian:** Perintah `migrate:fresh --seed` akan menghapus seluruh
tabel beserta data yang sudah tersimpan, kemudian membuatnya kembali.

### F. Storage Link

Aplikasi menggunakan penyimpanan file untuk bukti pendukung pengajuan
izin atau sakit.

Jalankan:

``` bash
php artisan storage:link
```

### G. Install Dependency Frontend

Install dependency frontend dan jalankan proses build:

``` bash
npm install
npm run build
```

### H. Jalankan Website

Setelah seluruh langkah selesai, jalankan:

``` bash
php artisan serve
```

Buka browser dan akses:

<http://127.0.0.1:8000>

------------------------------------------------------------------------

## 3. Alur Penggunaan Website

### A. Alur Admin

1.  Admin login menggunakan akun dengan role Admin.
2.  Admin masuk ke halaman Dashboard.
3.  Admin dapat melihat ringkasan jumlah kehadiran pegawai.
4.  Admin dapat melihat dan memfilter data presensi berdasarkan tanggal,
    bulan, tahun, status, atau pencarian.
5.  Admin membuka halaman Presensi untuk melihat pengajuan izin dan
    sakit dari pegawai.
6.  Admin memeriksa alasan dan bukti pengajuan.
7.  Admin dapat menerima atau menolak pengajuan.
8.  Admin dapat mengekspor laporan presensi ke format PDF atau Excel.

### B. Alur User (Pegawai)

1.  User login menggunakan akun pegawai.
2.  User masuk ke halaman Dashboard untuk melihat ringkasan dan riwayat
    presensi pribadi.
3.  User membuka halaman Presensi.
4.  User melakukan presensi masuk ketika mulai bekerja.
5.  Setelah selesai bekerja, user melakukan presensi pulang.
6.  Sistem mencatat waktu presensi dan menentukan status kehadiran.
7.  Jika tidak dapat hadir karena sakit atau izin, user dapat mengirim
    pengajuan melalui halaman Presensi.
8.  User mengisi jenis pengajuan, alasan, dan mengunggah bukti pendukung
    jika diperlukan.
9.  User dapat melihat perkembangan status pengajuan melalui Riwayat
    Pengajuan.
10. User dapat mengunduh laporan presensi pribadi dalam format PDF atau
    Excel.

### C. Alur Pengajuan Izin dan Sakit

Pengajuan memiliki tiga status:

-   **Pending:** Pengajuan sedang menunggu pemeriksaan admin.
-   **Diterima:** Pengajuan telah disetujui admin.
-   **Ditolak:** Pengajuan tidak disetujui admin.

Alur pengajuan:

User mengirim pengajuan -> Status: Pending -> Admin memeriksa -> Diterima/Ditolak

Pengajuan yang masih berstatus pending dapat dibatalkan oleh user.
Pengajuan yang masih pending atau sudah diterima juga menjadi dasar
pembatasan presensi pada tanggal pengajuan tersebut.

------------------------------------------------------------------------

## 4. Akun yang Disediakan

Aplikasi menyediakan empat akun demo untuk mencoba fitur berdasarkan
role masing-masing.

**Password seluruh akun demo: `password`**

-   **Username:** `admin`\
    **Role:** Admin\
    **Password:** `password`

-   **Username:** `imshof`\
    **Role:** User\
    **Password:** `password`

-   **Username:** `yuslih`\
    **Role:** User\
    **Password:** `password`

-   **Username:** `rahmat`\
    **Role:** User\
    **Password:** `password`

### Penggunaan Akun

-   **admin:** Digunakan untuk mencoba dashboard admin, pengelolaan
    presensi seluruh pegawai, persetujuan pengajuan, serta ekspor
    laporan.
-   **imshof:** Digunakan untuk mencoba fitur presensi dan pengajuan
    sebagai pegawai.
-   **yuslih:** Digunakan untuk mencoba fitur presensi dan pengajuan
    sebagai pegawai.
-   **rahmat:** Digunakan untuk mencoba fitur presensi dan pengajuan
    sebagai pegawai.

**Catatan:** Akun demo dibuat melalui database seeder. Jika akun tidak
muncul setelah migrasi, pastikan sudah menjalankan
`php artisan db:seed`.

------------------------------------------------------------------------

## Teknologi yang Digunakan

-   **Backend:** Laravel 13, PHP.
-   **Database:** MySQL.
-   **Date & Time:** Carbon.
-   **Export Excel:** Laravel Excel (Maatwebsite).
-   **Export PDF:** DomPDF.
-   **Frontend:** Blade, HTML, CSS, JavaScript.
-   **Dependency Manager:** Composer, NPM.
