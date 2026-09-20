# LUWENE - ROADMAP PEMBANGUNAN ULANG

> Terakhir diperbarui: 20 September 2026
> Tech Stack: Laravel 13 + Livewire 4 + Tailwind CSS v4 + MySQL

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

---

## FASE 0: FONDASI & INFRASTRUKTUR ✅

### 0.1 Instalasi dependencies
- [x] Laravel 13 project
- [x] Livewire 4
- [x] Tailwind CSS v4
- [x] Alpine.js
- [x] Sanctum (autentikasi token)
- [x] barryvdh/laravel-dompdf (PDF struk)
- [x] milon/barcode (C128 barcode)

### 0.2 Konfigurasi project
- [x] MySQL database
- [x] Environment setup
- [x] Vite configuration (Tailwind v4, Instrument Sans font)
- [x] Folder structure

### 0.3 Layout System
- [x] `components/layouts/customer.blade.php` — Layout kiosk (bottom nav 5 tab, toast, kiosk scaling)
- [x] `components/layouts/staff.blade.php` — Layout kasir (white theme, toast, loading bar)
- [x] `components/layouts/admin.blade.php` — Layout admin (flexbox 2 kolom, sidebar dark, loading bar)

### 0.4 Design System
- [x] Custom color palette (primary #8A0000 maroon, accent #F56A47 coral, dark #60241E)
- [x] Warm neutral backgrounds
- [x] Kiosk scaling: `html.kiosk` + CSS media query 1.25x di tablet portrait
- [x] Scrollbar-hide utility
- [x] Font: Instrument Sans 400/500/600 via Bunny Fonts

### 0.5 Reusable Components
- [x] `components/loading-bar.blade.php` — Global page loading bar (Alpine.js)
  - Listens to Livewire Navigate + Request events
  - Device-aware: `prefers-reduced-motion` + `navigator.connection`
  - Used in admin & staff layouts, NOT in kiosk

### 0.6 Critical Fix: Alpine.js Double-Init
- [x] `resources/js/app.js` dikosongkan — Livewire v4 sudah bundle Alpine sendiri
- [x] Import + `Alpine.start()` dihapus agar tidak konflik dengan Livewire's Alpine

---

## FASE 1: DATABASE & MODEL ✅

### 1.1 Migrations (25 file)
- [x] `users_table` — Pengguna sistem (roles: CUSTOMER/CASHIER/ADMIN)
- [x] `branches_table` — Cabang/restoran
- [x] `restaurant_tables_table` — Meja (number, capacity, status AVAILABLE/OCCUPIED/MAINTENANCE)
- [x] `dining_sessions_table` — Sesi makan
- [x] `categories_table` — Kategori produk (auto-slug, **is_published**)
- [x] `products_table` — Produk (SoftDeletes, auto-slug, gambar, status, **is_published**)
- [x] `product_variants_table` — Varian produk (code, name, price)
- [x] `modifier_groups_table` — Grup modifier (EXTRA type, min/max)
- [x] `modifiers_table` — Modifier (price, availability)
- [x] `sambals_table` — Sambal (name, price, availability)
- [x] `spice_levels_table` — Level kepedasan (level integer)
- [x] `packages_table` — Paket produk
- [x] `package_items_table` — Item paket
- [x] `product_modifier_groups_table` — Relasi produk-modifier
- [x] `promos_table` — Promo (PERCENT/FIXED, date range, usage limits, min order)
- [x] `add_customer_info_to_orders_table` — Nama/email/HP pelanggan
- [x] `orders_table` — Pesanan (UUID, state machine, amounts)
- [x] `order_items_table` — Item pesanan
- [x] `order_item_modifiers_table` — Modifier item
- [x] `payments_table` — Pembayaran (method, amount, change, status)
- [x] `audit_logs_table` — Log audit
- [x] `cache_table` — Cache
- [x] `jobs_table` — Queue jobs
- [x] `personal_access_tokens_table` — Sanctum tokens
- [x] `add_is_published_to_products_and_categories_tables` — Kolom is_published

### 1.2 Models (20 model)
- [x] `User` — HasApiTokens, HasUuids, roles
- [x] `Branch` — hasMany tables
- [x] `RestaurantTable` — status enum
- [x] `DiningSession` — table, token, status
- [x] `Category` — auto-slug, hasMany products, **is_published** (fillable + cast)
- [x] `Product` — SoftDeletes, auto-slug, variants, modifiers, **is_published** (fillable + cast)
- [x] `ProductVariant` — code, name, price
- [x] `ModifierGroup` — type (EXTRA), min/max selection
- [x] `Modifier` — price, availability
- [x] `Sambal` — price, availability
- [x] `SpiceLevel` — level integer
- [x] `Package` / `PackageItem`
- [x] `Order` — state machine (canTransitionTo), relationships, UUID
- [x] `OrderItem` — product_name, variant_name, quantity, subtotal
- [x] `OrderItemModifier` — modifier_name, price
- [x] `Payment` — method, amount, change, status
- [x] `ProductModifierGroup` — pivot
- [x] `AuditLog` — user_id, action, entity, data

### 1.3 Seeders (9 seeder + master)
- [x] `UserSeeder` — admin@luwene.id, kasir@luwene.id, customer@luwene.id
- [x] `BranchSeeder` — LUWENE Main
- [x] `RestaurantTableSeeder` — 10 meja
- [x] `CategorySeeder` — 6 kategori (Ayam, Daging, Seafood, Sambal, Cemal Cemil, Minuman)
- [x] `ProductSeeder` — 20 produk dengan gambar
- [x] `SpiceLevelSeeder` — Level 1-5
- [x] `SambalSeeder` — 4 sambal
- [x] `PromoSeeder` — 3 kode promo (HEMAT10, LUWENE5K, WELCOME15)
- [x] `PackageSeeder` — Paket bundle
- [x] `DatabaseSeeder` — Menjalankan semua seeder

### 1.4 Traits & Services
- [x] `HasUuids` — UUID PK trait (auto-generate on creating event)
- [x] `CartPricing` — Server-side pricing (subtotal, promo discount, 11% tax, total)

---

## FASE 2: AUTENTIKASI & OTORISASI ✅

### 2.1 Auth Components
- [x] `Auth\Login` — Livewire login form (email + password)
- [x] `Auth\Register` — Livewire register form (name, email, password, role selection)
- [x] Logout route (POST, invalidates session)

### 2.2 Middleware
- [x] `EnsureRole` — Role guard (variadic roles, abort 403)
- [x] `EnsureRestaurantContext` — Sets active_branch_id in session from user's branch

### 2.3 Route Protection
- [x] Customer kiosk: PUBLIC (no auth)
- [x] Customer dashboard/orders: `auth` + `role:CUSTOMER`
- [x] Cashier POS/Scan: `auth` + `role:CASHIER,ADMIN` + `restaurant.context`
- [x] Admin panel: `auth` + `role:ADMIN` + `restaurant.context`
- [x] `/dashboard` route: role-based redirect

---

## FASE 3: CUSTOMER KIOSK ✅

### 3.1 Entry Page (`/`)
- [x] "Makan di Sini" (Dine In) / "Bawa Pulang" (Take Away) selection
- [x] Table picker grid (AVAILABLE/OCCUPIED status)
- [x] DiningSession creation for Dine In
- [x] Session storage: order_mode, table_id, dining_session_id

### 3.2 Menu Flow
- [x] Menu Index (`/customer/menu`) — Category grid with emoji icons + product count
- [x] Menu Category (`/customer/menu/kategori/{slug}`) — Product grid per category
- [x] Product Detail (`/customer/menu/{slug}`) — Full variant/sambal/spice/extras selector

### 3.3 Product Detail Features
- [x] Variant selection (required when variants exist, dynamic price)
- [x] Sambal selection (required for food categories, price factored in)
- [x] Spice level selection (required for food categories, stored as modifier)
- [x] Extras/modifiers (multi-select with per-modifier pricing)
- [x] Quantity selector (1-20 range)
- [x] Live price calculation: `(variant + sambal + extras) * qty`
- [x] Add to cart with full item data

### 3.4 Cart ("Nampan")
- [x] Session-based cart
- [x] Item list with image, name, variant, modifiers, quantity
- [x] Quantity update (min 1, recalculate unit_price)
- [x] Remove item / clear cart
- [x] CartPricing service: subtotal, promo, discount, tax (11%), total
- [x] Promo code application (via separate /promo page)
- [x] "Lanjut ke Data Diri" navigation

### 3.5 Customer Info Form (`/customer/info`)
- [x] Name (required), Email (optional), Phone (required)
- [x] Stored in session for checkout

### 3.6 Checkout Flow
- [x] Payment method selection (CASH / QRIS)
- [x] Order number generation: `LW-XXXXX` format
- [x] Order creation with all relationships
- [x] OrderItem + OrderItemModifier records
- [x] Payment record (status: PAID, paid_at: now)
- [x] Promo usage_count increment
- [x] Cart + promo_code session cleanup
- [x] Redirect to success page

### 3.7 Order Success
- [x] Success animation with checkmark
- [x] Order summary (number, total, payment method)
- [x] Auto-download PDF receipt via hidden iframe
- [x] "Download receipt again" link

### 3.8 PDF Receipt
- [x] DomPDF thermal receipt paper (226.77 x 650)
- [x] Code128 barcode (milon/barcode)
- [x] Order details, items, modifiers, payment

### 3.9 Order Tracking (`/customer/order/{id}`)
- [x] Live status display with Livewire polling (5s)
- [x] Progress bar: PENDING → CONFIRMED → PREPARING → READY → COMPLETED

### 3.10 Promo Page (`/customer/promo`)
- [x] Promo listing with conditions (min order, discount type)
- [x] Apply promo code to session

### 3.11 FAQ Page (`/customer/faq`)
- [x] FAQ content

### 3.12 Customer Auth Pages
- [x] Customer Dashboard (`/customer/dashboard`) — requires CUSTOMER role
- [x] Customer Orders (`/customer/orders`) — order history for logged-in users

### 3.13 Bottom Navigation
- [x] Pill-shaped navbar (5 tabs): Beranda, Menu, Nampan (FAB center), Promo, FAQ
- [x] Hidden on: product detail, cart, checkout, info, tracking, login, register
- [x] Badge counter on Nampan icon
- [x] Active state indicator

### 3.14 Publish Gate (NEW)
- [x] Kiosk filter: `where('is_published', true)` di Menu, MenuCategory, ProductDetail
- [x] Produk/kategori default `is_published = false` saat dibuat admin
- [x] Admin harus klik "Publish" dengan konfirmasi sebelum tampil di kiosk

---

## FASE 4: KASIR POS ✅

### 4.1 Cashier Dashboard (`/kasir/dashboard`)
- [x] Today's orders count, revenue, pending count (branch-scoped)
- [x] Polling every 5s
- [x] Quick links to POS and Scan
- [x] **White theme** — nyaman dipandang berjam-jam

### 4.2 POS Terminal (`/kasir/pos`)
- [x] Live order list (non-completed, non-cancelled)
- [x] Customer name display
- [x] Advance status button (PENDING → CONFIRMED → PREPARING → READY → COMPLETED)
- [x] State machine validation (canTransitionTo)
- [x] completed_at timestamp on COMPLETED
- [x] Polling every 5s
- [x] Toast notifications
- [x] **White theme** — clean, professional

### 4.3 Scan Order (`/kasir/scan`)
- [x] Manual code input or URL-based scan (`/kasir/scan/{code}`)
- [x] Auto-confirms PENDING orders on scan
- [x] Order lookup by order_number
- [x] Branch scoping (admin sees all)
- [x] Result display with order details
- [x] **White theme**

---

## FASE 5: ADMIN DASHBOARD ✅

### 5.1 Admin Dashboard (`/admin/dashboard`) — REDESIGNED
- [x] **Bento grid layout** — 4 kartu ringkasan + pesanan terbaru
- [x] **Pendapatan** — total paid orders sebulan terakhir
- [x] **Pesanan** — jumlah order sepekan terakhir
- [x] **Menu Terjual** — total item terbeli sebulan terakhir
- [x] **Total Produk** — jumlah semua produk
- [x] **Trend indicators** — panah naik hijau / turun merah dengan % perubahan vs periode sebelumnya
- [x] **Realtime orders** — polling 15s, dot hijau berkedip, status badges berwarna

### 5.2 Admin Layout — REBUILT
- [x] **Flexbox 2 kolom** — sidebar 240px + konten flex:1
- [x] **Sidebar dark** (`bg-dark-950`) — icon + label nav, logo, logout pinned bottom
- [x] **Mobile sidebar** — hamburger → slide-in drawer (Alpine.js)
- [x] **Loading bar** — `<x-loading-bar />` di layout
- [x] **Independent scroll** — sidebar & konten masing-masing scroll sendiri

### 5.3 Products CRUD (`/admin/products`) — ENHANCED
- [x] Table view with search + category filter
- [x] Tambah produk via modal (nama, kategori, deskripsi, harga, urutan, foto upload, aktif, tersedia, favorit)
- [x] Edit produk via modal (prefill data)
- [x] Toggle Tersedia/Habis (sekali klik)
- [x] Toggle Aktif
- [x] Delete produk dengan konfirmasi modal + arsip (soft delete)
- [x] Image upload ke storage/app/public/products/
- [x] **Publish/Unpublish** — tombol Publish dengan konfirmasi modal sebelum tampil di kiosk
- [x] **Badge Draft/Published** — visual status di tabel

### 5.4 Categories CRUD (`/admin/categories`) — ENHANCED
- [x] Card-based view with product count
- [x] Tambah kategori via modal (nama, deskripsi, urutan)
- [x] Edit kategori via modal
- [x] Hapus kategori dengan guard: ditolak bila masih ada produk
- [x] **Publish/Unpublish** — tombol Publish dengan konfirmasi modal
- [x] **Badge Draft/Published**

### 5.5 Promos CRUD (`/admin/promos`)
- [x] Card-based view (tampilan voucher)
- [x] Tambah promo via modal (kode, tipe, besaran diskon, min belanja, maks diskon, periode aktif, kuota)
- [x] Edit promo via modal
- [x] Toggle aktif/nonaktif
- [x] Hapus promo

### 5.6 Staff Management (`/admin/staff`)
- [x] Table view with role filter (Semua/Kasir/Admin)
- [x] Customer count display
- [x] Tambah staff via modal (nama, email, password, role, cabang, status)
- [x] Edit staff via modal (password optional saat edit)
- [x] Toggle Aktif/Nonaktif
- [x] Guard: tidak bisa menonaktifkan akun sendiri

### 5.7 Transaction History (`/admin/transactions`)
- [x] Search by order number / customer name
- [x] Filter: status, payment status, date
- [x] Pagination (15 per page)
- [x] Expandable detail: items, modifiers, subtotal, discount, tax, payment method

### 5.8 Sales Reports (`/admin/reports`)
- [x] Period presets: Hari Ini, 7 Hari, 30 Hari
- [x] Summary cards: Pendapatan, Total Order, Terbayar, Rata-rata/Order
- [x] Top 5 produk terlaris (bar visualization)
- [x] Order per status breakdown
- [x] Tipe order (Dine In vs Bawa Pulang)
- [x] Metode bayar breakdown (count + revenue)

---

## FASE 6: INTEGRASI & POLISHING ✅

### 6.1 Branch Management
- [x] Card-based view — menampilkan jumlah meja, staff, order
- [x] Tambah/Edit cabang (nama, alamat, status)
- [x] Toggle active/inactive
- [x] Hapus cabang dengan guard
- [x] Kelola meja — slide-out panel per cabang
- [x] Tambah/Edit/Hapus meja dengan guards

### 6.2 Admin Settings
- [x] Konfigurasi pajak (PPN %)
- [x] Format nomor order prefix
- [x] Jam operasional (buka/tutup)
- [x] Footer struk

### 6.3 Double-Submit Prevention
- [x] `wire:loading.attr="disabled"` di semua form submit button
- [x] `disabled:opacity-50` visual feedback
- [x] POS advance button dengan `wire:loading` + `wire:target`

### 6.4 Error Handling & Empty States
- [x] Custom 404 page
- [x] Custom 500 page
- [x] Empty states dengan emoji + CTA

### 6.5 Mobile Responsive
- [x] Admin sidebar: hamburger toggle di mobile
- [x] Bottom nav safe area untuk iPhone
- [x] Viewport `viewport-fit=cover` di customer layout

### 6.6 Receipt Improvements
- [x] Footer struk dari database (Setting::get)
- [x] PPN % dinamis
- [x] QR code tracking

### 6.7 Page Transition Loading Bar (NEW)
- [x] `components/loading-bar.blade.php` — Alpine.js component
- [x] Device-aware: `prefers-reduced-motion` + `navigator.connection`
- [x] Livewire Navigate events (`livewire:navigating`, `livewire:navigated`)
- [x] Livewire Request hooks (`Livewire.hook('request')`)
- [x] Admin & staff layouts: ADA loading bar
- [x] Kiosk layout: TIDAK ADA loading bar

### 6.8 Cashier Theme Overhaul (NEW)
- [x] Staff layout diubah dari dark (`bg-dark-950`) ke white (`bg-gray-50`)
- [x] POS page: white cards, gray borders, primary accent
- [x] Cashier dashboard: white cards, clean design
- [x] Scan order: white form, light input
- [x] Toast: hijau/merah di atas white bg

---

## FASE 7: TESTING & DEPLOYMENT — SEBAGIAN ✅

### 7.1 Unit Tests ✅ (62 tests)
- [x] CartPricing service tests — 19 tests (subtotal, tax, promo, discount caps, min order, inactive/expired)
- [x] Order state machine tests — 15 tests (all transitions, happy path, edge cases)
- [x] Promo calculation tests — 17 tests (fixed/percent, max cap, min order, usage limits, labels)
- [x] HasUuids trait tests — 7 tests (auto-generate, key type, uniqueness)

### 7.2 Feature Tests ✅ (40 tests)
- [x] Customer kiosk flow — 10 tests (entry, menu, product detail, promo, FAQ, takeaway/dine-in, unpublished 404)
- [x] Auth flow — 8 tests (login page, valid/invalid credentials, register, logout, role guards)
- [x] Admin CRUD flow — 22 tests (products CRUD + publish/unpublish + toggle, categories CRUD + publish/unpublish + guard, promos CRUD + toggle active + duplicate code guard)
- [ ] Cashier POS flow (advance status)
- [ ] Barcode scan flow

### 7.3 Seed Data Verification ✅
- [x] Semua seeder berjalan tanpa error
- [x] Data cukup untuk demo
- [x] `migrate:fresh --seed` berjalan lancar

### 7.4 Bug Fixes Found During Testing
- [x] Migration rename: `add_customer_info_to_orders` (000024 → 000035) — running before orders table created
- [x] Product model: tambah `use Illuminate\Support\Str` — missing import causing Class not found
- [x] `EntryPage`: ubah status dari `OPEN` ke `ACTIVE` — sesuai CHECK constraint di migration
- [x] `doctrine/dbal` installed — needed for `->change()` in sessions migration

### 7.5 Final Testing ❌
- [ ] End-to-end kiosk order
- [ ] Receipt PDF generation
- [ ] Barcode scannability
- [ ] Edge cases (empty cart, expired promo, duplicate order)

---

## STATISTIK PROYEK

| Komponen | Jumlah |
|----------|--------|
| Livewire Components (PHP) | 24 |
| Livewire Views (Blade) | 26 + 4 partials |
| Models | 20 |
| Migrations | 27 |
| Seeders | 11 |
| Middleware | 2 |
| Services | 1 |
| Traits | 1 |
| Layouts | 3 |
| Reusable Components | 1 (loading-bar) |
| Routes (web.php) | 45 routes |
| Product images | 20 |
| **Unit Tests** | **62 (all pass)** |
| **Feature Tests** | **40 (all pass)** |
| **Total Tests** | **102 (all pass)** |

---

## PERUBAHAN TERBARU (20 Sep 2026)

### Yang berubah di sesi ini:

1. **Admin Layout** — Dari grid CSS ke flexbox 2 kolom (`display: flex; height: 100vh`)
2. **Sidebar** — Icon + label nav, dark bg (`bg-dark-950`), independent scroll
3. **Admin Dashboard** — Redesign: bento grid 4 kartu + trend indicators (panah naik/turun)
4. **Publish Gate** — Produk/kategori harus di-publish admin sebelum tampil di kiosk
   - Kolom `is_published` di products & categories
   - Tombol Publish/Unpublish + modal konfirmasi
   - Badge Draft/Published di admin
   - Kiosk filter: `where('is_published', true)`
5. **Alpine.js Fix** — `app.js` dikosongkan (Livewire v4 bundle Alpine sendiri)
6. **Cashier Theme** — Seluruh halaman kasir diubah dari dark ke white
7. **Page Loading Bar** — `<x-loading-bar />` device-aware, Livewire event-driven
8. **Livewire v4 Compatibility** — Tombol "Tambah" dipindah ke dalam component view (bukan di layout header)
9. **Testing** — 102 tests (62 unit + 40 feature), semua pass
   - Unit: CartPricing, Order state machine, Promo calculation, HasUuids
   - Feature: Kiosk flow, Auth flow, Admin CRUD flow
10. **Bug Fixes** — Migration ordering, Str import, DiningSession status constraint, doctrine/dbal

---

## ATURAN PENTING

1. **Kiosk-First**: Touch targets >= 48px
2. **Flat Design**: Tidak glassmorphism
3. **Double-Submit**: Disable tombol saat proses via `wire:loading` ✅
4. **Dummy Payment**: Tidak ada gateway sungguhan
5. **Zero-Trust Pricing**: Server hitung ulang harga via CartPricing
6. **Live Aggregation**: Dashboard dari SQL, bukan mock data
7. **Single Database**: Semua role pakai data sama
8. **Auth-Free Kiosk**: Pelanggan tidak perlu login untuk memesan
9. **Soft Delete**: Produk dihapus = arsip, riwayat transaksi tetap aman
10. **Publish Gate**: Admin harus konfirmasi sebelum produk/kategori tampil di kiosk

---

*Detail arsitektur di `Luwene-docs/architecture.md`*
*PRD di `Luwene-docs/PRD.md`*
