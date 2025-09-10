# 📦 Manajemen Produk Toko - Pasar Santri

## 📋 Deskripsi
Manajemen Produk adalah sistem lengkap yang memungkinkan penjual untuk membuat, mengelola, dan mengoptimalkan produk mereka di **Pasar Santri Marketplace**. Sistem ini mendukung produk dengan varian, multi-kategori, pengelolaan media, optimisasi SEO, dan integrasi penuh dengan sistem inventori dan manajemen pesanan.

## 🎯 Tujuan
- Mengelola katalog produk toko secara komprehensif
- Mendukung produk dengan varian yang kompleks
- Mengoptimalkan produk untuk mesin pencari (SEO)
- Mengelola inventori dan stok secara real-time
- Memberikan pengalaman berbelanja yang optimal

## 🔐 Akses & Persyaratan
**Role Required:** Seller dengan toko aktif dan terverifikasi  
**Permission:** Akses penuh ke manajemen produk toko  
**URL:** `/seller/products`

---

## 📋 Persyaratan Akses Manajemen Produk

### 1. **KYC Disetujui & Setup Toko**
- Status KYC harus **"Disetujui"**
- Toko sudah dibuat dan terverifikasi
- Informasi toko lengkap (alamat, kontak, dll)
- Role penjual sudah otomatis diberikan

### 2. **Setup Kategori**
- **Kategori Global**: Tersedia dari administrator platform
- **Kategori Toko**: Kategori internal opsional sudah dibuat
- **Pemahaman**: Produk dapat menggunakan kedua jenis kategori

### 3. **Persyaratan Media**
- **Gambar Utama**: Wajib untuk setiap produk
- **Format File**: JPEG, PNG, JPG, GIF
- **Batas Ukuran**: Maksimum 2MB per gambar
- **Kualitas**: Resolusi tinggi disarankan

---

## 🏗️ Struktur Sistem Manajemen Produk

### 1. **Struktur Inti Produk**
```
📦 Entitas Produk:
├── Informasi Dasar (nama, deskripsi, harga, stok)
├── Pengelolaan Media (gambar utama, hover, galeri)
├── Penugasan Kategori (global + kategori toko)
├── Sistem Varian (dukungan multi-varian opsional)
├── Optimisasi SEO (meta title, deskripsi, kata kunci)
├── Pelacakan Inventori (stok, SKU, dimensi, berat)
├── Fitur Marketing (unggulan, populer)
└── Manajemen Status (aktif, tidak aktif, soft delete)
```

### 2. **Arsitektur Sistem Varian**
```
🔄 Varian Produk:
├── Produk Sederhana (tanpa varian)
│   ├── SKU, harga, stok tunggal
│   ├── Manajemen inventori langsung
│   └── Straightforward customer selection
│
└── Variable Product (with variants)
    ├── Parent product (base information)
    ├── Child variants (size, color, material, etc.)
    ├── Individual SKU, price, stock per variant
    ├── Attribute-based selection system
    └── Complex inventory management
```

### 3. **Category Integration**
```
🏷️ Dual Category System:
├── Global Categories (Platform-Wide):
│   ├── Electronics, Fashion, Home & Garden
│   ├── SEO and marketplace categorization
│   ├── Public search and filtering
│   └── Required for all products
│
└── Shop Categories (Internal):
    ├── Best Sellers, New Arrivals, Seasonal
    ├── Internal organization and marketing
    ├── Shop-specific business logic
    └── Optional but recommended
```

---

## Komponen Product Management

### 1. **Product Listing Dashboard**

#### A. Search dan Filter System
```
🔍 Advanced Search Features:
✓ Product name search (case-insensitive)
✓ SKU number search
✓ Description content search
✓ Real-time filtering dengan pagination
✓ Search state preservation dalam URL
```

#### B. Product Display Columns
```
📋 Product List Information:
✓ Product Image + Name: Visual identification
✓ Stock Status: Out of stock, low stock, available
✓ Primary Category: First assigned category
✓ Pricing: Regular price, sale price (strikethrough)
✓ Product Colors: Visual color indicators
✓ SKU: Product identifier
✓ Rating: Customer rating + review count
✓ Actions: View, Edit, Delete buttons
```

