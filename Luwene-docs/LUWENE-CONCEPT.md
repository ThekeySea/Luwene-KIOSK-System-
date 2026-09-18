# LUWENE - Konsep Aplikasi Sistem Kios Kuliner

## Gambaran Keseluruhan

LUWENE adalah simulasi sistem operasional kios kuliner yang menggabungkan customer ordering, kasir/POS, dan administrasi bisnis dalam satu aplikasi web internal. Projek ini bertujuan menciptakan pengalaman yang terasa seperti sistem bisnis sungguhan, namun tetap sederhana karena merupakan projek pribadi/dummy.

### Struktur Utama

```
                         LUWENE
                           │
                  ┌────────┴────────┐
                  │                 │
              CUSTOMER            STAFF
                  │                 │
               USER          ┌──────┴──────┐
                             │             │
                           KASIR         ADMIN
                             │             │
                             └──────┬──────┘
                                    │
                                DATABASE
```

### Prinsip Dasar

- **Single System**: Semua role (User, Kasir, Admin) menggunakan satu aplikasi dan database
- **Shared Data**: Data transaksi mengalir real-time ke semua role tanpa perlu export/import manual
- **Role-Based Access**: Setiap role memiliki izin yang sesuai tugas mereka

---

## 1. Model Usaha

LUWENE memiliki kios/gerai fisik di mana pelanggan datang, memesan, dan pesanan diproses operasional.

### Produk yang Disediakan

- **Minuman**: Es teh, es jeruk, es kelapa muda, dan varian lainnya
- **Makanan Ringan**: Kerupuk, lalapan, tahu goreng, tempe goreng, kentang goreng
- **Menu Paket**: Kombinasi produk dengan varian (nasi, sambal, tingkat pedas)
- **Topping/Add-On**: Pilihan tambahan untuk produk
- **Produk Lain**: Produk konfigurabel sesuai kebutuhan

### Alur Operasional Dasar

```
User (Pelanggan)
   ↓
Melihat menu
   ↓
Memilih produk
   ↓
Mengatur varian / topping / jumlah
   ↓
Membuat pesanan
   ↓
Melakukan pembayaran
   ↓
Mendapat nomor/status pesanan
   ↓
Menunggu pesanan selesai
```

---

## 2. Konsep Website LUWENE

### Arsitektur Satu Website, Beberapa Role

```
Satu website → beberapa role → satu database → seluruh aktivitas kios saling terhubung
```

### Role Utama

#### 1. User / Pelanggan

Digunakan untuk proses pemesanan. User **tidak memiliki akses** ke fungsi administrasi atau kasir.

**Alur Pemesanan:**

```
User
   ↓
Melihat menu
   ↓
Memilih produk
   ↓
Mengatur varian / topping / jumlah
   ↓
Membuat pesanan
   ↓
Melakukan pembayaran
   ↓
Mendapat nomor/status pesanan
   ↓
Menunggu pesanan selesai
```

#### 2. Kasir

Bertanggung jawab terhadap transaksi.

**Fungsi Kasir:**

- Melihat pesanan masuk
- Memeriksa detail pesanan
- Memproses pembayaran
- Mengubah status pembayaran
- Mengonfirmasi transaksi
- Melihat transaksi yang sedang berjalan
- Melihat riwayat transaksi
- Membantu membuat pesanan jika diperlukan

**Alur Kasir:**

```
Pesanan dibuat User
   ↓
Kasir
   ↓
Verifikasi / pembayaran
   ↓
Pesanan dikonfirmasi
   ↓
Diproses
   ↓
Selesai
```

#### 3. Admin

Menangani pengelolaan sistem dan bisnis, bukan sekadar transaksi.

**Fungsi Admin:**

- Mengelola produk
- Mengelola kategori menu
- Mengelola harga
- Mengelola topping/add-on
- Mengelola ketersediaan menu
- Data user
- Data kasir
- Data transaksi
- Pengaturan sistem
- Laporan penjualan
- Informasi operasional lainnya

**Arsitektual Konsep:**

```
                 ┌──────────────┐
                 │    ADMIN     │
                 │  Manajemen   │
                 └──────┬───────┘
                        │
                        ▼
                 ┌──────────────┐
                 │   DATABASE   │
                 └──────┬───────┘
                        │
              ┌─────────┴─────────┐
              ▼                   ▼
       ┌────────────┐      ┌────────────┐
       │    USER    │      │   KASIR    │
       │  Ordering  │      │    POS     │
       └────────────┘      └────────────┘
```

**Catatan Penting: Hal terpenting: semuanya terhubung**

Karena ini adalah sistem untuk satu kios, user, kasir, dan admin **tidak dibuat sebagai aplikasi terpisah**. Mereka menggunakan sistem yang sama dan database yang sama.

