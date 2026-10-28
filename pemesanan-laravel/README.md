# Sistem Pemesanan dan Pembayaran Online (Laravel)

Dibuat dari ERD, UML Class Diagram, Use Case, dan DFD Level 0/1.
Folder ini adalah **overlay**: berisi file aplikasi (migration, model, controller, route, view, seeder).
Letakkan di atas project Laravel 11 yang baru.

## Pemetaan diagram ke kode
| Diagram | Implementasi |
|---|---|
| ERD (D1 menus, D2 detail_pesanans, D3 orders, D4 pembayarans, D5 admins) | `database/migrations/*` + `app/Models/*` |
| UML (method `cekStok`, `hitungSubtotal`, `hitungTotal`, ...) | `Menu::cekStok`, `DetailPesanan::hitungSubtotal`, `Order::hitungTotal` |
| Use Case Pelanggan | `MenuController`, `CartController`, `OrderController` |
| Use Case Admin | `app/Http/Controllers/Admin/*` (login, menu CRUD, order, pembayaran, laporan) |
| DFD proses 3.0 / 4.0 / 5.0 / 6.0 | `OrderController@store`, `@bayar`, `Admin\PembayaranController`, `Admin\LaporanController` |

## Instalasi lokal
Syarat: PHP 8.2+, Composer, MySQL/MariaDB (atau SQLite).

```bash
composer create-project laravel/laravel pemesanan
cd pemesanan
# salin isi folder overlay ini ke dalam project (timpa file yang sama: routes/web.php, DatabaseSeeder.php)
cp -r /path/ke/overlay/app /path/ke/overlay/database /path/ke/overlay/resources /path/ke/overlay/routes .
cp .env.example .env && php artisan key:generate
```
Edit `.env` untuk MySQL:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pemesanan
DB_USERNAME=root
DB_PASSWORD=
```
Lalu:
```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
Buka http://127.0.0.1:8000. Admin: http://127.0.0.1:8000/admin/login

**Akun admin awal:** username `admin`, password `admin123` (WAJIB diganti sebelum online).

## Alur penggunaan
1. Pelanggan: Menu → Tambah ke keranjang → Lanjut ke pemesanan → isi data → Buat pesanan → unggah bukti bayar di invoice.
2. Pelanggan cek status lagi lewat "Cek status order" (nomor order + nomor telepon).
3. Admin: Pembayaran → Terima/Tolak bukti → order otomatis jadi *diproses* → ubah status ke *selesai*.
4. Admin: Laporan → pilih rentang tanggal.