#### C. Stock Status Indicators
```
📊 Stock Management Visual Cues:
- Red Badge "Out of Stock": stock = 0
- Orange Badge "Low Stock": stock <= 5
- Normal Display: stock > 5
- Real-time updates: Reflects current inventory
```

### 2. **Product Creation Form**

#### A. Basic Product Information
```
📝 Required Product Fields:

1. Product Name:
   - Type: Text input (max 255 chars)
   - Validation: Required, string
   - Auto-generates: SEO-friendly slug
   - Used for: Display, search, URL generation

2. Product Description:
   - Type: Rich text WYSIWYG editor
   - Validation: Required
   - Features: Bold, italic, lists, links, images
   - Used for: Product detail page, SEO

3. Pricing Structure:
   - Regular Price: Original price (required)
   - Sale Price: Discounted price (optional)
   - Display: Shows both dengan strike-through
   - Validation: Numeric, minimum 0
```

#### B. Media Management System
```
📸 Product Images:

1. Default Image (Required):
   - Primary product image
   - Displayed: Product listings, search results
   - Format: JPEG, PNG, JPG, GIF
   - Size: Maximum 2MB
   - Aspect Ratio: Square recommended

2. Hover Image (Optional):
   - Alternate view on hover
   - Enhanced: User experience
   - Same format restrictions

3. Gallery Images (Optional):
   - Multiple additional images
   - Product detail: Image carousel
   - Bulk upload: Multiple files at once
   - Same validation rules
```

#### C. Inventory Management
```
📦 Stock and SKU Management:

1. Stock Quantity:
   - Type: Integer input (min 0)
   - Tracking: Real-time inventory
   - Alerts: Low stock notifications
   - Integration: Order processing system

2. SKU (Stock Keeping Unit):
   - Auto-generated: Shop prefix + random string
   - Manual override: Custom SKU entry
   - Validation: Unique across platform
   - Format: Alphanumeric, uppercase recommended

3. Physical Properties:
   - Weight: For shipping calculation
   - Dimensions: L x W x H measurements
   - Brand: Product manufacturer/brand
   - Used for: Shipping, filtering, display
```

### 3. **Category Assignment System**

#### A. Global Categories (Required)
```
🌐 Platform Categories:
✓ Selection: Multi-select checkboxes
✓ Requirement: Minimum 1 category
✓ Validation: Must exist dan be active
✓ Purpose: SEO, marketplace categorization
✓ Examples: Electronics > Smartphones, Fashion > Clothing
```

#### B. Shop Categories (Optional)
```
🏪 Internal Categories:
✓ Selection: Multi-select from shop categories
✓ Requirement: Optional but recommended
✓ Purpose: Internal organization, marketing
✓ Examples: Best Sellers, New Arrivals, Featured
✓ Management: Created in Category Management section
```

### 4. **SEO Optimization Fields**
```
🎯 SEO Enhancement:

1. Meta Title:
   - Custom page title for search engines
   - Falls back: Product name if empty
   - Length: Recommended 50-60 characters

2. Meta Description:
   - Product summary for search results
   - Length: Recommended 150-160 characters
   - Impact: Click-through rates

3. Meta Keywords:
   - Comma-separated keywords
   - Legacy SEO: Still useful for internal search
   - Strategy: Include relevant product terms

4. Tags System:
   - Comma-separated product tags
   - Internal search: Improve discoverability
   - Marketing: Campaign organization
```

### 5. **Marketing Features**
```
🎪 Promotional Options:

1. Featured Product:
   - Checkbox: Mark as featured
   - Display: Homepage, special sections
   - Algorithm: Potential boost in search

2. Popular Product:
   - Checkbox: Mark as popular
   - Display: "Popular" badges, special listings
   - Strategy: Social proof, increased visibility

3. Product Status:
   - Active: Available for purchase
   - Inactive: Hidden from public, draft mode
   - Soft Delete: Removable but recoverable
```

---

## Product Variant Management

