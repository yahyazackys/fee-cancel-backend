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

3. **Buat File .env**

   ```bash
   APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:w/OtJxX2gQdSGGYovr/2zizQNzOhnKXzVVHLBtCOhP4=
    APP_DEBUG=true
    APP_URL=http://localhost
    
    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug
    
    DB_CONNECTION=firebase
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=root
    DB_PASSWORD=
    
    FIREBASE_CREDENTIALS="fee-cancel-3dc0a-firebase-adminsdk-2hn37-24d10e52ca.json"
    FIREBASE_DATABASE_URL="https://fee-cancel-3dc0a-default-rtdb.firebaseio.com/"
    
    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120
    
    MEMCACHED_HOST=127.0.0.1
    
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    MAIL_MAILER=smtp
    MAIL_HOST=mailpit
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false
    
    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=mt1
    
    VITE_APP_NAME="${APP_NAME}"
    VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    VITE_PUSHER_HOST="${PUSHER_HOST}"
    VITE_PUSHER_PORT="${PUSHER_PORT}"
    VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
    VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    
    FILESYSTEM_DRIVER = public

   
   
4. **Konfigurasi Firebase (Jika tidak belum ada kredensial JSON di root proyek)**

- **Unduh Kredensial Firebase:** Unduh file kredensial JSON dari Firebase Console dan simpan di direktori root proyek.
- **Tambahkan Kredensial ke .env:** Tambahkan konfigurasi berikut ke file.

   ```bash
   FIREBASE_CREDENTIALS="path/to/your/firebase-credentials.json"
   FIREBASE_DATABASE_URL="https://your-firebase-database-url.firebaseio.com/"
   
5. **Jalankan Website**

   ```bash
   php artisan serve
