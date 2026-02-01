# CountryShelf - Aplikasi Koleksi Negara Favorit

## Deskripsi
CountryShelf adalah aplikasi web berbasis Laravel yang digunakan untuk menampilkan data negara di dunia dari Public API dan memungkinkan pengguna menyimpan negara favorit mereka ke dalam database lokal beserta catatan pribadi.

Aplikasi ini dirancang sebagai aplikasi multi-user, di mana setiap pengguna memiliki akun sendiri dan hanya dapat mengelola data favorit miliknya.

## Teknologi yang Digunakan
- Framework: Laravel
- Bahasa Pemrograman: PHP
- Database: SQLite
- Frontend: Blade Template + Bootstrap
- Autentikasi: Laravel Session
- API Client: Laravel HTTP Client
- Version Control: Git & GitHub

## Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js dan npm
- Web server (Apache/Nginx) opsional

### Langkah-langkah Instalasi

1. Clone repositori ini:
```bash
git clone <repository-url>
cd CountryShelf
```

2. Install dependensi PHP:
```bash
composer install
```

3. Copy file `.env.example` menjadi `.env` dan sesuaikan konfigurasi:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Buat database SQLite (jika menggunakan SQLite):
```bash
touch database/database.sqlite
```

6. Jalankan migrasi database:
```bash
php artisan migrate
```

7. Install dependensi Node.js:
```bash
npm install
```

8. Build asset:
```bash
npm run build
```

9. Jalankan aplikasi:
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

## Fitur-fitur

1. **Autentikasi Pengguna (Multi-User)**
   - Registrasi dan login pengguna
   - Logout pengguna
   - Keamanan password

2. **Pengambilan Data dari Public API**
   - Menampilkan daftar negara dari REST Countries API
   - Pencarian negara berdasarkan nama

3. **Manajemen Data Favorit (CRUD Lokal)**
   - Menyimpan negara favorit
   - Melihat daftar favorit
   - Mengedit catatan pribadi
   - Menghapus data favorit

4. **Isolasi Data**
   - Data favorit milik satu pengguna tidak bisa diakses pengguna lain
   - Setiap operasi CRUD dibatasi berdasarkan user_id

## Cara Penggunaan

1. Register akun baru atau login jika sudah memiliki akun
2. Kunjungi halaman dashboard untuk melihat daftar semua negara
3. Gunakan fitur pencarian untuk mencari negara tertentu
4. Klik tombol "Add to Favorites" untuk menyimpan negara ke koleksi Anda
5. Kunjungi halaman "My Favorites" untuk melihat, mengedit, atau menghapus negara favorit Anda
6. Tambahkan catatan pribadi untuk setiap negara favorit

## Struktur Database

### Tabel: users
- id
- name
- email
- password
- timestamps

### Tabel: favorites
- id
- user_id (foreign key ke users)
- country_name
- capital
- region
- population
- note
- timestamps

## Sumber Data API

Aplikasi ini menggunakan REST Countries API:
- Endpoint: https://restcountries.com/v3.1/all (untuk semua negara)
- Endpoint: https://restcountries.com/v3.1/name/{countryName} (untuk pencarian)

## Kontribusi

Jika ingin berkontribusi pada proyek ini, silakan fork repositori ini dan buat pull request.

## Lisensi

Proyek ini dilisensikan di bawah lisensi MIT.

## Informasi Kontak

Nama: [Nama Mahasiswa]
NIM: [Nomor Induk Mahasiswa]