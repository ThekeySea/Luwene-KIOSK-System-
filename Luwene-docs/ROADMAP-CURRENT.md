# LUWENE - ROADMAP PEMBANGUNAN ULANG (DETAILED)

> Terakhir diperbarui: 19 September 2026
> Tech Stack: Laravel 13 + Livewire 4 + Tailwind CSS v4 + SQLite

---

## RINGKASAN STATUS

| Fase | Deskripsi | Status |
|------|-----------|--------|
| 0 | Fondasi & Infrastruktur | SELESAI |
| 1 | Database & Model | SELESAI |
| 2 | Autentikasi & Otorisasi | SELESAI |
| 3 | Customer Kiosk (Pemesanan) | SELESAI |
| 4 | Kasir POS (Transaksi) | SELESAI |
| 5 | Admin Dashboard (Manajemen) | SELESAI |
| 6 | Integrasi & Polishing | SELESAI |
| 7 | Testing & Deployment | BELUM SELESAI |

> Lihat `LUWENE-ROADMAP.md` di root project untuk roadmap ringkas yang selalu terbaru.

---

## FASE 0: FONDASI & INFRASTRUKTUR

### 0.1 Instalasi dependencies
- [x] Laravel 13 project
- [x] Livewire 4
- [x] Tailwind CSS v4
- [x] Alpine.js
- [x] Sanctum (autentikasi token)

### 0.2 Konfigurasi project
- [x] SQLite database
- [x] Environment setup
- [x] Vite configuration
- [x] Folder structure

### 0.3 Layout System
- [x] `layouts/app.blade.php` - Layout dasar (legacy, untuk reference)
- [x] `layouts/customer.blade.php` - Layout kiosk ({{ $slot }})
- [x] `layouts/staff.blade.php` - Layout kasir/admin ({{ $slot }})

---

## FASE 1: DATABASE & MODEL

### 1.1 Migrations (21 file)
- [x] `users_table` - Pengguna sistem
- [x] `branches_table` - Cabang/restoran
- [x] `restaurant_tables_table` - Meja
- [x] `categories_table` - Kategori produk
- [x] `products_table` - Produk
- [x] `product_variants_table` - Varian produk
- [x] `modifier_groups_table` - Grup modifier
- [x] `modifiers_table` - Modifier (topping/add-on)
- [x] `sambals_table` - Sambal
- [x] `spice_levels_table` - Level kepedasan
- [x] `packages_table` - Paket produk
- [x] `product_modifier_groups_table` - Relasi produk-modifier
- [x] `orders_table` - Pesanan
- [x] `order_items_table` - Item pesanan
- [x] `order_item_modifiers_table` - Modifier item pesanan
- [x] `payments_table` - Pembayaran
- [x] `audit_logs_table` - Log audit
- [x] `dining_sessions_table` - Sesi makan
- [x] `cache_table` - Cache
- [x] `jobs_table` - Queue jobs
- [x] `personal_access_tokens_table` - Sanctum tokens

### 1.2 Models (19 model)
- [x] `User` - Pengguna (HasApiTokens)
- [x] `Branch` - Cabang
- [x] `RestaurantTable` - Meja
- [x] `Category` - Kategori
- [x] `Product` - Produk
- [x] `ProductVariant` - Varian
- [x] `ModifierGroup` - Grup modifier
- [x] `Modifier` - Modifier
- [x] `Sambal` - Sambal
- [x] `SpiceLevel` - Level kepedasan
- [x] `Package` - Paket
- [x] `PackageItem` - Item paket
- [x] `Order` - Pesanan
- [x] `OrderItem` - Item pesanan
- [x] `OrderItemModifier` - Modifier item
- [x] `Payment` - Pembayaran
- [x] `DiningSession` - Sesi makan
- [x] `ProductModifierGroup` - Relasi produk-modifier
- [x] `AuditLog` - Log audit

