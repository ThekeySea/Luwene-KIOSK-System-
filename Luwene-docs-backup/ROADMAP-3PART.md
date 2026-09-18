# ROADMAP 3-Part — LUWENE

**Status:** Phase 1 Foundation SELESAI  
**Architecture:** Laravel Modular Monolith  
**Tech Stack:** Laravel 13 + Blade/Livewire + Tailwind CSS + Alpine.js  
**Split:** Customer Pages | Cashier Pages | Admin Pages

---

# STATUS SAAT INI

Phase 1 sudah selesai:
- Laravel project initialized
- PostgreSQL/SQLite configured
- Auth (login/logout) + Sanctum tokens
- RBAC middleware (EnsureRole, EnsureRestaurantContext)
- 16 migration files (users, branches, restaurant_tables, dining_sessions, categories, products, product_variants, modifier_groups, modifiers, sambals, spice_levels, packages, package_items, product_modifier_groups, audit_logs)
- 16 Eloquent models
- Seeders (1 branch, 4 spice levels, 11 sambals, 10 categories, 36 products, 38 variants, 7 packages, 10 tables, 3 demo users)
- API routes auth

---

# PART 1: CUSTOMER PAGES

**Goal:** Customer dapat membuka menu, memilih produk, konfigurasi, checkout, bayar, dan track order secara live.

## C-1: Entry & Order Mode Selection

**Endpoint:**
- `GET /api/v1/restaurant/context` — validasi restaurant token
- `GET /api/v1/tables/{qr_token}` — resolve meja dari QR scan

**Pages:**
- `/` — Landing page, pilih Dine In / Take Away
- `/scan` — QR scanner handler, redirect ke Dine In atau Take Away

**Flow:**
```
Scan QR Meja → Dine In (table auto-detected)
ATAU
Buka dari terminal → Pilih Take Away
```

**Validation:**
- Dine In: QR token valid → resolve table → create/open dining session
- Take Away: signed restaurant token (short-lived session)

---

## C-2: Menu Browser

**Endpoint:**
- `GET /api/v1/categories` — daftar kategori
- `GET /api/v1/products?category={slug}` — produk per kategori
- `GET /api/v1/products/{slug}` — detail produk + variants + modifier rules
- `GET /api/v1/packages` — daftar paket signature
- `GET /api/v1/sambals` — daftar sambal
- `GET /api/v1/spice-levels` — daftar level pedas

**Pages:**
- `/menu` — Grid menu (kategori tabs + produk cards)
- `/menu/{slug}` — Detail produk + konfigurasi
- `/packages` — Daftar paket LUWENE

**Behavior:**
- Tab kategori horizontal scroll
- Produk card: image, name, base_price, badge "Paket Nasi tersedia"
- Produk unavailable: disabled card, "Habis"
- Harga tampil per variant (Ala Carte / Paket Nasi)
- Featured products di highlight section

---

## C-3: Product Configuration

**Pages:**
- `/menu/{slug}` — Full configuration page

**Flow:**
```
1. Pilih Tipe Pesanan (Ala Carte / Paket Nasi)
2. Jika Paket Nasi → Pilih Nasi (single select)
3. Pilih Sambal (single select, wajib)
4. Pilih Level Pedas (single select, wajib: 0-3)
5. Pilih Extra (multi select, optional)
6. Quantity
7. Tambah ke Cart
```

**UI Components:**
- Variant selector (radio buttons)
- Nasi selector (radio, conditional on Paket Nasi)
- Sambal selector (radio/grid)
- Level selector (visual: 4 tombol warna)
- Extra modifier (checkbox list)
- Quantity stepper (+/-)
- "Tambah ke Keranjang" CTA button

**Validation:**
- Server validates: variant exists, product available, modifier rules (min/max/required)
- Sambal wajib dipilih
- Level wajib dipilih

---

## C-4: Cart

**Pages:**
- `/cart` — Cart page

**Endpoint:**
- `GET /api/v1/cart` — get cart items (from session/localStorage)
- `POST /api/v1/cart/items` — add item
- `PATCH /api/v1/cart/items/{id}` — update item
- `DELETE /api/v1/cart/items/{id}` — remove item

