# 🛒 Pasar Santri - E-Commerce Marketplace

<p align="center">
  <strong>Platform Marketplace Multi-Seller untuk Produk Halal & Lokal dari Komunitas Pesantren</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.31-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11.31">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/PostgreSQL-16-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL 16">
  <img src="https://img.shields.io/badge/Bootstrap-5.2-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/TailwindCSS-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS 3.4">
</p>

---

## 📋 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Arsitektur](#-arsitektur)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Development](#-development)
- [Database](#-database)
- [API Integration](#-api-integration)
- [Screenshots](#-screenshots)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Project

**Pasar Santri** adalah platform e-commerce marketplace multi-seller yang dirancang khusus untuk memberdayakan alumni pesantren dan pelaku UMKM lokal dalam memasarkan produk-produk halal mereka secara digital. Platform ini menggabungkan fitur-fitur e-commerce modern dengan sistem verifikasi seller (KYC) yang ketat untuk menjamin kepercayaan dan kehalalan produk.

### 🌟 Visi & Misi

**Visi:**  
Menjadi platform marketplace terpercaya untuk produk halal dan lokal dari komunitas pesantren di Indonesia.

**Misi:**
- Memberdayakan UMKM pesantren dengan akses teknologi digital
- Menjamin kehalalan produk melalui sistem KYC yang ketat
- Menyediakan ekosistem e-commerce lengkap dengan integrasi logistik
- Membangun kepercayaan antara seller dan buyer

### 👥 Role & Stakeholder

Platform ini melayani 3 role utama:

1. **👤 Customer/Buyer** - Konsumen yang mencari produk halal & lokal terpercaya
2. **🏪 Seller** - Alumni pesantren & UMKM yang menjual produk halal
3. **👨‍💼 Admin** - Pengelola platform yang memverifikasi seller dan mengelola sistem

---

## ✨ Fitur Utama

### 🛍️ Untuk Customer (Buyer)

- ✅ **Browse & Search** - Pencarian produk dengan filter kategori, harga, rating
- ✅ **Product Detail** - Gallery images, variants, spesifikasi lengkap
- ✅ **Wishlist** - Simpan produk favorit
- ✅ **Shopping Cart** - Keranjang belanja dengan validasi stok real-time
- ✅ **Multi-Address** - Kelola beberapa alamat pengiriman
- ✅ **Checkout** - Integrasi 19 kurir Indonesia dengan ongkir real-time
- ✅ **Promo Code** - Gunakan kode promo untuk diskon
- ✅ **Order Tracking** - Lacak pesanan via Biteship API
- ✅ **Notifications** - Notifikasi real-time untuk status pesanan
- ✅ **Order History** - Riwayat pembelian lengkap

### 🏪 Untuk Seller

#### 📝 Onboarding & Verifikasi
- ✅ **KYC Verification** - Submit dokumen identitas (KTP/Passport/SIM)
- ✅ **Shop Setup** - Buat toko dengan nama, logo, alamat, social links
- ✅ **Reapply Mechanism** - Ajukan ulang KYC jika ditolak

#### 📦 Product Management
- ✅ **CRUD Products** - Kelola produk dengan variants & multi-image
- ✅ **Bulk Actions** - Aktivasi/deaktivasi/hapus produk massal
- ✅ **Category Management** - Kategori lokal per-toko
- ✅ **Stock Management** - Kelola stok per variant
- ✅ **Media Library** - Upload gambar produk (default, hover, gallery)

#### 📋 Order Management
- ✅ **7 Status Flow** - paid → confirmed → processing → shipped → delivered → finished
- ✅ **Biteship Integration** - Buat order pengiriman langsung ke kurir
- ✅ **Shipping Label PDF** - Generate label A5 dengan barcode
- ✅ **Order Filtering** - Filter by status, date range, search
- ✅ **Courier Selection** - Pilih kurir dan service saat processing

#### 🚚 Shipping Management
- ✅ **Toggle Couriers** - Enable/disable kurir per-service atau per-courier
- ✅ **Dual-Level Control** - Admin activate + Seller enable = tampil di checkout

#### 💰 Financial Management
- ✅ **Wallet Dashboard** - Saldo, pending in/out, earnings
- ✅ **Withdrawal** - Request penarikan dana ke rekening bank
- ✅ **Withdrawal PIN** - 6 digit PIN untuk keamanan penarikan
- ✅ **Bank Accounts** - Kelola rekening bank (CRUD, set default)
- ✅ **Transaction History** - Riwayat transaksi dengan filter

#### 📊 Analytics & Dashboard
- ✅ **Revenue Analytics** - Total, growth %, monthly/weekly chart
- ✅ **Top Products** - Produk terlaris dengan total penjualan
- ✅ **Top Customers** - Customer dengan pembelian terbanyak
- ✅ **Orders by Status** - Breakdown pesanan per status
- ✅ **Cache Optimization** - Dashboard data di-cache untuk performa

### 👨‍💼 Untuk Admin

#### 📊 Dashboard & Analytics
- ✅ **Platform Statistics** - Total users, shops, products, orders, KYC
- ✅ **Revenue Analytics** - Total revenue, monthly/weekly/daily breakdown
- ✅ **Monthly Chart** - Grafik revenue 12 bulan terakhir
- ✅ **Recent Activity** - Aktivitas terbaru di platform

#### 👥 Seller Management
- ✅ **List Sellers** - Search, filter (active/inactive/suspended), sort
- ✅ **Seller Detail** - Shop info, KYC history, products, orders, stats
- ✅ **Activate/Deactivate** - Kontrol status seller
- ✅ **Suspend/Unsuspend** - Suspend toko dengan alasan

#### 📝 KYC Management
- ✅ **Review Applications** - Lihat detail KYC dengan dokumen
- ✅ **Approve** - Setujui KYC (auto-assign role seller)
- ✅ **Reject** - Tolak KYC dengan alasan (remove role seller)
- ✅ **Bulk Actions** - Approve/reject/delete multiple KYC

#### 📦 Order Management
- ✅ **View All Orders** - Semua order di platform
- ✅ **Bypass Payment** - Ubah status pending → paid (individual/bulk)
- ✅ **Order Details** - Detail lengkap order dengan tracking

#### 🚚 Shipping Management
- ✅ **Sync from Biteship** - Sync daftar kurir dari API
- ✅ **Toggle Methods** - Activate/deactivate per-method atau per-courier
- ✅ **Logo Mapping** - Mapping logo untuk 19 kurir Indonesia

#### 🎨 Marketing Tools
- ✅ **Banner Management** - 8 jenis banner homepage
- ✅ **Product Ads** - 5 kategori (flash sale, hot promo, big discount, new, <10K)
- ✅ **Auto-Suggest Engine** - Suggest produk otomatis berdasarkan kriteria
- ✅ **Promo Codes** - CRUD promo dengan usage tracking

#### ⚙️ System Configuration
- ✅ **Service Fee Config** - Atur payment fee (percent/fixed, min/max)
- ✅ **Global Variables** - Key-value config store untuk settings dinamis
- ✅ **Cache Management** - Clear system cache

---

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 11.31
- **Language:** PHP 8.2+
- **Database:** PostgreSQL 16 (Alpine)
- **Cache/Queue:** Redis 7 (Alpine) / Database driver
- **Authentication:** Laravel UI (Session-based) + Sanctum (API)
- **Authorization:** Spatie Permission (RBAC)

### Frontend
- **Build Tool:** Vite 6.0
- **CSS Framework:** Bootstrap 5.2 + TailwindCSS 3.4
- **JavaScript:** Vanilla JS + Axios 1.7
- **Templating:** Laravel Blade
- **Styling:** SASS/SCSS + PostCSS

### Key Packages
- **spatie/laravel-permission** (v6.19) - Role & Permission management
- **spatie/laravel-medialibrary** (v11.13) - File upload & media management
- **spatie/laravel-query-builder** (v6.3) - Advanced query building
- **barryvdh/laravel-snappy** (v1.0) - PDF generation (shipping labels)
- **milon/barcode** (v12.0) - Barcode generation (Code 128)
- **staudenmeir/eloquent-has-many-deep** (v1.20) - Deep relationships

### Infrastructure
- **Containerization:** Docker + Docker Compose
- **Web Server (Dev):** PHP Built-in Server (artisan serve)
- **File Storage:** Local filesystem (storage/app/public)

### Third-Party Services
- **Biteship API** - Logistik & pengiriman (19 kurir Indonesia)
  - Couriers listing
  - Real-time shipping rates
  - Order creation
  - Tracking & webhook

---

## 🏗️ Arsitektur

### Arsitektur Umum
```
Monolithic MVC + Service Layer
├── Server-Side Rendering (Blade)
├── Client-Side AJAX (Axios)
├── PostgreSQL dengan JSONB columns
├── Session-based Authentication
├── RBAC Authorization (3 roles, 50+ permissions)
└── Event-Driven Notifications
```

### Database Schema Highlights
- **UUID Primary Keys** - orders, shops, products, kyc_applications
- **JSONB Columns** - order_details, payment_detail, tracking_details, addresses
- **Soft Deletes** - orders, products, kyc_applications, shipping_methods
- **Optimized Indexes** - Performance optimization untuk queries

### Middleware Pipeline

**Seller Routes:**
```
Request → web → auth → has.approved.kyc → has.shop → check.shop.suspension → Controller
```

**Admin Routes:**
```
Request → web → auth → role:admin → Controller
```

**Buyer Routes:**
```
Request → web → auth → Controller
```

---

## 🚀 Instalasi

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer 2.8+
- Node.js 22.20+ & NPM 10.9+
- Docker & Docker Compose (untuk PostgreSQL & Redis)
- wkhtmltopdf (untuk PDF generation)

### Step 1: Clone Repository
```bash
git clone https://github.com/llccnnzz/pasar-santri.git
cd pasar-santri
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Start Docker Services
```bash
# Start PostgreSQL & Redis
docker-compose up -d
```

### Step 5: Database Setup
```bash
# Run migrations
php artisan migrate

# Seed database (roles, permissions, sample data)
php artisan db:seed
```

### Step 6: Storage Link
```bash
# Create symbolic link for storage
php artisan storage:link
```

### Step 7: Build Assets
```bash
# Build frontend assets
npm run build

# Or untuk development dengan hot reload
npm run dev
```

### Step 8: Start Development Server
```bash
# Start Laravel server
php artisan serve

# Start queue worker (terminal terpisah)
php artisan queue:listen --tries=1

# Start log viewer (optional, terminal terpisah)
php artisan pail --timeout=0
```

**Atau gunakan Composer script untuk run semua sekaligus:**
```bash
composer run dev
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## ⚙️ Konfigurasi

### Environment Variables

Edit file `.env` dan sesuaikan konfigurasi berikut:

#### Database (PostgreSQL)
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5434
DB_DATABASE=pasar_santri
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

#### Redis (Optional)
```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6382
```

#### Biteship API
```env
BITESHIP_API_KEY=your_biteship_api_key_here
BITESHIP_API_URL=https://api.biteship.com/v1
```

#### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@pasarsantri.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Session & Cache
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
```

---

## 💻 Development

### Development Commands

```bash
# Run development server dengan hot reload
npm run dev

# Build untuk production
npm run build

# Run queue worker
php artisan queue:listen --tries=1

# Run log viewer
php artisan pail --timeout=0

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Code style fixer
./vendor/bin/pint

# Run tests
php artisan test
```

### Composer Scripts

```bash
# Run all development services (server, queue, logs, vite)
composer run dev
```

### Default Credentials

Setelah seeding, gunakan credentials berikut:

**Admin:**
```
Email: admin@pasarsantri.com
Password: password
```

**Seller (dengan KYC approved):**
```
Email: seller@pasarsantri.com
Password: password
```

**Customer:**
```
Email: customer@pasarsantri.com
Password: password
```

---

## 🗄️ Database

### Migrations

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset database
php artisan migrate:fresh

# Reset & seed
php artisan migrate:fresh --seed
```

### Seeders

```bash
# Seed all
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=RoleAndPermissionSeeder
php artisan db:seed --class=ShippingMethodSyncSeeder
php artisan db:seed --class=ProductSeeder
```

### Key Tables

- **users** - User accounts (customer, seller, admin)
- **shops** - Toko seller (UUID, media, addresses)
- **products** - Produk (UUID, variants, JSONB specs)
- **orders** - Pesanan (UUID, JSONB order_details, payment_detail)
- **kyc_applications** - Verifikasi seller (UUID, media documents)
- **shipping_methods** - Metode pengiriman (sync dari Biteship)
- **shop_shipping_methods** - Toggle kurir per-shop
- **promotions** - Kode promo
- **product_ads** - Iklan produk homepage
- **global_variables** - Config dinamis (payment fee, banners)

---

## 🔌 API Integration

### Biteship API

Platform ini terintegrasi dengan **Biteship API** untuk logistik end-to-end.

#### Endpoints yang Digunakan:

1. **GET /couriers** - Mendapatkan daftar kurir Indonesia
2. **POST /rates/couriers** - Hitung ongkos kirim real-time
3. **POST /orders** - Buat order pengiriman
4. **GET /trackings/{id}** - Tracking status pengiriman
5. **Webhook** - Auto-update status (shipped/delivered)

#### Kurir yang Didukung (19):
AnterAja, Borzo, Deliveree, Gojek, Grab, ID Express, JNE, J&T, Lalamove, Lion Parcel, Ninja Express, Paxel, Pos Indonesia, RPX, SAP Express, Sentral Cargo, SiCepat, TIKI, Wahana

#### Service Class:
```php
app/Services/BiteshipService.php
```

#### Konfigurasi:
```php
config/services.php
```

---

## 📸 Screenshots

### Customer Interface
- Homepage dengan banner & product ads
- Product listing & detail
- Shopping cart dengan validasi stok
- Checkout dengan integrasi kurir
- Order tracking & history

### Seller Dashboard
- Analytics dashboard (revenue, growth, charts)
- Product management (CRUD, variants, bulk actions)
- Order management (7 status views)
- Shipping label PDF generation
- Wallet & withdrawal management

### Admin Panel
- Platform statistics & revenue analytics
- Seller & KYC management
- Shipping method sync & toggle
- Banner & product ads management
- Promo code & service fee configuration

---

## 🤝 Kontribusi

Project ini dikembangkan sebagai solusi e-commerce untuk komunitas pesantren. Kontribusi dan saran sangat diterima!

### Development Guidelines

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Code Style

Project ini menggunakan **Laravel Pint** untuk code style. Jalankan sebelum commit:

```bash
./vendor/bin/pint
```

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

## 📞 Kontak & Support

Untuk pertanyaan, bug report, atau feature request, silakan buat issue di repository ini.

---

<p align="center">
  <strong>Dibuat dengan ❤️ untuk memberdayakan UMKM Pesantren Indonesia</strong>
</p>
