# Fee Cancel Backend

Ini adalah backend API yang dibangun dengan Laravel untuk mengelola data fee cancel. Backend ini berfungsi sebagai API untuk aplikasi web yang dibangun dengan Next.js.

## Fitur

- **API Endpoint CRUD:** Menyediakan endpoint untuk Create, Read, Update, dan Delete data fee cancel menggunakan Firebase.
- **Autentikasi:** Menggunakan Firebase untuk autentikasi pengguna.
- **Integrasi Firebase:** Mengelola data dan autentikasi pengguna melalui Firebase.

## Prerequisites

Sebelum memulai, pastikan kamu telah menginstal:

- [PHP](https://www.php.net/) (versi 8.0 atau lebih baru)
- [Composer](https://getcomposer.org/) (untuk mengelola dependensi PHP)
- [Firebase](https://firebase.google.com/)

## Instalasi

Ikuti langkah-langkah berikut untuk menyiapkan proyek:

1. **Clone Repository**

   ```bash
   git clone https://github.com/yahyazackys/fee-cancel-backend.git
   cd fee-cancel-backend

2. **Install Dependensi**

   ```bash
   composer install
   
3. **Konfigurasi Firebase**

- **Unduh Kredensial Firebase:** Unduh file kredensial JSON dari Firebase Console dan simpan di direktori root proyek.
- **Tambahkan Kredensial ke .env:** Tambahkan konfigurasi berikut ke file.

   ```bash
   FIREBASE_CREDENTIALS="path/to/your/firebase-credentials.json"
   FIREBASE_DATABASE_URL="https://your-firebase-database-url.firebaseio.com/"
   
4. **Jalankan Website**

   ```bash
   php artisan serve
