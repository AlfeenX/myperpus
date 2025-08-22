# 📚 LibAdmin

LibAdmin adalah aplikasi manajemen perpustakaan berbasis **Laravel** dengan dukungan **FilamentPHP** sebagai admin panel dan **MySQL** sebagai database.  
Proyek ini dijalankan menggunakan **Laravel Sail** (Docker-based dev environment).

---

## 🚀 Fitur
- Autentikasi pengguna
- Dashboard admin berbasis **FilamentPHP**
- Manajemen data anggota, buku, dan transaksi peminjaman
- Terintegrasi dengan **MySQL**
- Development environment menggunakan **Laravel Sail**

---

## 🛠️ Teknologi
- [Laravel 11.x](https://laravel.com)
- [FilamentPHP](https://filamentphp.com)
- [MySQL 8](https://www.mysql.com)
- [Laravel Sail](https://laravel.com/docs/sail) (Docker)

---

## 📂 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/libadmin.git
cd libadmin
```

### 2. Copy .env
```bash
cp .env.example .env
```

### 3. Install Dependencies (Composer)
```bash
docker run --rm     -u "$(id -u):$(id -g)"     -v $(pwd):/var/www/html     -w /var/www/html     laravelsail/php84-composer:latest     composer install
```

### 4. Jalankan Sail (Docker)
```bash
./vendor/bin/sail up -d
```

### 5. Install Dependencies Frontend
```bash
./vendor/bin/sail npm install && ./vendor/bin/sail npm run dev
```

### 6. Generate Key & Migrasi Database
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

---

## 🖥️ Akses Aplikasi
- **Frontend:** http://localhost  
- **Filament Admin Panel:** http://localhost/admin  
  - Default login:
    - Username: `Admin`
    - Email: `admin@mail.com`  
    - Password: `password`

---

## 📌 Catatan
- Pastikan **Docker Desktop** sudah berjalan.
- Untuk stop container:
```bash
./vendor/bin/sail down
```

---

## 📜 Lisensi
Proyek ini menggunakan lisensi [MIT](LICENSE).