### 1.3 Seeders
- [x] `UserSeeder` - admin, kasir, customer
- [x] `BranchSeeder` - LUWENE Main
- [x] `RestaurantTableSeeder` - 10 meja
- [x] `CategorySeeder` - Kategori produk
- [x] `ProductSeeder` - Produk contoh
- [x] `SpiceLevelSeeder` - Level kepedasan
- [x] `SambalSeeder` - Sambal
- [x] `PackageSeeder` - Paket
- [x] `DatabaseSeeder` - Menjalankan semua seeder

---

## FASE 2: AUTENTIKASI & OTORISASI

### 2.1 Autentikasi
- [x] Login controller (API)
- [x] Sanctum token-based auth
- [x] Middleware auth:sanctum
- [x] User model dengan HasApiTokens

### 2.2 Otorisasi
- [x] Role-based access (USER, CASHIER, ADMIN)
- [x] Customer hanya bisa lihat order sendiri
- [x] Cashier bisa proses semua order
- [x] Admin bisa akses semua data

### 2.3 Seed Users
- [x] `admin@luwene.id` / password
- [x] `kasir@luwene.id` / password
- [x] `customer@luwene.id` / password

---

## FASE 3: CUSTOMER KIOSK (SELESAI)

### 3.1 Entry Page
- [x] `Customer\EntryPage` - Pilihan Dine In / Takeaway
- [x] Route: `/`
- [x] Touch-friendly UI (tombol besar)

### 3.2 Menu Page
- [x] `Customer\MenuPage` - Daftar menu
- [x] Filter berdasarkan kategori
- [x] Pencarian produk
- [x] Tampilan card produk dengan gambar

### 3.3 Product Detail
- [x] `Customer\ProductDetailPage` - Detail produk
- [x] Pilihan varian (ukuran)
- [x] Pilihan modifier (topping, level pedas)
- [x] Tombol "Tambah ke Keranjang"

### 3.4 Cart
- [x] `Customer\CartPage` - Keranjang belanja
- [x] Ubah jumlah item
- [x] Hapus item
- [x] Ringkasan subtotal & total

### 3.5 Checkout
- [x] `Customer\CheckoutPage` - Halaman checkout
- [x] Pilihan metode bayar (CASH/QRIS/CARD)
- [x] Konfirmasi order type (Dine In/Takeaway)
- [x] Submit order

### 3.6 Order Tracking
- [x] `Customer\OrderTrackingPage` - Lacak pesanan
- [x] Status real-time (polling)
- [x] Detail order & status

---

## FASE 4: KASIR POS (SELESAI)

### 4.1 Dashboard
- [x] `Kasir\Dashboard` - Antrian pesanan
- [x] Counter: pending, preparing, ready
- [x] Filter berdasarkan status
- [x] Pencarian order
- [x] Tombol status transition

### 4.2 Payment Verification
- [x] Verifikasi pembayaran (CASH/QRIS/CARD)
- [x] API: `POST /api/v1/cashier/orders/{id}/verify-payment`
- [x] Status: UNPAID → PAID

### 4.3 Status Transitions
- [x] PENDING → CONFIRMED → PREPARING → READY → COMPLETED
- [x] Validasi transition di backend
- [x] API: `PATCH /api/v1/cashier/orders/{id}/status`

### 4.4 Menu Availability
- [x] `Kasir\MenuAvailability` - Toggle ketersediaan
- [x] API: `PATCH /api/v1/cashier/menu/{id}/availability`
- [x] Filter berdasarkan kategori

### 4.5 Table Management
- [x] `Kasir\TableManagement` - Kelola meja
- [x] Grid view 10 meja
- [x] Toggle: AVAILABLE ↔ OCCUPIED
- [x] API: `PATCH /api/v1/cashier/tables/{id}/status`

---

## FASE 5: ADMIN DASHBOARD (BELUM SELESAI)