**Cart Data:**
```json
{
  "order_mode": "DINE_IN",
  "table_id": "uuid",
  "dining_session_id": "uuid",
  "items": [
    {
      "product_id": "uuid",
      "product_name": "Ayam Goreng Luwene",
      "variant": { "id": "uuid", "name": "Paket Nasi", "price": 17000 },
      "modifiers": [
        { "type": "nasi", "name": "Nasi Uduk", "price": 0 },
        { "type": "sambal", "name": "Sambal Bawang", "price": 0 },
        { "type": "spice_level", "name": "Nampol", "level": 2, "price": 0 },
        { "type": "extra", "name": "Telur Ceplok", "price": 5000 }
      ],
      "quantity": 2,
      "subtotal": 44000
    }
  ],
  "subtotal": 44000
}
```

**Behavior:**
- Cart persistent via localStorage (offline-ready)
- Edit item: ubah quantity, ubah modifier
- Delete item
- Order mode display (Dine In: "Meja 5" / Take Away)
- Subtotal per item & grand subtotal

---

## C-5: Checkout & Payment

**Pages:**
- `/checkout` — Checkout summary + payment selection
- `/payment` — Payment processing
- `/order/{id}` — Order confirmation

**Endpoint:**
- `POST /api/v1/orders` — create order (idempotent via client_order_id)
- `GET /api/v1/orders/{id}` — order detail
- `POST /api/v1/orders/{id}/payment` — initiate payment

**Checkout Display:**
```
Order Type: Dine In - Meja 5
─────────────────────────────
Ayam Goreng Luwene (Paket Nasi)
  Nasi Uduk | Sambal Bawang | Level 2
  2x Rp17.000 = Rp34.000

Subtotal: Rp34.000
Tax (10%): Rp3.400
─────────────────────────────
Total: Rp37.400

Payment Method:
( ) Cash
( ) QRIS
```

**Rules:**
- Server calculate semua harga
- Customer tidak boleh edit grand total
- Price mismatch → reject + refresh
- idempotency key prevent duplicate order
- After payment: order status = PAID, redirect to order tracking

---

## C-6: Order Tracking (Realtime)

**Pages:**
- `/order/{id}` — Order tracking page (realtime)

**WebSocket Channels:**
- `private-order.{orderId}` — customer only

**Display:**
```
┌─────────────────────────────┐
│  Order #LW-000123           │
│  Status: PREPARING          │
│                             │
│  ● Dibuat    ✓              │
│  ● Dibayar   ✓              │
│  ● Diproses  ← sedang ini  │
│  ● Siap                     │
│  ● Selesai                  │
│                             │
│  [Realtime status update]   │
└─────────────────────────────┘
```

**Behavior:**
- Status update via WebSocket, no refresh needed
- Fallback: polling if WebSocket disconnects
- Take Away: additional "Ready for Pickup" → "Picked Up" status
- Sound/vibration notification on status change

---

# PART 2: CASHIER PAGES

**Goal:** Kasir dapat memantau order, memverifikasi pembayaran, mengubah status order, dan mengatur availability menu — semua secara live.

## K-1: Cashier Login & Dashboard

**Pages:**
- `/kasir` — Cashier dashboard (redirect to login if not authed)

**Dashboard Layout:**
```
┌──────────────────────────────────────────────┐
│  KASIR DASHBOARD          [Meja X] [Logout]  │
├──────────────────────────────────────────────┤
│                                              │
│  ┌──────────────┐  ┌──────────────────────┐  │
│  │ ORDER BARU   │  │ PENDING PAYMENT      │  │
│  │     3        │  │        2             │  │
│  └──────────────┘  └──────────────────────┘  │
│                                              │
│  ┌──────────────────────────────────────────┐│
│  │ ORDER LIST (realtime)                    ││
│  │ #LW-001 | Meja 5 | Dine In | Rp37.400  ││
│  │ #LW-002 | Take Away | Rp45.000          ││
│  └──────────────────────────────────────────┘│
│                                              │
└──────────────────────────────────────────────┘
```

**Endpoint:**
- `GET /api/v1/cashier/orders` — list all orders (branch-scoped)
- `GET /api/v1/cashier/orders/{id}` — order detail

**WebSocket Channels:**
- `private-branch.{branchId}.cashier` — receive new orders + status changes

---

## K-2: Order Management

**Pages:**
- `/kasir/orders` — Order list with filters
- `/kasir/orders/{id}` — Order detail + actions

**Features:**
- Filter: All / Pending Payment / Preparing / Ready / Completed
- Each order card shows:
  - Order number
  - Table (if Dine In) or "Take Away"
  - Items summary
  - Total price
  - Payment status badge
  - Fulfillment status badge
  - Time elapsed
