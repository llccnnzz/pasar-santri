# 📚 Dokumentasi Pasar Santri Marketplace

Selamat datang di dokumentasi lengkap **Pasar Santri Marketplace** yang dikembangkan oleh **PT. Sidogiri Fintech Utama**. Dokumentasi ini akan membantu Anda memahami cara menggunakan semua fitur yang tersedia dalam platform e-commerce berbasis Laravel 11.6.1 ini.

## 🎯 Tentang Pasar Santri Marketplace

Pasar Santri Marketplace adalah platform e-commerce multi-vendor yang memungkinkan:
- **Admin** mengelola seluruh sistem, seller, dan transaksi
- **Seller** membuka toko online dan mengelola produk mereka
- **Buyer** berbelanja dari berbagai toko dalam satu platform

## 📂 Struktur Dokumentasi

### 👨‍💼 [Admin Documentation](./admin/)
Panduan lengkap untuk administrator sistem:
- [Dashboard Analytics](./admin/dashboard.md)
- [Service Fee Management](./admin/service_fee.md)
- [Banner Management](./admin/banner.md)
- [Shipping Method Management](./admin/shipping_method.md)
- [KYC Management](./admin/kyc_management.md)
- [Seller Management](./admin/seller_management.md)
- [Product Ads Management](./admin/product_ads.md)
- [Order Management](./admin/order_management.md)
- [Promotion Management](./admin/promotion_management.md)

### 🏪 [Seller Documentation](./seller/)
Panduan untuk penjual/merchant:
- [Dashboard Analytics](./seller/dashboard.md) - Dashboard utama dengan statistik dan analitik
- [KYC Verification](./seller/kyc_verification.md) - Proses verifikasi identitas seller
- [Shop Settings](./seller/shop_settings.md) - Konfigurasi dan pengaturan toko
- [Shipping Methods](./seller/shipping_methods.md) - Manajemen metode pengiriman
- [Category Management](./seller/category_management.md) - Pengelolaan kategori produk toko
- [Product Management](./seller/product_management.md) - Pengelolaan produk dan varian
- [Order Management](./seller/order_management.md) - Pengelolaan pesanan dan pengiriman
- [Bank Account Management](./seller/bank-account.md) - ⚠️ **UNCONFIRMED** - Manajemen rekening bank untuk pembayaran
- [Shop Balance & Wallet](./seller/shop-balance.md) - ⚠️ **UNCONFIRMED** - Manajemen saldo toko dan penarikan dana

### 🛒 [Buyer Documentation](./buyer/)
Panduan untuk pembeli:
- [Marketplace Landing Page](./buyer/marketplace-landing-page.md) - Homepage, Product Listing, Categories, Search, Shop Details (No Auth Required)
- [Account Setup](./buyer/account_setup.md)
- [Shopping Guide](./buyer/shopping_guide.md)
- [Cart & Checkout](./buyer/cart_checkout.md)
- [Promo Codes](./buyer/promo_codes.md)
- [Order Tracking](./buyer/order_tracking.md)
- [Address Management](./buyer/address_management.md)
- [Wishlist](./buyer/wishlist.md)

## 🚀 Fitur Utama Sistem

### ✨ **Manajemen Multi-Vendor**
- Sistem KYC (Know Your Customer) untuk verifikasi seller
- Manajemen toko dengan profil lengkap
- Sistem komisi dan fee yang fleksibel

### 🛍️ **E-Commerce Lengkap**
- Katalog produk dengan varian dan atribut
- Sistem keranjang belanja yang canggih
- Checkout dengan integrasi shipping real-time
- Sistem promo code dan diskon

### 📦 **Logistik Terintegrasi**
- Integrasi dengan Biteship untuk kalkulasi ongkir
- Multiple metode pengiriman
- Tracking otomatis untuk pesanan

### 💰 **Sistem Keuangan**
- Wallet system untuk seller
- Manajemen saldo dan penarikan dana
- Laporan keuangan detail
- Sistem pembayaran yang aman

### 📊 **Analytics & Reporting**
- Dashboard analytics real-time
- Laporan penjualan dan performa
- Statistik pengguna dan transaksi
- Growth tracking dan insights

## 🔧 Persyaratan Sistem

### **Server Requirements:**
- PHP 8.2 atau lebih tinggi
- Laravel 11.6.1
- PostgreSQL Database
- Composer untuk dependency management
- Node.js & NPM untuk asset compilation

### **Third-Party Services:**
- **Biteship API** - Untuk kalkulasi ongkir dan tracking
- **Media Library** - Untuk manajemen file dan gambar
- **Email Service** - Untuk notifikasi sistem

## 🛡️ Keamanan

Sistem ini dilengkapi dengan:
- Role-based access control
- KYC verification system
- Secure authentication dengan Laravel Sanctum
- Input validation dan sanitization
- Shop suspension mechanism

## 📞 Support

Jika Anda membutuhkan bantuan lebih lanjut:
1. Periksa dokumentasi yang sesuai dengan role Anda
2. Lihat FAQ di setiap section
3. Hubungi administrator sistem
4. Kontak PT. Sidogiri Fintech Utama untuk dukungan teknis

---

**Nama Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**Versi Dokumentasi:** 1.0  
**Tanggal Update:** September 2025  
**Versi Sistem:** Laravel 11.6.1
