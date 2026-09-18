# LUWENE — Product Requirements Document

## 1. Overview

LUWENE adalah website internal untuk simulasi operasional usaha kuliner/kios.

Sistem menggabungkan:
1. Customer ordering
2. Cashier / Point of Sale (POS)
3. Business administration

LUWENE adalah projek pribadi/dummy, bukan SaaS atau layanan publik. Aplikasi digunakan dalam lingkungan kios dan tidak dirancang untuk diakses publik dari internet.

## 2. Product Vision

Membuat sistem operasional kios kuliner yang terasa seperti aplikasi bisnis nyata, tetapi tetap sederhana, terstruktur, dan mudah dikembangkan.

Prinsip utama:
- Satu aplikasi
- Satu backend
- Satu database
- Data antar-role selalu terhubung
- Role-based access
- Alur pemesanan jelas
- Tidak ada duplikasi data transaksi antar sistem

## 3. Goals

### Primary Goals
- Menyediakan katalog menu LUWENE.
- Memungkinkan user membuat pesanan.
- Memungkinkan kasir menangani transaksi.
- Memungkinkan admin mengelola data bisnis.
- Menghubungkan seluruh aktivitas melalui database yang sama.
- Menampilkan status pesanan secara konsisten.
- Menyediakan dashboard dan laporan dasar untuk admin.

### Secondary Goals
- UI modern dan konsisten.
- Struktur kode mudah dipelihara.
- Hak akses berdasarkan role.
- Validasi frontend dan backend.
- Integritas data transaksi.

## 4. Non-Goals

LUWENE tidak ditujukan untuk:
- Marketplace makanan.
- Aplikasi multi-cabang.
- SaaS publik.
- Sistem berskala ribuan pengguna.
- Loyalty system kompleks.
- Delivery/logistics.
- Accounting/ERP penuh.
- Payment gateway finansial sungguhan.
- Arsitektur enterprise yang kompleks.

Pembayaran dapat disimulasikan.

## 5. User Roles

### 5.1 USER

User adalah pelanggan.

Dapat:
- Melihat menu dan detail produk.
- Memilih varian dan topping.
- Mengatur jumlah.
- Mengelola cart.
- Membuat order.
- Melihat order miliknya.
- Melihat status dan riwayat order.

Tidak dapat:
- Mengelola produk.
- Mengubah harga.
- Melihat transaksi user lain.
- Mengelola kasir.
- Mengakses dashboard admin.

### 5.2 CASHIER

Kasir bertanggung jawab terhadap transaksi dan order.

Dapat:
- Melihat order masuk.
- Melihat detail order.
- Melihat pembayaran.
- Mengonfirmasi pembayaran.
- Mengubah status order sesuai alur.
- Membuat order untuk pelanggan bila diperlukan.
- Melihat transaksi dan riwayat.

Tidak dapat:
- Mengelola akun admin.
- Mengubah konfigurasi sistem.
- Mengubah database secara langsung.
- Mengubah laporan secara manual.
- Mengelola permission pengguna.

### 5.3 ADMIN

Admin mengelola sistem dan bisnis.

Dapat:
- Melihat dashboard.
- CRUD produk, kategori, varian, dan topping.
- Mengatur harga dan ketersediaan.
- Melihat seluruh order dan transaksi.
- Mengelola user dan kasir.
- Melihat laporan/statistik.
- Mengelola pengaturan aplikasi.

## 6. Core Features

### 6.1 Authentication
Role minimal:
- USER
- CASHIER
- ADMIN

Setiap user hanya dapat mengakses halaman sesuai permission.

### 6.2 Menu
Produk minimal memiliki:
- Nama
- Deskripsi
- Harga
- Gambar
- Kategori
- Status tersedia/tidak tersedia

Contoh kategori:
- Minuman
- Makanan
- Snack
- Paket

### 6.3 Product Customization
Produk dapat memiliki:
- Ukuran
- Level gula
- Level es
- Topping
- Add-on

Tidak semua produk wajib memiliki konfigurasi.

### 6.4 Cart
User dapat:
- Menambah produk.
- Mengubah jumlah.
- Mengubah konfigurasi.
- Menghapus item.
- Melihat subtotal dan total.

Cart bukan transaksi final sampai order dibuat.

### 6.5 Order
Order minimal memiliki:
- Order ID
- User
- Daftar item
- Subtotal
- Discount jika ada
- Total
- Payment status
- Order status
- Created timestamp
- Updated timestamp

## 7. Order Lifecycle

Status:
- PENDING
- CONFIRMED
- PREPARING
- READY
- COMPLETED
- CANCELLED

Alur normal:

```text
PENDING
   ↓
CONFIRMED
   ↓
PREPARING
   ↓
READY
   ↓
COMPLETED
```

Perubahan status harus mengikuti state transition yang ditentukan sistem.

## 8. Payment

Payment merupakan simulasi.

Minimal:
- Payment ID
- Order ID
- Amount
- Payment method
- Payment status
- Timestamp

Payment status:
- UNPAID
- PAID
- FAILED
- REFUNDED

Method contoh:
- CASH
- QRIS
- CARD
- OTHER

Tidak diperlukan payment gateway sungguhan.

## 9. Cashier POS

Fitur:
- Order queue.
- Order detail.
- Payment confirmation.
- Order status control.
- Transaction history.
- Search order.
- Filter order.

POS menggunakan order yang sama dengan customer system.

## 10. Admin Dashboard

Minimal:
- Total sales.
- Total orders.
- Completed orders.
- Cancelled orders.
- Produk terlaris.
- Pendapatan berdasarkan periode.

Periode:
- Hari ini
- 7 hari
- 30 hari

## 11. Product Management

Admin dapat CRUD:
- Product
- Category
- Variant
- Topping

Produk dapat dinonaktifkan tanpa menghapus historical order.

## 12. User Management

Admin dapat:
- Melihat user.
- Membuat user.
- Mengubah user.
- Menonaktifkan user.
- Mengelola role sesuai permission.

Historical order harus tetap aman jika user dinonaktifkan.

## 13. Reporting

Admin dapat melihat:
- Total revenue.
- Total order.
- Average order value.
- Sales per day.
- Sales per product.
- Sales per category.
- Payment method distribution.

Laporan dihitung dari data transaksi/order, bukan angka manual.

## 14. Data Consistency

User, kasir, dan admin menggunakan sumber data yang sama.

```text
USER
  ↓
Create Order
  ↓
DATABASE
  ↓
CASHIER
  ↓
Confirm Payment
  ↓
DATABASE
  ↓
USER
  ↓
Order Status Updated
```

Tidak boleh ada database transaksi terpisah untuk masing-masing role.

## 15. UI Requirements

UI harus:
- Responsive.
- Konsisten.
- Mudah dipahami.
- Memiliki navigation jelas.
- Memiliki loading state.
- Memiliki empty state.
- Memiliki error state.
- Memiliki confirmation untuk destructive action.
- Memberikan feedback setelah action.

Area User, Cashier, dan Admin dibedakan secara UI tetapi tetap berada dalam satu aplikasi.

## 16. Success Criteria

Projek dianggap memenuhi requirement apabila:
1. User dapat login.
2. User dapat melihat menu.
3. User dapat membuat order.
4. Order masuk ke sistem.
5. Kasir dapat melihat order.
6. Kasir dapat memproses pembayaran.
7. Status order dapat berubah.
8. User dapat melihat perubahan status.
9. Admin dapat melihat order/transaksi.
10. Admin dapat mengelola menu.
11. Ketiga role menggunakan database yang sama.
12. Permission setiap role berjalan benar.
