# Praktikum 8 - PHP dan Database MySQL

Aplikasi CRUD sederhana untuk mengelola data barang menggunakan PHP, MySQL, HTML, dan CSS.

## Isi project
- `koneksi.php` - koneksi ke database MySQL.
- `index.php` - menampilkan data barang (Read).
- `tambah.php` - menambahkan data barang (Create).
- `ubah.php` - mengubah data barang (Update).
- `hapus.php` - menghapus data barang (Delete).
- `style.css` - tampilan aplikasi.
- `database.sql` - membuat database, tabel, dan data contoh.
- `gambar/` - tempat menyimpan gambar barang.

## Cara menjalankan
1. Ekstrak folder project ke `C:\xampp\htdocs\`.
2. Jalankan Apache dan MySQL dari XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin/`.
4. Pilih menu **Import**, pilih file `database.sql`, lalu klik **Import/Go**.
5. Buka `http://localhost/lab8_php_database/`.

## Teknologi
PHP, MySQL, XAMPP, HTML, dan CSS.

## Catatan
Konfigurasi awal database menggunakan host `localhost`, user `root`, password kosong, dan nama database `latihan1`. Sesuaikan `koneksi.php` jika konfigurasi MySQL berbeda.