### 1. **Variant System Overview**
```
🔄 Variant Architecture:

Single Product (No Variants):
├── One SKU, one price, one stock level
├── Simple management and customer experience
└── Suitable for: Unique items, services, digital products

Variable Product (With Variants):
├── Parent product: Base information
├── Child variants: Specific combinations
├── Attributes: Size, color, material, etc.
├── Individual: SKU, price, stock per variant
└── Suitable for: Clothing, electronics dengan options
```

### 2. **Creating Product Variants**

#### A. Adding Variants to Existing Product
```
➕ Variant Creation Process:

1. Navigate to Product Detail Page:
   - View existing product information
   - Access "Add Variant" button
   - Modal form opens for variant entry

2. Variant Information:
   - Variant Name: Descriptive identifier
   - SKU: Auto-generated atau custom
   - Price: Variant-specific pricing
   - Stock: Individual inventory level
   - Attributes: Key-value pairs (Size: Large, Color: Red)

3. Validation:
   - Unique SKU across all products
   - Positive stock and price values
   - Required name field
   - Attributes format validation
```

#### B. Variant Attributes System
```
🏷️ Attribute Management:

Attribute Structure:
- Key: Attribute name (Size, Color, Material)
- Value: Specific option (Large, Red, Cotton)
- JSON Storage: Flexible attribute system
- Display: Customer selection interface

Example Attributes:
{
  "Size": "Large",
  "Color": "Red", 
  "Material": "Cotton",
  "Style": "Slim Fit"
}
```

### 3. **Variant Display dan Selection**
```
👤 Customer Variant Experience:

1. Product Detail Page:
   - Attribute dropdowns/buttons
   - Dynamic price updates
   - Stock availability display
   - SKU changes per selection

2. Selection Logic:
   - All attributes must be selected
   - Matching variant lookup
   - Stock validation
   - Price calculation

3. Cart Integration:
   - Specific variant added to cart
   - Individual tracking per variant
   - Inventory deduction per variant
```

---

## Panduan Step-by-Step Product Management

### Langkah 1: Akses Product Management

1. **Login** ke seller dashboard
2. **Navigate** ke "Products" menu di sidebar
3. **View** product listing dengan search dan filter options
4. **Check** current product inventory status

### Langkah 2: Membuat Produk Baru

#### Persiapan Sebelum Create:
```
📋 Pre-Creation Checklist:
✓ Product photos ready (minimum 1, maximum recommended 5)
✓ Product information lengkap (name, description, price)
✓ Category planning (global + shop categories)
✓ SKU strategy (auto-generate atau custom)
✓ Pricing strategy (regular price, sale price if applicable)
```

#### Process Create Product:
1. **Klik "Create New"** dari product listing page

2. **Fill Basic Information**:
   ```
   Product Name: Descriptive, SEO-friendly
   Description: Comprehensive, benefit-focused
   Long Description: Detailed specifications (optional)
   ```

3. **Upload Product Images**:
   ```
   Default Image: Main product photo (required)
   Hover Image: Alternate view (optional)  
   Gallery Images: Additional angles (optional)
   ```

4. **Set Pricing**:
   ```
   Regular Price: Original selling price
   Sale Price: Promotional price (jika ada discount)
   Display: Customer sees both prices
   ```

5. **Configure Inventory**:
   ```
   Stock Quantity: Available units
   SKU: Auto-generated atau custom input
   Weight: For shipping calculation
   Dimensions: Physical measurements
   Brand: Manufacturer information
   ```

6. **Assign Categories**:
   ```
   Global Categories: Select minimum 1
   Shop Categories: Select relevant internal categories
   Strategy: Choose most specific applicable categories
   ```

7. **SEO Optimization**:
   ```
   Meta Title: Custom search engine title
   Meta Description: Search result snippet
   Meta Keywords: Relevant search terms
   Tags: Internal organization tags
   ```

8. **Marketing Options**:
   ```
   Featured Product: Homepage prominence
   Popular Product: Social proof badges
   Status: Active (visible) atau Inactive (draft)
   ```

9. **Submit Product**: Review all information dan save

### Langkah 3: Mengelola Produk Existing