### 5.1 Admin Dashboard
- [ ] Route: `/admin`
- [ ] Component: `Admin\Dashboard`
- [ ] Features:
  - [ ] Total revenue hari ini (SQL aggregation)
  - [ ] Total order hari ini
  - [ ] Average order value
  - [ ] Revenue mingguan/bulanan
  - [ ] Top 5 produk terlaris
  - [ ] 10 order terakhir
  - [ ] Empty state: "Belum ada data" + Rp0
- [ ] Layout: `layouts.staff`
- [ ] Constraint: NO mock data, harus LIVE SQL

### 5.2 Menu Management (CRUD)
- [ ] Route: `/admin/menu`
- [ ] Component: `Admin\MenuManagement`
- [ ] Features:
  - [ ] Daftar produk (gambar, nama, harga, kategori, status)
  - [ ] Create produk
  - [ ] Edit produk
  - [ ] Delete produk (konfirmasi modal)
  - [ ] Upload gambar produk
  - [ ] Kelola kategori (CRUD)
  - [ ] Kelola modifier groups
- [ ] API:
  - [ ] `GET /api/v1/admin/products`
  - [ ] `POST /api/v1/admin/products`
  - [ ] `PUT /api/v1/admin/products/{id}`
  - [ ] `DELETE /api/v1/admin/products/{id}`
  - [ ] `POST /api/v1/admin/categories`
  - [ ] `PUT /api/v1/admin/categories/{id}`
  - [ ] `DELETE /api/v1/admin/categories/{id}`

### 5.3 Staff Management
- [ ] Route: `/admin/staff`
- [ ] Component: `Admin\StaffManagement`
- [ ] Features:
  - [ ] Daftar staff (nama, email, role, branch, status)
  - [ ] Tambah staff
  - [ ] Edit staff
  - [ ] Nonaktifkan staff (konfirmasi modal)
  - [ ] Role assignment (USER/CASHIER/ADMIN)
- [ ] API:
  - [ ] `GET /api/v1/admin/staff`
  - [ ] `POST /api/v1/admin/staff`
  - [ ] `PUT /api/v1/admin/staff/{id}`
  - [ ] `DELETE /api/v1/admin/staff/{id}`

### 5.4 Branch Management
- [ ] Route: `/admin/branches`
- [ ] Component: `Admin\BranchManagement`
- [ ] Features:
  - [ ] Daftar cabang (nama, alamat, status)
  - [ ] Tambah cabang
  - [ ] Edit cabang
  - [ ] Toggle active/inactive
  - [ ] Jumlah meja per cabang
- [ ] API:
  - [ ] `GET /api/v1/admin/branches`
  - [ ] `POST /api/v1/admin/branches`
  - [ ] `PUT /api/v1/admin/branches/{id}`
  - [ ] `DELETE /api/v1/admin/branches/{id}`

### 5.5 Transaction History
- [ ] Route: `/admin/transactions`
- [ ] Component: `Admin\TransactionHistory`
- [ ] Features:
  - [ ] Daftar order lengkap
  - [ ] Filter: tanggal, status, metode bayar, cabang
  - [ ] Detail order modal
  - [ ] Pagination (20/halaman)
- [ ] API: `GET /api/v1/admin/transactions`

### 5.6 Sales Reports
- [ ] Route: `/admin/reports`
- [ ] Component: `Admin\SalesReports`
- [ ] Features:
  - [ ] Pilih periode (hari ini, minggu ini, bulan ini, custom)
  - [ ] Ringkasan revenue
  - [ ] Top produk chart
  - [ ] Revenue per metode bayar
  - [ ] Revenue per order type
- [ ] Constraint: Semua query harus LIVE SQL aggregation

### 5.7 Settings
- [ ] Route: `/admin/settings`
- [ ] Component: `Admin\Settings`
- [ ] Features:
  - [ ] Konfigurasi pajak (PPN)
  - [ ] Pengaturan service charge
  - [ ] Format nomor order
  - [ ] Jam operasional per cabang
  - [ ] Footer struk

### 5.8 Admin Layout
- [ ] Sidebar navigasi
- [ ] Responsive sidebar toggle
- [ ] Active page indicator
- [ ] Info user (nama, role, logout)

