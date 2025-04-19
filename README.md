# Project Bank Sampah melati Bersih Atsiri Permai RW012

## Deskripsi

Website BSMB Atisiri Permai ini merupakan hibah dari Direktorat Riset, Teknologi, dan Pengabdian kepada Masyarakat (DRTPM) Tahun Anggaran 2024, Direktorat Jenderal Pendidikan Tinggi, Riset, dan Teknologi, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia. Project ini adalah versi yang dikembangkan dari sebelumnya dimana menggunakan teknologi yang lebih modern serta menerapkan standar industri seperti clean code, service pattern, logging, dan unit test.

## Fitur Utama Berdasarkan Role (Admin, Pengurus, Nasabah)
1. **Admin**
    - Manajemen kategori sampah
    - Manajemen admin, pengurus dan nasabah
    - Manajemen kategori kegiatan
    - Manajemen kegiatan
    - Manajemen hasil olahan sampah
    - Manajemen rekening
    - Membuat transaksi penimbangan sampah
    - Membuat transaksi penjualan sampah
    - Membuat transaksi penarikan uang
    - Membuat transaksi pembayaran lapak
    - Manajemen laporan nasabah
    - Manajemen laporan penimbangan
    - Manajemen laporan penjualan
    - Manajemen laporan laba rugi
    - Manajemen data profil bank sampah
2. **Pengurus**
    - Manajemen nasabah
    - Membuat transaksi penimbangan sampah
    - Membuat transaksi penjualan sampah
    - Membuat transaksi penarikan uang
    - Membuat transaksi pembayaran lapak
    - Manajemen laporan nasabah
    - Manajemen laporan penimbangan
    - Manajemen laporan penjualan
    - Manajemen laporan laba rugi
3. **Nasabah**
    - Melihat transaksi yang pernah dilakukan

## 🛠️ Techstack
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![Livewire](https://img.shields.io/badge/livewire-%234e56a6.svg?style=for-the-badge&logo=livewire&logoColor=white) ![Alpine.js](https://img.shields.io/badge/alpinejs-white.svg?style=for-the-badge&logo=alpinedotjs&logoColor=%238BC0D0) ![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white) ![Filament](https://img.shields.io/badge/Filament-FFAA00?style=for-the-badge&logoColor=%23000000) ![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white) ![NPM](https://img.shields.io/badge/NPM-%23CB3837.svg?style=for-the-badge&logo=npm&logoColor=white) ![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white) ![Redis](https://img.shields.io/badge/redis-%23DD0031.svg?style=for-the-badge&logo=redis&logoColor=white)

## 🛠️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal:

1. **Clone repository**
```bash
git clone https://github.com/Karungg/bank-sampah-melati-bersih-v2.git
cd bank-sampah-melati-bersih-v2
```
2. **Install dependensi menggunakan composer**
```
composer install
```
3. **Install dependensi menggunakan NPM**
```
npm install
```
4. **Copy .env**
```
cp .env.example .env
```
5. **Ubah konfigurasi pada file .env sesuai kebutuhan**
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
6. **Jalankan migrasi dan seeder**
```
php artisan migrate
php artisan db:seed
```
7. **Jalankan aplikasi, NPM, dan Queue**
```
php artisan serve
php artisan npm run dev
php artisan queue:work
```
Buka aplikasi di browser <a href="http://localhost/">http://localhost/</a>

## 🐳 Instalasi Menggunakan Docker
1. **Clone repository**
```bash
git clone https://github.com/Karungg/bank-sampah-melati-bersih-v2.git
cd bank-sampah-melati-bersih-v2
```
2. **Install dependensi menggunakan composer**
```
composer install
```
3. **Install dependensi menggunakan NPM**
```
npm install
```
4. **Copy .env**
```
cp .env.example .env
```
5. **Ubah konfigurasi pada file .env sesuai kebutuhan**
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
6. Build aplikasi
```
sail build #jika menggunakan docker sail
docker compose up #jika menggunakan docker compose

```
8. **Jalankan migrasi dan seeder**
```
sail artisan migrate
sail artisan db:seed
```
9. **Jalankan NPM dan Queue**
```
sail artisan npm run dev
sail artisan queue:work
```
Buka aplikasi di browser <a href="http://localhost/">http://localhost/</a>

Aplikasi ini dilengkapi dengan beberapa unit dan feature test untuk memastikan setiap fitur berjalan dengan baik.

📦 Menjalankan semua test
```
php artisan test #jika tidak menggunakan docker
sail test #jika menggunakan docker sail
```

👨‍💻 Developer
Created with ❤️ by <a href="https://github.com/Karungg">Karungg</a>

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](<a href="https://github.com/Karungg/bank-sampah-melati-bersih-v2?tab=MIT-1-ov-file">LICENSE</a>).