#### Edit Product Process:
1. **Find Product** via search atau browse listing
2. **Klik Edit Button** (green pencil icon)
3. **Modify Fields** yang perlu diupdate
4. **Handle Media Changes**:
   ```
   Replace Images: Upload new files
   Remove Images: Clear existing selections
   Add Images: Expand gallery collection
   ```
5. **Update Categories**: Adjust global dan shop assignments
6. **Save Changes**: Apply modifications

#### View Product Details:
1. **Klik View Button** (eye icon) atau product name
2. **Review Information**: All product details display
3. **Check Variants**: If product has variants
4. **Manage Variants**: Add, edit, atau delete variants

### Langkah 4: Product Variant Management

#### Adding Variants to Existing Product:
1. **Navigate** ke product detail page
2. **Klik "Add Variant"** button di variants section
3. **Fill Variant Information**:
   ```
   Variant Name: Descriptive identifier
   SKU: Auto-generated atau custom
   Price: Variant-specific pricing
   Stock: Individual inventory level
   Attributes: Key-value attribute pairs
   ```
4. **Save Variant**: Add to product variants collection

#### Managing Existing Variants:
```
✏️ Variant Operations:
- View: See all variants in table format
- Edit: Modify variant properties (coming soon)
- Delete: Remove variant (dengan confirmation)
- Stock: Monitor individual variant inventory
```

### Langkah 5: Product Performance Monitoring

#### Stock Management:
```
📊 Inventory Monitoring:
- Dashboard Overview: Stock levels per product
- Low Stock Alerts: Automatic notifications
- Out of Stock: Customer notification management
- Restock Planning: Based on sales velocity
```

#### Sales Analytics:
```
📈 Performance Tracking:
- View Count: Product page visits
- Add to Cart Rate: Conversion metrics
- Sales Volume: Units sold per period
- Revenue Generation: Total earnings per product
```

---

## Technical Implementation Details

### 1. **Database Schema**

#### Products Table Structure:
```sql
-- Main Products Table
id              UUID PRIMARY KEY
sku             VARCHAR(100) UNIQUE NOT NULL
name            VARCHAR(255) NOT NULL
slug            VARCHAR(255) UNIQUE NOT NULL
shop_id         UUID FOREIGN KEY NOT NULL
description     TEXT NOT NULL
meta_description TEXT
long_description TEXT
tags            JSON (array of strings)
specification   JSON (array of key-value pairs)
price           DECIMAL(10,2) NOT NULL
final_price     DECIMAL(10,2) DEFAULT NULL
has_variant     BOOLEAN DEFAULT FALSE
stock           INTEGER DEFAULT 0
is_featured     BOOLEAN DEFAULT FALSE
is_popular      BOOLEAN DEFAULT FALSE
status          ENUM('active', 'inactive') DEFAULT 'active'
meta_title      VARCHAR(255)
meta_keywords   TEXT
weight          DECIMAL(8,2)
dimensions      JSON
brand           VARCHAR(100)
created_at      TIMESTAMP
updated_at      TIMESTAMP
deleted_at      TIMESTAMP (soft deletes)
```

#### Product Variants Table:
```sql
-- Product Variants Table
id          UUID PRIMARY KEY
product_id  UUID FOREIGN KEY (products.id)
sku         VARCHAR(100) UNIQUE NOT NULL
name        VARCHAR(255)
price       DECIMAL(10,2) NOT NULL
final_price DECIMAL(10,2) DEFAULT NULL
stock       INTEGER DEFAULT 0
attributes  JSON (key-value pairs)
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

#### Category Relations:
```sql
-- Product-Category Pivot Table
id          UUID PRIMARY KEY
product_id  UUID FOREIGN KEY (products.id)
category_id UUID FOREIGN KEY (categories.id)
created_at  TIMESTAMP

-- Indexes for performance
INDEX idx_product_categories (product_id)
INDEX idx_category_products (category_id)
```

### 2. **Media Library Integration**

#### Spatie Media Library:
```php
// Media Collections Configuration
Collections:
- default-image: Primary product image
- hover-image: Alternate hover view
- gallery-images: Additional product photos