- Actions per order:
  - Mark as PREPARING
  - Mark as READY
  - Mark as COMPLETED
  - For Take Away: Mark as PICKED_UP

**Endpoint:**
- `PATCH /api/v1/cashier/orders/{id}/status` — change order status
- `POST /api/v1/cashier/orders/{id}/verify-payment` — verify cash payment

**Rules:**
- Status transitions validated server-side
- Dine In: WAITING → PREPARING → READY → COMPLETED
- Take Away: WAITING → PREPARING → READY → PICKED_UP → COMPLETED
- Broadcast status change to customer channel

---

## K-3: Payment Verification

**Pages:**
- `/kasir/orders/{id}` — Payment section

**Cash Flow:**
1. Customer selects "Cash" at checkout
2. Kasir sees "Menunggu Pembayaran" badge
3. Kasir receives uang
4. Kasir clicks "Verifikasi Cash" → input jumlah diterima
5. System calculates kembalian
6. Confirm → Payment status = PAID
7. Broadcast to customer: "Pembayaran berhasil"

**QRIS Flow:**
1. Customer selects "QRIS"
2. QR code displayed to customer
3. Customer scans with mobile banking
4. Webhook confirms payment
5. Payment status = PAID
6. Broadcast to customer

**Endpoint:**
- `POST /api/v1/cashier/orders/{id}/verify-payment` — verify cash
- `GET /api/v1/cashier/orders/{id}/payment-status` — check payment status

---

## K-4: Menu Availability Toggle

**Pages:**
- `/kasir/menu` — Menu availability management

**Features:**
- List semua produk per kategori
- Toggle switch: Available / Unavailable
- When toggle OFF:
  - Produk disabled di customer UI secara realtime
  - Produk yang sudah di cart customer: validasi saat checkout
- Visual indicator: green (available) / red (unavailable)

**Endpoint:**
- `PATCH /api/v1/cashier/products/{id}/availability` — toggle availability

**WebSocket:**
- Broadcast `PRODUCT_AVAILABILITY_CHANGED` to `public-branch.{branchId}.catalog`
- Customer menu updates live

---

## K-5: Table Management (Dine In)

**Pages:**
- `/kasir/tables` — Table overview

**Display:**
```
┌──────┬──────┬──────┬──────┬──────┐
│  1   │  2   │  3   │  4   │  5   │
│ 🟢   │ 🔴   │ 🟡   │ 🟢   │ 🔴   │
│ 2pk  │ 2pk  │ 4pk  │ 4pk  │ 4pk  │
├──────┼──────┼──────┼──────┼──────┤
│  6   │  7   │  8   │  9   │  10  │
│ 🟢   │ 🟢   │ 🟢   │ 🟡   │ 🟢   │
│ 6pk  │ 6pk  │ 8pk  │ 8pk  │ 10pk │
└──────┴──────┴──────┴──────┴──────┘

🟢 Available  🔴 Occupied  🟡 Reserved
```

**Behavior:**
- Auto-update: when customer scans QR → table status changes to OCCUPIED
- When session closed → table status back to AVAILABLE
- Click table → see active orders for that table
- WebSocket: `TABLE_STATUS_CHANGED` to cashier channel

**Endpoint:**
- `GET /api/v1/cashier/tables` — list tables with status
- `GET /api/v1/cashier/tables/{id}/orders` — orders for table

---

# PART 3: ADMIN PAGES

**Goal:** Admin dapat mengelola seluruh katalog, harga, paket, sambal, staff, melihat analytics, dan audit logs.

## A-1: Admin Dashboard

**Pages:**
- `/admin` — Admin dashboard

**Layout:**
```
┌──────────────────────────────────────────────────┐
│  ADMIN DASHBOARD                                 │
├──────────────────────────────────────────────────┤
│                                                  │
│  Revenue Hari Ini    Transaksi Hari Ini           │
│  Rp 2.450.000       23 order                     │
│                                                  │
│  AOV    Dine In    Take Away    Cancelled         │
│  106K   15 order   8 order     1 order           │
│                                                  │
│  ┌──────────────────────────────────────────────┐│
│  │ Revenue Chart (7 days / 30 days)             ││
│  └──────────────────────────────────────────────┘│
│                                                  │
│  Top Selling    Peak Hours    Sambal Popularity   │
│  1. Ayam Goreng  12:00-13:00  Sambal Bawang      │
│  2. Kambing      18:00-19:00  Level 2 Nampol     │
│  3. Sate Sapi                   Level 1 Nyolek    │
│                                                  │
└──────────────────────────────────────────────────┘
```

