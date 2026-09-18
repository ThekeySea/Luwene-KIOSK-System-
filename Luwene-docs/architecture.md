# LUWENE — Architecture

## 1. Architecture Overview

LUWENE menggunakan arsitektur web application sederhana dengan satu frontend, satu backend, dan satu database.

```text
                    LUWENE WEB APP
                          |
             +------------+------------+
             |            |            |
           USER         CASHIER       ADMIN
             |            |            |
             +------------+------------+
                          |
                       FRONTEND
                          |
                         API
                          |
                       BACKEND
                          |
                       DATABASE
```

Tujuan utama adalah memastikan seluruh role menggunakan sumber data yang sama.

## 2. Deployment Model

LUWENE adalah aplikasi internal untuk lingkungan kios.

Tidak membutuhkan public hosting.

```text
        KIOS / LOCAL NETWORK

        +------------------+
        | LUWENE SERVER    |
        |                  |
        | Frontend         |
        | Backend          |
        | Database         |
        +--------+---------+
                 |
        +--------+--------+
        |        |        |
      User    Cashier    Admin
```

Server dapat berjalan pada:
- Komputer kios.
- Local server.
- Komputer development.

Aplikasi tidak harus dapat diakses dari internet publik.

## 3. Application Architecture

```text
Frontend
   |
   | HTTP / API
   v
Backend
   |
   +-- Authentication
   +-- Authorization
   +-- Business Logic
   +-- Order Service
   +-- Payment Service
   +-- Product Service
   +-- Reporting Service
   |
   v
Database
```

Gunakan separation of concerns, tetapi jangan overengineering.

## 4. Frontend

Frontend bertanggung jawab terhadap:
- UI.
- Routing.
- Form.
- Client-side validation.
- State management.
- API communication.
- Loading/error/empty state.
- Role-based UI.

Struktur konseptual:

```text
src/
├── components/
├── layouts/
├── pages/
│   ├── user/
│   ├── cashier/
│   └── admin/
├── features/
│   ├── auth/
│   ├── products/
│   ├── cart/
│   ├── orders/
│   ├── payments/
│   └── reports/
├── services/
├── hooks/
├── utils/
└── types/
```

## 5. Backend

Backend adalah pusat business logic.

Tanggung jawab:
- Authentication.
- Authorization.
- Validation.
- Order creation.
- Order state transition.
- Payment processing.
- Product management.
- User management.
- Reporting.
- Database access.

Struktur konseptual:

```text
src/
├── controllers/
├── services/
├── repositories/
├── models/
├── middleware/
├── routes/
├── validators/
├── utils/
└── config/
```

## 6. Authentication

Authentication dilakukan di backend.

```text
POST /auth/login
       ↓
Validate credentials
       ↓
Create session/token
       ↓
Return authenticated user
```

Role:
- USER
- CASHIER
- ADMIN

Frontend bukan sumber authorization. Backend tetap memeriksa permission.

## 7. Authorization

Gunakan role-based access control (RBAC).

```text
USER
 ├── read products
 ├── create own orders
 └── read own orders

CASHIER
 ├── read orders
 ├── manage payments
 └── update order status

ADMIN
 ├── manage products
 ├── manage users
 ├── read all orders
 ├── read transactions
 └── read reports
```

Authorization dilakukan pada API/backend.

## 8. Database

Database adalah single source of truth.

Entitas utama:

```text
User
Category
Product
ProductVariant
Topping
Order
OrderItem
Payment
Transaction
```

Relasi konseptual:

```text
User
 |
 +----< Order
          |
          +----< OrderItem >---- Product
          |                      |
          |                      +---- Category
          |
          +---- Payment
```

## 9. Order Data Flow

```text
USER
 |
 | Create Order
 v
API
 |
 | Validate
 v
Order Service
 |
 | Create Order + Items
 v
DATABASE
 |
 +------------------+
 |                  |
 v                  v
CASHIER            USER
 |                  |
 | Process          | Track
 v                  |
DATABASE -----------+
```

Perubahan order selalu disimpan di database.

## 10. Order State Machine

```text
PENDING
  |
  +--> CANCELLED
  |
  v
CONFIRMED
  |
  v
PREPARING
  |
  v
READY
  |
  v
COMPLETED
```

Backend menolak transition yang tidak valid.

## 11. Payment Architecture

Payment adalah domain terpisah dari order.

```text
Order
  |
  +---- Payment
```

Untuk projek dummy:

```text
Payment
   ↓
Simulated Payment Processing
   ↓
PAID / FAILED
```

Tidak diperlukan payment gateway eksternal.

## 12. Product Architecture

```text
Category
   |
   +---- Product
            |
            +---- Variant
            |
            +---- Topping
```

## 13. Reporting Architecture

Report tidak menyimpan angka penjualan manual.

```text
Orders
  +
Payments
  +
OrderItems
  |
  v
Reporting Service
  |
  +-- Revenue
  +-- Order Count
  +-- Product Sales
  +-- Category Sales
  +-- Average Order Value
```

Untuk projek dummy, query langsung sudah cukup.

## 14. API Design

Resource utama:

```text
/auth
/products
/categories
/toppings
/orders
/payments
/users
/reports
```

Contoh:

```text
GET    /products
GET    /products/:id

POST   /orders
GET    /orders/:id
GET    /orders/my

PATCH  /orders/:id/status

POST   /payments
GET    /payments/:id

GET    /admin/reports/sales
```

Endpoint admin wajib dilindungi authorization.

## 15. Error Handling

Response error harus konsisten.

```json
{
  "success": false,
  "message": "Order status transition is not allowed",
  "code": "INVALID_ORDER_TRANSITION"
}
```

Frontend menerjemahkan error menjadi feedback yang dapat dipahami.

## 16. Real-Time Updates

Untuk projek dummy, polling sederhana cukup.

```text
User
 |
 | GET /orders/:id
 | periodically
 v
Backend
 |
 v
Database
```

Jika kebutuhan meningkat, dapat menggunakan WebSocket atau Server-Sent Events.

Database tetap menjadi source of truth.

## 17. Security Boundary

Minimal:
- Password hashing.
- Authentication.
- Authorization.
- Input validation.
- Server-side validation.
- Protection terhadap unauthorized API access.
- Jangan menyimpan password plaintext.
- Jangan mempercayai role dari frontend.
- Jangan menerima total harga dari client sebagai sumber kebenaran.

Total order dihitung ulang oleh backend.

## 18. Architectural Principle

```text
Single Application
        +
Single Backend
        +
Single Database
        +
Role-Based Access
        =
Integrated LUWENE System
```

Jangan membuat User, Cashier, dan Admin sebagai tiga aplikasi/backend/database terpisah tanpa kebutuhan nyata.
