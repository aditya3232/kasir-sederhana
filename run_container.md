## 1. Menjalankan container
untuk menyalakan ketiga service jalankan perintah ini
```bash
docker compose -f docker-compose.dev.yml up -d
```
dan untuk membuild app image yang baru beserta menjalankan container gunakan perintah ini
```bash
docker compose -f docker-compose.dev.yml up -d --build
```

## 2. Cek container
untuk cek apakah semua container dalam kondisi up
```bash
docker compose -f docker-compose.dev.yml ps
```
atau jika ingin lihat log didalamnya
```bash
docker compose -f docker-compose.dev.yml logs
```
untuk melihat log satu service saja
```bash
docker compose -f docker-compose.dev.yml logs app
```

## 3. Matikan container
untuk mematikan container
```bash
docker compose -f docker-compose.dev.yml down
```

## 4. Masuk kedalam container
untuk menjalankan perintah seperti artisan jalankan perintah dari dalam container dengan perintah ini
```bash
docker compose -f docker-compose.dev.yml exec app bash
```
masuk ke dalam app laravel dan menjalankan composer. Jalankan di  projek ./kasir-sederhana tempat ditemukan docker-compose.dev.yml
```bash
docker compose -f docker-compose.dev.yml exec app composer create-project laravel/laravel .
```
masuk dalam app laravel dan menjalankan artisan migrate
```bash
docker compose -f docker-compose.dev.yml exec app php artisan migrate
```
memasang breeze : starter kit laravel untuk auth (login, logout, lupa kata sandi, profile)
- halaman register dan login : tempat pengguna mendaftar dan masuk
- logika auth : mengurus proses masuk, keluar, dan keamanan sesi
- halaman profil : tempat pengguna mengubah data dan kata sandinya
- penjaga halaman : pelindung agar halaman tertentu hanya bisa diakses setelah login

untuk masalah saat install breeze blade, jalankan npm install di dalam folder src langsung
```bash
docker compose -f docker-compose.dev.yml exec app composer require laravel/breeze --dev
docker compose -f docker-compose.dev.yml exec app php artisan breeze:install blade
```

untuk membuat controller dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:controller ProdukController
```

untuk membuat resource controller dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:controller ProdukController --resource
```

untuk membuat component dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:component Alert
```

untuk membuat migration dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:migration create_produk_table
```

untuk menjalankan migration dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan migrate
```

untuk membuat model dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:model Produk
```

untuk membuat seeder dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:seeder ProdukSeeder
```

untuk menjalankan seeder dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan db:seed --class=ProdukSeeder
```

untuk membuat form request dengan artisan
```bash
docker compose -f docker-compose.dev.yml exec app php artisan make:request StoreProdukRequest
docker compose -f docker-compose.dev.yml exec app php artisan make:request UpdateProdukRequest
```

## 5. Restart app
untukr restart satu service 
```bash
docker compose -f docker-compose.dev.yml restart nginx
```