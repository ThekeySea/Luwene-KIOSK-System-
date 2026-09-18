# LUWENE — Development Rules

## 1. General Rules

1. LUWENE adalah projek dummy/pribadi.
2. Jangan membuat sistem lebih kompleks dari kebutuhan.
3. Prioritaskan fitur yang benar-benar diperlukan.
4. Gunakan arsitektur yang mudah dipahami.
5. Hindari overengineering.
6. Semua data bisnis harus memiliki source of truth yang jelas.
7. Jangan membuat fitur hanya karena terlihat enterprise.

## 2. Architecture Rules

1. Gunakan satu aplikasi LUWENE.
2. Gunakan satu backend utama.
3. Gunakan satu database utama.
4. Semua role menggunakan database yang sama.
5. Jangan membuat database terpisah untuk setiap role.
6. Business logic berada di backend.
7. Frontend bukan sumber kebenaran bisnis.
8. Backend wajib melakukan authorization.
9. Gunakan service/repository separation jika kompleksitas meningkat.
10. Jangan membuat microservices untuk kebutuhan projek ini.

## 3. Role Rules

Role valid:

```text
USER
CASHIER
ADMIN
```

### USER

User hanya dapat mengakses data miliknya sendiri.

Tidak boleh:
- Melihat order user lain.
- Mengubah harga.
- Mengubah payment status secara langsung.
- Mengubah role.
- Mengakses admin endpoint.
- Mengakses cashier endpoint.

### CASHIER

Kasir dapat menangani transaksi dan order.

Tidak boleh:
- Mengubah role admin.
- Mengubah konfigurasi sistem.
- Mengubah historical transaction secara sembarangan.
- Mengubah harga tanpa permission yang ditentukan.

### ADMIN

Admin memiliki akses manajemen paling luas.

Admin tetap harus menggunakan API yang tervalidasi dan tidak boleh mengubah database secara langsung dari frontend.

## 4. Authentication Rules

1. Password wajib di-hash.
2. Password plaintext tidak boleh disimpan.
3. Session/token harus divalidasi backend.
4. Endpoint private harus membutuhkan authentication.
5. Role ditentukan berdasarkan data server.
6. Jangan mempercayai role yang dikirim client.

## 5. Authorization Rules

Authorization dilakukan pada backend.

Contoh:

```text
GET /orders/my
```

hanya mengembalikan order milik user yang sedang login.

Jangan menjadikan user ID dari client sebagai satu-satunya pemeriksaan ownership.

## 6. Product Rules

1. Product memiliki ID unik.
2. Harga disimpan pada backend/database.
3. Harga dari client tidak boleh dipercaya.
4. Product tidak tersedia tidak boleh dipesan.
5. Product historical sebaiknya dinonaktifkan daripada dihapus.
6. Category harus memiliki relasi valid.
7. Topping hanya dapat dipilih jika tersedia untuk produk tersebut.

## 7. Cart Rules

Cart adalah data sementara.

Saat checkout:

```text
Cart
 ↓
Backend Validation
 ↓
Price Calculation
 ↓
Create Order
```

Backend menghitung ulang:
- Harga produk.
- Harga variant.
- Harga topping.
- Quantity.
- Subtotal.
- Discount.
- Total.

## 8. Order Rules

Status:

```text
PENDING
CONFIRMED
PREPARING
READY
COMPLETED
CANCELLED
```

Valid transition:

```text
PENDING
 ├──> CONFIRMED
 └──> CANCELLED

CONFIRMED
 └──> PREPARING

PREPARING
 └──> READY

READY
 └──> COMPLETED
```

Invalid transition harus ditolak backend.

Contoh:

```text
COMPLETED → PENDING
COMPLETED → PREPARING
CANCELLED → CONFIRMED
```

## 9. Order Ownership Rules

User hanya boleh melihat order miliknya.

Cashier dapat melihat order yang diperlukan untuk operasional.

Admin dapat melihat seluruh order.

Mengetahui Order ID tidak otomatis memberikan akses.

## 10. Payment Rules

Payment status:

```text
UNPAID
PAID
FAILED
REFUNDED
```

1. User tidak dapat memalsukan status PAID.
2. Kasir hanya mengubah payment melalui mekanisme yang disediakan.
3. Payment amount berasal dari perhitungan server.
4. Historical payment tidak boleh diubah sembarangan.
5. Payment dummy tetap memiliki alur konsisten.

## 11. Transaction Rules

Minimal:

```text
transaction_id
order_id
amount
payment_method
payment_status
created_at
```

Total dari frontend tidak boleh menjadi sumber transaksi.

## 12. Database Rules

1. Gunakan foreign key jika didukung.
2. Gunakan unique constraint untuk data yang harus unik.
3. Gunakan timestamp untuk data penting.
4. Jangan menyimpan data yang sama di banyak tempat tanpa alasan.
5. Hindari hard delete terhadap historical data.
6. Gunakan inactive/soft delete jika historical record masih membutuhkannya.
7. Migration harus dapat direproduksi.
8. Schema harus terdokumentasi.