*Contoh alur data real-time:*

```
User memesan Es Kopi Luwene.
   ↓
Data langsung masuk ke sistem.
   ↓
Kasir dapat melihat:
   ↓
ORDER #LUW-001
   ↓
Es Kopi Luwene
   ↓
Less Ice
   ↓
2x
   ↓
Total: Rp20.000
   ↓
Status: Menunggu Pembayaran
   ↓
Setelah kasir mengonfirmasi pembayaran:
   ↓
Status: Diproses
   ↓
User langsung melihat perubahan status.
   ↓
Ketika pesanan selesai:
   ↓
Status: Selesai
   ↓
Admin juga melihat transaksi di laporan.
```

**Tidak ada proses pemborosan:**

```
BUKAN:
User → export data → kirim ke kasir → input ulang → admin input ulang

MELALUI:
           DATABASE
                │
      ┌─────────┼─────────┐
      │         │         │
     User     Kasir     Admin
      │         │         │
      └─────────┼─────────┘
                │
         DATA REAL-TIME
```

---

## 3. Pertanyaan "Offline?"

### Perbedaan: Bukan Publik vs Tanpa Internet

**LUWENE BUKAN website publik.**

- Website tidak dimaksudkan untuk dibuka orang dari internet seperti `https://luwene.com`
- Sistem berjalan di lingkungan kios (local)

### Konsep Arsitektur

```
                    INTERNET
                       │
                       X
                Tidak tersedia
                untuk publik
                       │
                       │
              ┌────────▼────────┐
              │   KIOS LUWENE   │
              │                 │
              │  Web Application│
              │        +        │
              │    Database     │
              └─────────────────┘
                 │      │      │
                 ▼      ▼      ▼
               User   Kasir   Admin
```

### Akses & Deployment

- **Akses publik dari browser luar**: Tidak diperlukan
- **Lingkungan**: Dijalankan dalam lingkungan lokal/kios
- **Arsitektur**: Bisa dibuat seperti aplik web biasa (Frontend → Backend/API → Database) dalam lingkungan lokal

---

## 4. Gambaran Keseluruhan LUWENE

### Tiga Lapisan Utama

#### Customer Side

```
MENU
   ↓
CART
   ↓
ORDER
   ↓
PAYMENT
   ↓
ORDER STATUS
```

#### Cashier Side

```
ORDERS
   ↓
PAYMENT
   ↓
CONFIRMATION
   ↓
ORDER PROCESS
   ↓
COMPLETED
```

#### Admin Side

```
DASHBOARD
   ├── Products
   ├── Categories
   ├── Toppings
   ├── Orders
   ├── Users
   ├── Cashiers
   ├── Transactions
   └── Reports
```

### Satu Sumber Data

Semua lapisan menggunakan satu sumber data yang sama. Tidak ada duplikasi data atau proses input manual berulang.

---

## 5. Struktur Paling Sederhana

```
                         LUWENE
                           │
                  ┌────────┴────────┐
                  │                 │
              CUSTOMER            STAFF
                  │                 │
               USER          ┌──────┴──────┐
                             │             │
                           KASIR         ADMIN
                             │             │
                             └──────┬──────┘
                                    │
                                DATABASE
```

### Prinsip Utama

1. **Single System**: Satu aplikasi untuk semua role
2. **Shared Data**: Data mengalir real-time ke seluruh sistem
3. **Role-Based Access**: Setiap role memiliki izin sesuai tugas

---

## 6. Tujuan Proj

Proyek LUWENE dibuat untuk:

- Menciptakan pengalaman sistem bisnis sungguhan dalam format simulasi
- Menggabungkan customer ordering, kasir/POS, dan administrasi dalam satu aplikasi
- Sederhana enough sebagai projek pribadi/dummy, namun cukup complext untuk menguji arsitektur sistem
- Membuktikan konsep "single system, shared data, role-based access" dalam praktik

---

## 7. Daftar File Dokumentasi

File dokumentasi terkait LUWENE:

| File | Deskripsi |
|------|-----------|
| `PRD.md` | Product Requirements Document - spesifikasi fitur detail |
| `architecture.md` | Arsitektur teknis sistem |
| `ROADMAP-3PART.md` | Roadmap pembagian 3 part (Customer/Cashier/Admin) |
| `SKILL.md` | Skill dan teknologi yang digunakan |
| `LUWENE-CONCEPT.md` | *(file ini)* Konsep bisnis dan arsitektur umum |

---

*File ini dibuat untuk mengarahkan pengembangan website LUWENE sebagai simulasi sistem operasi kios kuliner dengan role-based access dan shared database architecture.*