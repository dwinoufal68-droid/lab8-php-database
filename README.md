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

## Screenshot Hasil Praktikum
Berikut adalah tampilan antarmuka dari aplikasi web CRUD data barang yang telah dibuat[cite: 5]:

![Tampilan Dashboard Inventaris](screenshots/<img width="940" height="495" alt="Screenshot 2026-11-22 183812" src="https://github.com/user-attachments/assets/bf91dd93-85b6-4594-bee9-5bcc22fff8c6" />
dashboard.png)

## Tampilan Aplikasi

![Halaman daftar barang](gambar/<img width="960" height="600" alt="Screenshot 2026-11-22 182808" src="https://github.com/user-attachments/assets/e9da6a3f-fb95-4d71-86ed-a8a4f167b417" />
index.png)

![Halaman tambah barang](gambar/<img width="803" height="475" alt="Screenshot 2026-11-22 173919" src="https://github.com/user-attachments/assets/b68bc17b-f6bd-42d7-b2be-046166f3fea0" />
tambah.png)

![Halaman ubah barang](gambar/u<img width="424" height="373" alt="Screenshot 2026-11-22 180901" src="https://github.com/user-attachments/assets/e696b4c0-49b7-437c-ad35-410ef72606a6" />
bah.png)
