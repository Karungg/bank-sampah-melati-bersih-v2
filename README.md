# Project Bank Sampah melati Bersih Atsiri Permai RW012

## Deskripsi

Website BSMB Atisiri Permai ini merupakan hibah dari Direktorat Riset, Teknologi, dan Pengabdian kepada Masyarakat (DRTPM) Tahun Anggaran 2024, Direktorat Jenderal Pendidikan Tinggi, Riset, dan Teknologi, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia. Project ini adalah versi yang dikembangkan dari sebelumnya dimana menggunakan teknologi yang lebih modern serta menerapkan standar industri seperti clean code, service pattern, logging, dan unit test.

## 🛠️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal:

1. **Clone repository**
```bash
git clone https://github.com/Karungg/bank-sampah-melati-bersih-v2.git
cd bank-sampah-melati-bersih-v2
```
2. Install dependencies menggunakan composer
```
composer install
```
3. Install dependencies menggunakan NPM
```
npm install
```
4. Copy .emv
```
cp .env.example .env
```
5. Sesuaikan konfigurasi pada file .env
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
6. Jalankan migrasi dan seeder
```
php artisan migrate
php artisan db:seed
```
7. Jalankan aplikasi
```
php artisan serve
php artisan npm run dev
php artisan queue:work
```