Storage:
- Driver: public disk (storage/app/public)
- Path: products/{uuid}/{collection}
- Conversions: Multiple sizes for optimization
```

### 3. **Validation Rules**

#### InventoryStoreRequest:
```php
Validation Rules:
- name: required|string|max:255
- description: required|string
- price: required|numeric|min:0
- stock: required|integer|min:0
- global_categories: required|array|min:1
- sku: nullable|string|max:100|unique:products,sku
- default_image: required|image|max:2048
- status: required|in:active,inactive

Custom Validation:
- Category existence validation
- Shop ownership verification
- Image format and size checks
- SKU uniqueness across platform
```

#### Business Logic Validation:
```php
Custom Business Rules:
- Shop must own product for modifications
- Global categories must be platform categories
- Local categories must belong to shop
- Stock cannot be negative
- Price must be positive
- SKU must be unique globally
```

---

## Integration dengan Sistem Lain

### 1. **Order Management Integration**

#### Order Processing Flow:
```
🛒 Order Integration:

1. Product Selection:
   - Customer selects product/variant
   - Stock availability validation
   - Price calculation dengan taxes

2. Order Creation:
   - Inventory reservation
   - Stock deduction
   - Order item creation dengan product details

3. Order Fulfillment:
   - Seller processes order
   - Inventory confirmation
   - Shipping preparation

4. Inventory Updates:
   - Real-time stock adjustments
   - Low stock notifications
   - Reorder point calculations
```

### 2. **Search dan Discovery Integration**

#### Platform Search:
```
🔍 Search Integration:

1. Elasticsearch Index:
   - Product name, description indexing
   - Category-based filtering
   - Price range filtering
   - Brand and tag searching

2. SEO Integration:
   - Meta tags for search engines
   - Structured data markup
   - Canonical URLs
   - Sitemap generation

3. Internal Search:
   - Shop-specific product search
   - Variant-aware searching
   - Attribute-based filtering
   - Autocomplete suggestions
```

### 3. **Analytics dan Reporting**

#### Product Performance Analytics:
```
📊 Analytics Integration:

1. View Tracking:
   - Product page visits
   - Search result appearances
   - Category page views
   - Time spent on product pages

2. Conversion Metrics:
   - Add to cart rates
   - Purchase completion rates
   - Variant selection patterns
   - Abandoned cart analysis

3. Inventory Insights:
   - Stock movement patterns
   - Seasonal demand fluctuations
   - Variant performance comparison
   - Reorder recommendations
```

---

## SEO dan Marketing Optimization

### 1. **SEO Best Practices**
```
🎯 SEO Optimization Strategy:

1. Product Names:
   ✓ Include target keywords naturally
   ✓ Avoid keyword stuffing
   ✓ Use descriptive, benefit-focused names
   ✓ Consider search volume keywords

2. Descriptions:
   ✓ Write for humans first, search engines second
   ✓ Include relevant keywords organically
   ✓ Highlight unique selling points
   ✓ Use bullet points for readability

3. Meta Tags:
   ✓ Unique meta titles per product
   ✓ Compelling meta descriptions
   ✓ Include primary keywords
   ✓ Maintain proper length limits

4. Image SEO:
   ✓ Descriptive file names
   ✓ Alt text for accessibility
   ✓ Optimized file sizes
   ✓ High-quality visuals
```

### 2. **Marketing Features Utilization**
```
🎪 Marketing Strategy:

1. Featured Products:
   - Homepage prominence
   - Special collections
   - Email newsletter inclusion
   - Social media promotion

2. Popular Products:
   - Social proof enhancement
   - Cross-selling opportunities
   - Trending sections
   - Customer recommendation engines

3. Category Strategy:
   - Logical product organization
   - Seasonal category updates
   - Marketing campaign alignment
   - Customer journey optimization
```

### 3. **Pricing Strategies**
```
💰 Pricing Optimization:

1. Regular vs Sale Price:
   - Psychological pricing principles
   - Discount percentage display
   - Limited time offers
   - Seasonal price adjustments

2. Variant Pricing:
   - Size-based pricing tiers
   - Premium material upcharges
   - Volume discount structures
   - Bundle pricing strategies

