# Activity Manager v1

Aplikasi manajemen kegiatan sederhana menggunakan Laravel 13. Dibuat sebagai bagian dari Proyek 3 — Modul 3 (Frameworks in Programming - Laravel Basic).

## Fitur

- Melihat daftar kegiatan
- Melihat detail kegiatan
- Menambah, mengubah, dan menghapus kegiatan
- Validasi input melalui Form Request
- Aturan transisi status (Planned → Ongoing → Done) melalui service class

## Requirement

- PHP 8.3 atau lebih baru
- Composer
- SQLite (baseline) atau MySQL/MariaDB

## Instalasi

1. Clone repository

   ```bash
   git clone <URL_REPOSITORY_ANDA>
   cd activity-manager
   ```

2. Install dependency

   ```bash
   composer install
 
3. Jalankan server

   ```bash
   php artisan serve
   ```

4. Buka `http://127.0.0.1:8000/activities` di browser.

## Route Utama

| Method | URI | Fungsi |
|---|---|---|
| GET | `/activities` | Daftar kegiatan |
| GET | `/activities/create` | Form tambah kegiatan |
| POST | `/activities` | Simpan kegiatan baru |
| GET | `/activities/{activity}` | Detail kegiatan |
| GET | `/activities/{activity}/edit` | Form ubah kegiatan |
| PUT/PATCH | `/activities/{activity}` | Simpan perubahan kegiatan |
| DELETE | `/activities/{activity}` | Hapus kegiatan |

## Struktur Penting

```
app/Http/Controllers/ActivityController.php   -> orkestrasi request/response
app/Http/Requests/                             -> validasi input (Form Request)
app/Services/ActivityService.php                -> business logic (aturan transisi status)
app/Models/Activity.php                         -> Eloquent model
database/migrations/                            -> skema tabel activities
database/seeders/ActivitySeeder.php             -> data awal
resources/views/activities/                     -> tampilan Blade
```


## Catatan

- Business rule transisi status (`Planned → Ongoing → Done`, tidak boleh mundur) ditegakkan di `ActivityService`, bukan di controller atau Blade.
- Authentication, ownership, dan role belum diimplementasikan pada versi ini — akan ditambahkan pada Modul 4 dan 5.

## Author

Nama: Irfan Ardiansah Sulaeman
NIM: 251511043