---

## FASE 6: INTEGRASI & POLISHING

### 6.1 Receipt Generation
- [ ] Struk cetak setelah pembayaran
- [ ] Format: nomor order, item, modifier, subtotal, pajak, total
- [ ] Metode bayar, nama kasir, timestamp
- [ ] Kompatibel thermal printer A5

### 6.2 Real-time Updates
- [ ] Auto-refresh kasir dashboard (order queue)
- [ ] Auto-refresh customer order tracking
- [ ] Auto-refresh admin dashboard (metrics)

### 6.3 Error Handling & Empty States
- [ ] Semua halaman: loading skeleton
- [ ] Error message + tombol "Coba Lagi"
- [ ] Empty state informatif
- [ ] Translate error API ke bahasa Indonesia
- [ ] Toast notification (sukses/error)

### 6.4 Double-Submit Prevention
- [ ] Semua form: disable tombol saat proses
- [ ] Livewire `wire:loading` directives
- [ ] Server-side validation

### 6.5 Destructive Action Guards
- [ ] Semua hapus/nonaktif: modal konfirmasi
- [ ] "Apakah Anda yakin?" dengan input alasan (opsional)
- [ ] Audit log untuk aksi destruktif

### 6.6 Mobile Responsive (Kiosk)
- [ ] Customer pages: touch-optimized (min 48px touch targets)
- [ ] Dine In / Takeaway: full-width tombol
- [ ] Cart: swipe to remove (stretch goal)

---

## FASE 7: TESTING & DEPLOYMENT

### 7.1 Unit Tests
- [ ] Model tests
- [ ] Service tests
- [ ] Validation tests

### 7.2 Feature Tests
- [ ] Auth: login valid/invalid
- [ ] Authorization: role-based access
- [ ] Order: create, transition, ownership
- [ ] Payment: validation, amount recalculation

### 7.3 API Tests
- [ ] Customer endpoints
- [ ] Cashier endpoints
- [ ] Admin endpoints

### 7.4 Seed Data Lengkap
- [ ] 15-20 produk dengan gambar
- [ ] 5-8 kategori
- [ ] 10-15 order sample (berbagai status)
- [ ] Data transaksi untuk dashboard demo

---

## ATURAN PENTING (dari .opencodeules & rules.md)

### UI Rules
1. **Kiosk-First**: Customer UI = touch targets >= 48px, tombol full-width
2. **Desktop-First**: Cashier/Admin = grid/list layouts padat
3. **UI States**: Loading + Error + Empty wajib ada
4. **Flat Design**: Tidak glassmorphism, tidak heavy shadows
5. **Anti-SaaS**: Tidak promosi-style, fokus kecepatan operasional

### Interaction Rules
6. **Double-Submit**: Disable tombol saat proses
7. **Destructive Guards**: Modal konfirmasi untuk hapus/nonaktif
8. **Kiosk Copy**: Kata kerja aksi singkat ("Pesan", "Bayar", "Selesai")
9. **Error Translation**: JSON error → pesan manusia

### Payment Rules
10. **Dummy Payment**: Tidak ada gateway sungguhan
11. **Zero-Trust Pricing**: Server hitung ulang semua harga
12. **Payment Status**: UNPAID → PAID → FAILED → REFUNDED

### Data Rules
13. **Live Aggregation**: Dashboard metrics dari SQL, bukan mock data
14. **Single Database**: Semua role pakai data yang sama
15. **No Hard Delete**: Nonaktifkan, jangan hapus historical data

---