3. Competitive Analysis:
   - Market price monitoring
   - Value proposition alignment
   - Profit margin optimization
   - Customer price sensitivity
```

---

## Performance dan Optimization

### 1. **Database Optimization**
```sql
-- Database Performance Tuning

-- Indexes for common queries
CREATE INDEX idx_products_shop_status ON products(shop_id, status);
CREATE INDEX idx_products_featured ON products(is_featured, status);
CREATE INDEX idx_products_popular ON products(is_popular, status);
CREATE INDEX idx_products_search ON products(name, description);

-- Variant lookup optimization
CREATE INDEX idx_variants_product ON product_variants(product_id);
CREATE INDEX idx_variants_sku ON product_variants(sku);

-- Category filtering
CREATE INDEX idx_category_product_lookup ON category_product(category_id, product_id);
```

### 2. **Caching Strategy**
```
🚀 Performance Caching:

1. Product Data Cache:
   - TTL: 1 hour for product information
   - Key: product_id atau slug
   - Invalidation: On product updates

2. Category Cache:
   - TTL: 6 hours for category trees
   - Key: shop_id + 'categories'
   - Invalidation: On category changes

3. Image Cache:
   - CDN: Cloudflare atau AWS CloudFront
   - Compression: WebP format support
   - Lazy Loading: On-demand image loading

4. Search Cache:
   - TTL: 30 minutes for search results
   - Key: search_query + filters
   - Pagination: Cached per page
```

### 3. **Image Optimization**
```
🖼️ Media Optimization:

1. Image Processing:
   - Auto-resize: Multiple size variants
   - Format Conversion: WebP for modern browsers
   - Compression: Quality vs size balance
   - Lazy Loading: Improve page load times

2. Storage Strategy:
   - Local Storage: Development environment
   - Cloud Storage: Production (S3, GCS)
   - CDN: Global content delivery
   - Backup: Regular automated backups
```

---

## Troubleshooting

### Problem: "Cannot upload product image"
**Diagnosis**:
- File size exceeds 2MB limit
- Invalid file format (not JPEG, PNG, JPG, GIF)
- Server upload limits
- Storage disk space issues

**Solution**:
1. Compress image to under 2MB
2. Convert to supported format
3. Check server upload_max_filesize setting
4. Verify storage disk has available space
5. Contact support if persistent

### Problem: "SKU already exists"
**Diagnosis**:
- Duplicate SKU across platform
- Previous product with same SKU
- Case sensitivity issues
- Variant SKU conflicts

**Solution**:
1. Use auto-generated SKU
2. Check existing products for duplicates
3. Add unique identifier to SKU
4. Use shop prefix + random string
5. Contact support for SKU conflicts

### Problem: "Product not showing in search"
**Diagnosis**:
- Product status is inactive
- No global categories assigned
- Search index not updated
- Shop is suspended

**Solution**:
1. Set product status to active
2. Assign at least one global category
3. Wait for search index update (up to 15 minutes)
4. Check shop suspension status
5. Contact support for indexing issues

### Problem: "Variant selection not working"
**Diagnosis**:
- JavaScript errors in browser
- Incomplete variant attributes
- Stock level issues
- Browser compatibility

**Solution**:
1. Check browser console for errors
2. Ensure all variants have complete attributes
3. Verify variant stock levels > 0
4. Try different browser
5. Clear browser cache and cookies

### Problem: "Category assignment failed"
**Diagnosis**:
- Invalid category selections
- Category permissions issues
- Database relationship problems
- Shop category access

**Solution**:
1. Select only valid global categories
2. Check shop category ownership
3. Refresh category selections
4. Contact support for permission issues
5. Try creating categories first

---

## Security dan Permissions

### 1. **Access Control**
- **Authentication**: User must be logged in sebagai seller
- **Shop Ownership**: Can only manage own shop products
- **KYC Requirement**: Shop must have approved KYC status
- **Product Ownership**: Verify product belongs to seller's shop

### 2. **Data Validation**
- **Input Sanitization**: All inputs validated dan sanitized
- **File Upload Security**: Image virus scanning
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Output escaping

### 3. **Business Logic Security**
- **Stock Validation**: Prevent negative stock
- **Price Validation**: Ensure positive pricing
- **Category Validation**: Verify category access rights
- **Media Security**: Validate uploaded file types

---

## Monitoring dan Analytics

### 1. **Product Performance Metrics**
```
📊 Key Performance Indicators:

