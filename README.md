# 🚀 Laravel 12 Project – Nama Project

Ini adalah panduan untuk melakukan setup proyek Laravel 12 dari awal sampai siap dijalankan.

---

## 📦 Requirements

Pastikan sistem kamu sudah memenuhi persyaratan di bawah ini sebelum memulai:

-   **PHP** >= 8.2
-   **Composer** >= 2.x
-   **MySQL**

---

## ⚙️ Setup Project

Ikuti langkah-langkah di bawah ini secara berurutan untuk menjalankan proyek:

# Clone repo

git clone [link-repo-backend]
cd backend

# Install dependency

composer install
npm install (optional)

# Copy file environment

cp .env.example .env

# Generate key

php artisan key:generate

# Migrasi database

php artisan migrate

# Seeder All Model (Pelanggan, Barang, Penjualan)

php artisan db:seed --class=PelangganSeeder
php artisan db:seed --class=BarangSeeder
php artisan db:seed --class=PenjualanSeeder

# Jalankan server

php artisan serve