## STRUKTUR FILE YANG DIBUTUHKAN

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php          [SELESAI]
│   │   │   ├── CatalogController.php       [SELESAI]
│   │   │   ├── CustomerOrderController.php [SELESAI]
│   │   │   ├── CashierOrderController.php  [SELESAI]
│   │   │   ├── RestaurantController.php    [SELESAI]
│   │   │   └── AdminController.php         [BARU]
│   │   └── Auth/
│   │       └── ...
│   └── Middleware/
│       └── ...
├── Livewire/
│   ├── Customer/
│   │   ├── EntryPage.php                   [SELESAI]
│   │   ├── MenuPage.php                    [SELESAI]
│   │   ├── ProductDetailPage.php           [SELESAI]
│   │   ├── CartPage.php                    [SELESAI]
│   │   ├── CheckoutPage.php                [SELESAI]
│   │   └── OrderTrackingPage.php           [SELESAI]
│   ├── Kasir/
│   │   ├── Dashboard.php                   [SELESAI]
│   │   ├── MenuAvailability.php            [SELESAI]
│   │   └── TableManagement.php             [SELESAI]
│   └── Admin/                              [BARU]
│       ├── Dashboard.php
│       ├── MenuManagement.php
│       ├── StaffManagement.php
│       ├── BranchManagement.php
│       ├── TransactionHistory.php
│       ├── SalesReports.php
│       └── Settings.php
├── Models/                                 [SELESAI - 19 model]
├── Services/                               [BARU]
│   ├── OrderService.php
│   ├── PaymentService.php
│   ├── ProductService.php
│   └── ReportService.php
└── ...

resources/views/
├── layouts/
│   ├── app.blade.php                       [SELESAI]
│   ├── customer.blade.php                  [SELESAI]
│   └── staff.blade.php                     [SELESAI]
├── livewire/
│   ├── customer/                           [SELESAI]
│   ├── kasir/                              [SELESAI]
│   └── admin/                              [BARU]
│       ├── dashboard.blade.php
│       ├── menu-management.blade.php
│       ├── staff-management.blade.php
│       ├── branch-management.blade.php
│       ├── transaction-history.blade.php
│       ├── sales-reports.blade.php
│       └── settings.blade.php
└── ...

routes/
├── web.php                                 [UPDATE]
└── api.php                                 [UPDATE]
```

---

## ESTIMASI WAKTU

| Fase | Estimasi | Keterangan |
|------|----------|------------|
| Fase 5 | 2-3 minggu | Admin Dashboard (8 fitur) |
| Fase 6 | 1 minggu | Integrasi & Polishing |
| Fase 7 | 3-4 hari | Testing & Seed Data |
| **Total** | **~4 minggu** | Sisa pekerjaan |

---

## PRIORITAS IMPLEMENTASI

### Minggu 1: Admin Foundation
1. Admin Dashboard (C-1)
2. Admin Layout & Navigation (C-8)
3. Menu Management (C-2)

### Minggu 2: Admin Management
4. Staff Management (C-3)
5. Branch Management (C-4)

### Minggu 3: Admin Reports
6. Transaction History (C-5)
7. Sales Reports (C-6)
8. Settings (C-7)

### Minggu 4: Polish & Test
9. Receipt Generation (D-1)
10. Real-time Updates (D-2)
11. Error Handling (D-3)
12. Double-Submit (D-4)
13. Destructive Guards (D-5)
14. Seed Data Lengkap
15. Testing

---

## CATATAN TEKNIS

### Livewire v4 Constraints
- Single root HTML element per component view
- `->layout('layouts.staff')` pattern (bukan `#[Layout]` attribute)
- Tidak bisa serialize paginator sebagai public property
- Gunakan array untuk data paginated

### Database
- SQLite untuk development
- UUID primary keys
- Foreign keys untuk relasi
- Soft delete untuk historical data

### Auth Flow
- Sanctum token-based
- Login via API
- Token disimpan di client
- Middleware auth:sanctum

### Order Status Flow
```
PENDING → CONFIRMED → PREPARING → READY → COMPLETED
   ↓
CANCELLED
```

### Payment Status Flow
```
UNPAID → PAID → FAILED → REFUNDED
```

---

*Roadmap ini dibuat berdasarkan analisis mendalam seluruh dokumentasi: PRD, architecture, LUWENE-CONCEPT, rules, SKILL, dan .opencodeules.*
