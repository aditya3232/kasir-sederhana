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

## 5. Restart app
untukr restart satu service 
```bash
docker compose -f docker-compose.dev.yml restart nginx
```