**Endpoint:**
- `GET /api/v1/admin/analytics/overview` — summary stats
- `GET /api/v1/admin/analytics/revenue` — revenue by period
- `GET /api/v1/admin/analytics/products` — best sellers
- `GET /api/v1/admin/analytics/sambals` — sambal popularity
- `GET /api/v1/admin/analytics/spice-levels` — spice distribution
- `GET /api/v1/admin/analytics/order-modes` — Dine In vs Take Away
- `GET /api/v1/admin/analytics/hourly` — peak hours

**WebSocket:**
- `private-branch.{branchId}.admin` — live revenue counter, live order count

---

## A-2: Product Management (CRUD)

**Pages:**
- `/admin/products` — Product list
- `/admin/products/create` — Create product
- `/admin/products/{id}/edit` — Edit product

**Features:**
- Table: name, category, base_price, is_active, is_available, is_featured
- Create/Edit form:
  - Name
  - Category (select)
  - Description
  - Image upload
  - Base price
  - Status (active/inactive)
  - Featured toggle
  - Sort order
- Soft delete / archive
- After save: broadcast `PRODUCT_UPDATED` to customer + cashier

**Endpoint:**
- `GET /api/v1/admin/products` — list products
- `POST /api/v1/admin/products` — create product
- `PATCH /api/v1/admin/products/{id}` — update product
- `DELETE /api/v1/admin/products/{id}` — soft delete product

---

## A-3: Product Variant Management

**Pages:**
- `/admin/products/{id}/variants` — Variant management

**Features:**
- Per produk: define variants (Ala Carte, Paket Nasi)
- Each variant: code, name, price, is_active
- Dynamic pricing per variant
- After save: broadcast update

**Endpoint:**
- `POST /api/v1/admin/products/{id}/variants` — add variant
- `PATCH /api/v1/admin/variants/{id}` — update variant
- `DELETE /api/v1/admin/variants/{id}` — delete variant

---

## A-4: Category Management (CRUD)

**Pages:**
- `/admin/categories` — Category list
- `/admin/categories/create` — Create category
- `/admin/categories/{id}/edit` — Edit category

**Features:**
- Name, slug (auto-generated), description, sort_order, is_active
- Drag & drop sort order
- After save: broadcast `CATEGORY_UPDATED`

**Endpoint:**
- `GET /api/v1/admin/categories` — list
- `POST /api/v1/admin/categories` — create
- `PATCH /api/v1/admin/categories/{id}` — update
- `DELETE /api/v1/admin/categories/{id}` — delete

---

## A-5: Package Management (CRUD)

**Pages:**
- `/admin/packages` — Package list
- `/admin/packages/create` — Create package
- `/admin/packages/{id}/edit` — Edit package

**Features:**
- Name, code, description, price, image
- Package items:
  - Add product
  - Quantity per product
  - Role: FIXED / CHOICE
  - is_required
- After save: broadcast `PACKAGE_UPDATED`

**Endpoint:**
- `GET /api/v1/admin/packages` — list
- `POST /api/v1/admin/packages` — create
- `PATCH /api/v1/admin/packages/{id}` — update
- `DELETE /api/v1/admin/packages/{id}` — delete
- `POST /api/v1/admin/packages/{id}/items` — add item
- `PATCH /api/v1/admin/package-items/{id}` — update item
- `DELETE /api/v1/admin/package-items/{id}` — remove item

---

## A-6: Sambal Management (CRUD)

**Pages:**
- `/admin/sambals` — Sambal list
- `/admin/sambals/create` — Create sambal
- `/admin/sambals/{id}/edit` — Edit sambal

**Features:**
- Name, description, price (for premium sambal), is_available, is_active
- After save: broadcast `SAMBAL_UPDATED`

**Endpoint:**
- `GET /api/v1/admin/sambals` — list
- `POST /api/v1/admin/sambals` — create
- `PATCH /api/v1/admin/sambals/{id}` — update
- `DELETE /api/v1/admin/sambals/{id}` — delete

---

## A-7: Staff Management

**Pages:**
- `/admin/staff` — Staff list
- `/admin/staff/create` — Create staff
- `/admin/staff/{id}/edit` — Edit staff