1. Product Metrics:
   - Total products created per shop
   - Active vs inactive product ratios
   - Average products per category
   - Product creation velocity

2. Inventory Metrics:
   - Stock turnover rates
   - Out of stock frequency
   - Low stock alert frequency
   - Inventory value tracking

3. Customer Interaction:
   - Product view counts
   - Add to cart rates
   - Purchase conversion rates
   - Customer review ratings
```

### 2. **Business Intelligence**
```
🧠 Analytics Insights:

1. Product Performance:
   - Best selling products
   - Underperforming products
   - Seasonal demand patterns
   - Category performance comparison

2. Optimization Opportunities:
   - SEO improvement suggestions
   - Pricing optimization recommendations
   - Stock level optimization
   - Category assignment effectiveness

3. Market Intelligence:
   - Competitive price analysis
   - Trending product categories
   - Customer preference patterns
   - Market demand forecasting
```

---

## Dukungan dan Bantuan

Untuk bantuan terkait product management:

### 📞 **Support Channels:**
```
📧 Email Products   : products-support@pasarsantri.com
📱 WhatsApp        : +62 812-3456-7890 (Product Issues)
💬 Live Chat       : Available di seller dashboard
🌐 Help Center     : help.pasarsantri.com/products
🏢 Developer       : PT. Sidogiri Fintech Utama
```

### ⏰ **Jam Operasional:**
```
Product Support:
Senin - Jumat  : 08:00 - 17:00 WIB  
Sabtu          : 08:00 - 12:00 WIB
Minggu         : Closed

Technical Support:
24/7 untuk critical product issues
```

### 📚 **Resources:**
```
📖 Product Guide       : docs.pasarsantri.com/seller/products
📹 Video Tutorials     : youtube.com/pasarsantri/products
🎯 Best Practices      : help.pasarsantri.com/product-tips
❓ FAQ                : faq.pasarsantri.com/products
🔧 Troubleshooting     : support.pasarsantri.com/product-issues
```

---

## Frequently Asked Questions (FAQ)

### Q: Berapa maksimal produk yang bisa dibuat per shop?
**A**: Tidak ada limit hard untuk jumlah produk, tapi recommended mengfokuskan pada kualitas daripada kuantitas. Monitor performance dan customer response untuk setiap produk.

### Q: Bisakah mengubah SKU produk setelah ada pesanan?
**A**: Tidak recommended karena bisa affect order tracking dan inventory management. Jika terpaksa, contact support untuk assistance dengan proper data migration.

### Q: Bagaimana cara optimal menggunakan variant system?
**A**: Gunakan variants untuk produk yang memang memiliki pilihan berbeda (ukuran, warna, model). Hindari membuat terlalu banyak variants yang tidak perlu karena bisa membingungkan customer.

### Q: Kenapa produk tidak muncul di search marketplace?
**A**: Pastikan: 1) Status active, 2) Minimal 1 global category assigned, 3) Stock > 0, 4) Shop tidak suspended. Search index update butuh waktu 15-30 menit.

### Q: Bisakah bulk upload/edit produk?
**A**: Saat ini belum ada bulk upload feature. Each product harus dibuat individual untuk ensure data quality. Feature ini planned untuk future update.

### Q: Bagaimana handle product yang sold out?
**A**: Set stock = 0 atau status = inactive. Customer akan see "out of stock" notification. Produk tetap visible tapi tidak bisa dibeli sampai restock.

### Q: Apakah bisa duplicate product untuk create similar items?
**A**: Saat ini tidak ada duplicate feature. Harus create manual dari scratch, tapi bisa copy-paste information yang sama untuk efficiency.

### Q: Bagaimana optimize product images untuk fast loading?
**A**: Gunakan format JPEG untuk photos, PNG untuk graphics dengan transparency. Compress ke under 200KB per image jika memungkinkan tanpa mengurangi kualitas significantly.

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: September 2025*
