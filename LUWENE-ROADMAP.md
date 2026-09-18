# LUWENE - ROADMAP PEMBANGUNAN ULANG

> Terakhir diperbarui: 18 September 2026
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
| 5 | Admin Dashboard (Manajemen) | BELUM SELESAI |
| 6 | Integrasi & Polishing | BELUM SELESAI |
| 7 | Testing & Deployment | BELUM SELESAI |

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

### 5.2 Menu Management (CRUD)
- [ ] Route: `/admin/menu`
- [ ] Component: `Admin\MenuManagement`
- [ ] Features:
  - [ ] Daftar produk (gambar, nama, harga, kategori, status)
  - [ ] Create/Edit/Delete produk
  - [ ] Upload gambar produk
  - [ ] Kelola kategori (CRUD)
  - [ ] Kelola modifier groups

### 5.3 Staff Management
- [ ] Route: `/admin/staff`
- [ ] Component: `Admin\StaffManagement`
- [ ] Features:
  - [ ] Daftar staff (nama, email, role, branch, status)
  - [ ] Tambah/Edit/Nonaktifkan staff
  - [ ] Role assignment (USER/CASHIER/ADMIN)

### 5.4 Branch Management
- [ ] Route: `/admin/branches`
- [ ] Component: `Admin\BranchManagement`
- [ ] Features:
  - [ ] Daftar cabang (nama, alamat, status)
  - [ ] Tambah/Edit cabang
  - [ ] Toggle active/inactive

### 5.5 Transaction History
- [ ] Route: `/admin/transactions`
- [ ] Component: `Admin\TransactionHistory`
- [ ] Features:
  - [ ] Daftar order lengkap
  - [ ] Filter: tanggal, status, metode bayar, cabang
  - [ ] Detail order modal
  - [ ] Pagination

### 5.6 Sales Reports
- [ ] Route: `/admin/reports`
- [ ] Component: `Admin\SalesReports`
- [ ] Features:
  - [ ] Pilih periode
  - [ ] Ringkasan revenue
  - [ ] Top produk chart
  - [ ] Revenue per metode bayar

### 5.7 Settings
- [ ] Route: `/admin/settings`
- [ ] Component: `Admin\Settings`
- [ ] Features:
  - [ ] Konfigurasi pajak (PPN)
  - [ ] Format nomor order
  - [ ] Jam operasional
  - [ ] Footer struk

### 5.8 Admin Layout
- [ ] Sidebar navigasi
- [ ] Responsive sidebar toggle
- [ ] Active page indicator

---

## FASE 6: INTEGRASI & POLISHING

- [ ] Receipt Generation (struk cetak)
- [ ] Real-time Updates (auto-refresh)
- [ ] Error Handling & Empty States
- [ ] Double-Submit Prevention
- [ ] Destructive Action Guards
- [ ] Mobile Responsive (kiosk)

---

## FASE 7: TESTING & DEPLOYMENT

- [ ] Unit Tests
- [ ] Feature Tests
- [ ] API Tests
- [ ] Seed Data Lengkap
- [ ] Final Testing

---

## ATURAN PENTING

1. **Kiosk-First**: Touch targets >= 48px
2. **Flat Design**: Tidak glassmorphism
3. **Double-Submit**: Disable tombol saat proses
4. **Dummy Payment**: Tidak ada gateway sungguhan
5. **Zero-Trust Pricing**: Server hitung ulang harga
6. **Live Aggregation**: Dashboard dari SQL, bukan mock data
7. **Single Database**: Semua role pakai data sama

---

*Lihat detail lengkap di `Luwene-docs/ROADMAP-CURRENT.md`*