**Features:**
- List: name, email, role, status, branch, last_login
- Create: name, email, password, role (CASHIER/ADMIN), branch
- Edit: name, email, role, status
- Toggle active/inactive

**Endpoint:**
- `GET /api/v1/admin/staff` — list staff
- `POST /api/v1/admin/staff` — create staff
- `PATCH /api/v1/admin/staff/{id}` — update staff
- `DELETE /api/v1/admin/staff/{id}` — deactivate staff

---

## A-8: Audit Log Viewer

**Pages:**
- `/admin/audit-logs` — Audit log list

**Features:**
- Filter: by actor, action, entity type, date range
- Display: timestamp, actor, action, entity, before/after diff
- Pagination

**Endpoint:**
- `GET /api/v1/admin/audit-logs` — list audit logs
- `GET /api/v1/admin/audit-logs/{id}` — detail

---

# CROSS-CUTTING CONCERNS

## Realtime Events (Laravel Reverb)

### Event List
```
ORDER_CREATED            → cashier, admin
ORDER_UPDATED            → cashier, admin
ORDER_STATUS_CHANGED     → customer, cashier, admin
PAYMENT_CREATED          → cashier, admin
PAYMENT_STATUS_CHANGED   → customer, cashier, admin
PRODUCT_AVAILABILITY_CHANGED → customer, cashier
PRODUCT_UPDATED          → customer, cashier, admin
CATEGORY_UPDATED         → customer, cashier, admin
SAMBAL_UPDATED           → customer, cashier, admin
PACKAGE_UPDATED          → customer, cashier, admin
TABLE_STATUS_CHANGED     → cashier, admin
```

### Channel Structure
```
private-order.{orderId}              → customer (own order only)
private-branch.{branchId}.cashier    → cashier + admin
private-branch.{branchId}.admin      → admin only
public-branch.{branchId}.catalog     → all (or private if strict)
```

---

## Offline Support (Phase 6)

### Cache First (IndexedDB)
- Menu / categories / sambal / spice levels / modifiers
- Cart items
- Table context

### Network First
- Order status
- Payment status
- Current availability

### Sync Queue
- Offline order → IndexedDB → sync on reconnect
- client_order_id for idempotency
- Status: PENDING → SYNCING → SYNCED / FAILED

---

## PWA Setup

- Service Worker: cache app shell + static assets
- Manifest: name "LUWENE", display standalone
- Offline fallback page
- Install prompt on supported devices

---

# IMPLEMENTATION ORDER

## Track A: Customer (Start First)
```
C-1 → C-2 → C-3 → C-4 → C-5 → C-6
```

## Track B: Cashier (Start After C-4)
```
K-1 → K-2 → K-3 → K-4 → K-5
```

## Track C: Admin (Start After C-5)
```
A-1 → A-2 → A-3 → A-4 → A-5 → A-6 → A-7 → A-8
```

## Shared (Parallel)
```
Realtime (C-6, K-2, K-4, A-1)
Database: orders, order_items, order_item_modifiers, payments (needs migration)
```

---

# ESTIMATED TIMELINE

| Track | Phase | Description | Duration |
|-------|-------|-------------|----------|
| **A** | C-1 | Entry & Order Mode | 1 day |
| **A** | C-2 | Menu Browser | 2 days |
| **A** | C-3 | Product Configuration | 2 days |
| **A** | C-4 | Cart | 1 day |
| **A** | C-5 | Checkout & Payment | 2 days |
| **A** | C-6 | Order Tracking | 1 day |
| **B** | K-1 | Cashier Dashboard | 1 day |
| **B** | K-2 | Order Management | 2 days |
| **B** | K-3 | Payment Verification | 1 day |
| **B** | K-4 | Menu Availability | 1 day |
| **B** | K-5 | Table Management | 1 day |
| **C** | A-1 | Admin Dashboard | 2 days |
| **C** | A-2 | Product CRUD | 2 days |
| **C** | A-3 | Variant Management | 1 day |
| **C** | A-4 | Category CRUD | 0.5 day |
| **C** | A-5 | Package CRUD | 1 day |
| **C** | A-6 | Sambal CRUD | 0.5 day |
| **C** | A-7 | Staff Management | 1 day |
| **C** | A-8 | Audit Logs | 0.5 day |
| **X** | — | Realtime + PWA + Testing | 3 days |
| | | **TOTAL** | **~24 days** |