## 13. API Rules

1. Endpoint harus memiliki nama jelas.
2. Gunakan HTTP method sesuai kebutuhan.
3. Validasi request di backend.
4. Jangan mengandalkan validasi frontend.
5. Gunakan response/error format konsisten.
6. Jangan mengembalikan data sensitif.
7. Endpoint admin wajib authorization.
8. Endpoint user wajib ownership check.

## 14. Frontend Rules

Frontend harus:
- Menampilkan loading state.
- Menampilkan error state.
- Menampilkan empty state.
- Memberikan feedback setelah action.
- Mencegah double submit.
- Menonaktifkan action yang tidak tersedia.
- Menangani session expired.

Frontend tidak boleh:
- Menganggap route access sebagai bukti authorization.
- Menjadikan total client sebagai sumber kebenaran transaksi.
- Menggantikan backend authorization dengan hidden UI.

## 15. UI Rules

1. Gunakan design system konsisten.
2. Button dengan fungsi sama memiliki gaya konsisten.
3. Destructive action memiliki confirmation.
4. Status order mudah dikenali.
5. Informasi penting mudah ditemukan.
6. Dashboard tidak terlalu padat.
7. Gunakan empty state informatif.
8. Perhatikan responsive behavior.

## 16. Naming Rules

Gunakan naming konsisten:

```text
camelCase
PascalCase
UPPER_SNAKE_CASE
```

Contoh:

```text
orderStatus
paymentStatus
createdAt
updatedAt
```

Enum:

```text
PENDING
CONFIRMED
PREPARING
READY
COMPLETED
CANCELLED
```

Hindari:

```text
status2
data
temp
thing
```

## 17. Code Organization Rules

Pisahkan:

```text
UI
Business Logic
Data Access
Validation
Authentication
Authorization
```

Hindari menaruh seluruh logic dalam satu component/file.

Contoh:

```text
OrderPage
   ↓
Order Service
   ↓
Order Repository
   ↓
Database
```

## 18. Business Logic Rules

Business logic penting berada di backend.

Contoh:

```text
calculateOrderTotal()
validateOrder()
canChangeOrderStatus()
canAccessOrder()
processPayment()
```

Jangan hanya mengimplementasikan logic tersebut di frontend.

## 19. Error Handling Rules

Error harus:
- Jelas.
- Konsisten.
- Tidak membocorkan informasi sensitif.
- Memiliki error code jika diperlukan.

Contoh:

```text
PRODUCT_NOT_AVAILABLE
ORDER_NOT_FOUND
UNAUTHORIZED
FORBIDDEN
INVALID_ORDER_TRANSITION
PAYMENT_FAILED
```

## 20. Real-Time Rules

Jika menggunakan polling:
- Gunakan interval wajar.
- Hentikan polling ketika tidak diperlukan.
- Jangan melakukan request tanpa batas.

Jika menggunakan WebSocket:
- Handle reconnect.
- Handle connection failure.
- Jangan menjadikan koneksi real-time sebagai satu-satunya source of truth.

Database tetap menjadi source of truth.

## 21. Reporting Rules

Report dihitung dari data aktual.

Jangan:

```text
Admin Dashboard
    ↓
manualSales = 12500000
```

Gunakan:

```text
Orders
 +
Payments
 +
OrderItems
 ↓
Reporting Query
 ↓
Dashboard
```

Angka laporan harus dapat ditelusuri ke transaksi.

## 22. Testing Rules

Minimal test:

### Authentication
- Login valid.
- Login invalid.
- Unauthorized access.

### Authorization
- User tidak dapat membuka admin endpoint.
- User tidak dapat membuka order user lain.
- Cashier tidak dapat menjalankan admin-only action.

### Order
- Order valid dapat dibuat.
- Product unavailable ditolak.
- Total dihitung benar.
- Invalid status transition ditolak.

### Payment
- Payment valid berhasil.
- Payment amount tidak dapat dimanipulasi client.
- Invalid payment state ditolak.

## 23. Git Rules

Gunakan commit jelas:

```text
feat: add product management
feat: add cashier order queue
fix: validate order ownership
fix: prevent invalid order transition
refactor: extract order service
style: update cashier dashboard
docs: update architecture
```

Hindari:

```text
update
fix
changes
test
asdf
```

## 24. Scope Control

Sebelum menambahkan fitur:

1. Apakah fitur dibutuhkan oleh konsep LUWENE?
2. Apakah fitur dibutuhkan untuk demo?
3. Apakah fitur menambah kompleksitas signifikan?
4. Apakah fitur dapat ditunda?

Jika tidak penting, jangan tambahkan.

## 25. Core Principle

Jika terdapat konflik antara kompleksitas dan kebutuhan projek, pilih solusi yang lebih sederhana selama tidak merusak integritas data atau keamanan dasar.

LUWENE harus terasa seperti sistem bisnis nyata tanpa menjadi sistem enterprise yang tidak diperlukan.

```text
Simple
   +
Consistent
   +
Integrated
   +
Maintainable
   =
LUWENE
```
