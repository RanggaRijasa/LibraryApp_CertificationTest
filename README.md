# Sistem Perpustakaan (Laravel 12 + MySQL)

Sistem Perpustakaan berbasis **Laravel 12** dan **MySQL**.
Fitur utama: **Login**, **Katalog Buku**, **CRUD Buku (Staff/Admin)**, dan **Peminjaman Buku (Member, jatuh tempo 7 hari)**.

---

## Tech Stack
- Laravel **12.x**
- PHP 8.x
- MySQL (XAMPP)
- Blade + Tailwind (via Vite)
- Laravel Breeze (auth scaffolding)

---

## Fitur
- Login / Logout


### Member 
- Lihat katalog buku
- Cari buku 
- Tombol **Pinjam (7 hari)** jika stok tersedia
- Halaman **Peminjaman Saya**

### Staff
- CRUD Buku (Master Buku)
  - Tambah / Edit / Hapus
- Lihat data peminjaman (Loan)

---

## Role & Akses
Role disimpan di tabel `users.role`:
- `staff`
- `member`

Middleware:
- `auth` → user harus login
- `role:staff` → hanya staff boleh akses menu master buku & peminjaman

---

## Database / ERD 

### Tabel
- **users**
- **books**
- **loans**
- **loan_items**

### Relasi
1) Relasi loans → loan_items (One-to-Many)

2) Relasi books → loan_items (One-to-Many)

3) Relasi loans ↔ books (Many-to-Many melalui loan_items)

## Instalasi (Windows + XAMPP)

1) Clone project

2) Install dependency PHP

3) Copy environment

4) Buat database MySQL

5) Migrate database

6) Install & build asset

8) Jalankan server
