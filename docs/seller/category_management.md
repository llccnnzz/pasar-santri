# Manajemen Kategori Toko - Pasar Santri

## Deskripsi
Manajemen Kategori adalah sistem yang memungkinkan penjual untuk membuat dan mengelola kategori internal khusus toko mereka. Kategori ini berfungsi sebagai sistem pengorganisasian produk tingkat toko dan dapat digunakan bersamaan dengan kategori global platform untuk memberikan fleksibilitas maksimal dalam pengelompokan produk.

## Tujuan
- Mengorganisir produk toko dengan kategori yang spesifik
- Memberikan fleksibilitas pengelompokan produk sesuai kebutuhan bisnis
- Memudahkan pembeli mencari produk dalam toko
- Mengoptimalkan navigasi dan pengalaman berbelanja
- Melengkapi sistem kategori global platform

## Akses & Persyaratan
**Role Required:** Seller dengan toko aktif  
**Permission:** Akses penuh ke manajemen kategori toko  
**URL:** `/seller/categories`

---

## Persyaratan Akses Manajemen Kategori

### 1. **KYC Disetujui & Toko Aktif**
- Status KYC harus **"Disetujui"**
- Toko sudah dibuat dan berstatus aktif
- Role penjual sudah otomatis diberikan
- Toko tidak dalam status ditangguhkan

### 2. **Memahami Sistem Kategori Dua Tingkat**
- **Kategori Global**: Kategori platform yang tersedia untuk semua penjual
- **Kategori Toko**: Kategori internal khusus per toko
- **Penugasan Produk**: Produk dapat menggunakan kedua jenis kategori

### 3. **Struktur Database Siap**
- Tabel kategori dengan field ID toko
- Hubungan banyak-ke-banyak dengan produk
- Batasan unik per toko untuk nama dan slug

---

## Konsep Kategori Dua Tingkat

### 1. **Kategori Global (Seluruh Platform)**
```
Kategori Global:
├── Dikelola oleh Administrator platform
├── Tersedia untuk semua penjual
├── Digunakan untuk pencarian dan penyaringan umum
├── SEO dan kategorisasi marketplace
└── Tidak dapat diubah oleh penjual

Contoh: Elektronik, Fashion, Rumah & Taman, Buku, dll.
```

### 2. **Kategori Toko (Khusus Penjual)**
```
Kategori Toko (Internal):
├── Dibuat dan dikelola penjual sendiri
├── Spesifik untuk organisasi internal toko
├── Kontrol penuh oleh pemilik toko
├── Disesuaikan dengan kebutuhan bisnis masing-masing
└── Digunakan bersamaan dengan kategori global

Examples: "Best Sellers", "New Arrivals", "Seasonal Items", etc.
```

### 3. **Kombinasi Usage Pattern**
```
Product Category Assignment:
Global Category: "Electronics" → "Smartphone"
Shop Category: "Best Sellers" + "New Arrivals"

Result: Produk bisa ditemukan via:
- Platform search "Electronics"
- Shop internal organization "Best Sellers"
- Combined filtering possibilities
```

---

## Komponen Category Management

### 1. **Category List Dashboard**

#### A. Search dan Filter
```
Search Functionality:
✓ Real-time search by category name
✓ Search by slug (URL identifier)
✓ Case-insensitive matching
✓ Search state preserved in URL
✓ Empty state handling untuk no results
```

#### B. Category Information Display
```
Category List Columns:
✓ Name: Display name kategori
✓ Slug: URL-friendly identifier (dengan <code> styling)
✓ Products Count: Badge dengan jumlah produk per kategori
✓ Created Date: Tanggal pembuatan (M d, Y format)
✓ Actions: Edit button dengan feather icon
```

#### C. Statistics Overview
```
Category Usage Statistics:
- Total Categories: Jumlah kategori yang dibuat shop
- Products Distribution: Sebaran produk per kategori
- Active Usage: Kategori yang benar-benar digunakan
- Empty Categories: Kategori tanpa produk (candidate for deletion)
```

### 2. **Create Category Form**

#### A. Form Fields
```
Category Creation Fields:

1. Name (Required):
   - Type: Text input
   - Max Length: 255 characters
   - Validation: Required, unique per shop
   - Auto-slugify: Generate slug otomatis

2. Slug (Optional):
   - Type: Text input  
   - Max Length: 255 characters
   - Auto-Generation: Dari name jika kosong
   - Manual Override: Bisa diubah manual
   - Validation: Unique, URL-safe format
```

#### B. Auto-Slug Generation
```javascript
// Slug Generation Logic:
1. Convert to lowercase
2. Remove special characters (keep alphanumeric and spaces)
3. Replace spaces with hyphens
4. Remove multiple consecutive hyphens
5. Trim leading/trailing hyphens
6. Ensure uniqueness dengan counter suffix

Example:
"Electronics & Gadgets" → "electronics-gadgets"
"Home & Garden Items!" → "home-garden-items"
```

#### C. Informational Sidebar
```
Help Information:
- Explanation internal vs global categories
- Best practices untuk naming
- SEO tips untuk category structure
- Usage guidelines dan recommendations
```

### 3. **Edit Category Form**

#### A. Edit Capabilities
```
Editable Fields:
✓ Name: Can be updated anytime
✓ Slug: Auto-regenerated or manual override
✓ Timestamp tracking: Created/updated dates
✓ Usage statistics: Products count display
```

#### B. Update Validation
```
Update Restrictions:
- Name uniqueness: Only within same shop
- Slug uniqueness: Global atau per shop
- Concurrent editing: Handle race conditions
- Audit trail: Track changes untuk compliance
```

#### C. Danger Zone
```
Delete Functionality:
- Only available: If no products assigned
- Confirmation required: JavaScript confirm dialog
- Permanent action: Cannot be undone
- Cascade prevention: Block delete if products exist
```

---

## Panduan Step-by-Step Category Management

### Langkah 1: Akses Category Management

1. **Login** ke seller dashboard
2. **Pastikan shop status aktif** dan tidak suspended
3. Klik menu **"Categories"** di sidebar seller
4. Halaman category management akan terbuka

### Langkah 2: Membuat Kategori Baru

#### Proses Create Category:
1. **Klik "Create New"** di category list page
2. **Isi Category Name**:
   ```
   Contoh Names yang Baik:
   ✓ "Best Sellers" (untuk produk populer)
   ✓ "New Arrivals" (untuk produk baru)
   ✓ "Seasonal Items" (untuk produk musiman)  
   ✓ "Premium Collection" (untuk produk high-end)
   ✓ "Clearance Sale" (untuk produk discount)
   ```

3. **Slug Handling**:
   - **Auto-generation**: Leave slug field empty untuk auto-generate
   - **Manual override**: Type custom slug jika perlu specific format
   - **Preview**: Slug akan ditampilkan real-time saat typing name

4. **Review Information**:
   - Check sidebar explanation tentang category types
   - Understand difference internal vs global categories
   - Consider category hierarchy planning

5. **Submit Form**:
   - Klik "Create Category" button
   - Sistem akan validate uniqueness
   - Redirect ke category list dengan success message

### Langkah 3: Mengelola Kategori Existing

#### Search dan Filter Categories:
1. **Use search box** untuk find specific categories
2. **Search by name atau slug** dengan real-time results
3. **Clear search** untuk show all categories
4. **Navigate pagination** jika categories banyak

#### Edit Category Process:
1. **Klik Edit icon** (green circle button) pada category row
2. **Update fields** yang perlu diubah:
   ```
   Name Updates:
   - Will auto-regenerate slug if slug empty
   - Maintain manual slug if already customized
   - Validate uniqueness within shop scope
   ```

3. **Review category info** di sidebar:
   - Created/updated timestamps
   - Current slug value
   - Products count usage
   - Delete availability status

4. **Save changes** dengan "Update Category" button

#### Delete Category (If Applicable):
1. **Check products count** = 0 (no products assigned)
2. **Navigate to edit page** untuk access danger zone
3. **Confirm deletion** via JavaScript confirmation
4. **Understand permanent nature** of deletion action

### Langkah 4: Menggunakan Categories di Product Management

#### Assign Products to Categories:
```
Product Category Assignment:

When Creating/Editing Products:
1. Global Categories Section:
   - Select dari platform categories (Electronics, Fashion, dll)
   - Required untuk SEO dan marketplace categorization
   - Affects public search dan filtering

2. Shop Categories Section (Your Categories):
   - Select dari internal categories yang sudah dibuat
   - Optional tapi helpful untuk internal organization
   - Custom business logic dan grouping
```

#### Category Strategy Planning:
```
Category Planning Strategy:

1. Business Logic Categories:
   - "Best Sellers" → Track popular products
   - "New Arrivals" → Feature recent additions
   - "Seasonal" → Manage seasonal inventory

2. Marketing Categories:
   - "Featured Products" → Homepage highlights
   - "Sale Items" → Promotional products
   - "Bundle Deals" → Package offers

3. Inventory Categories:
   - "High Stock" → Products ready to promote
   - "Low Stock" → Products need attention
   - "Discontinued" → Phase-out management
```

---

## Technical Implementation

### 1. **Database Schema**

#### Categories Table Structure:
```sql
-- Table: categories
id          UUID PRIMARY KEY
name        VARCHAR(255) NOT NULL
slug        VARCHAR(255) NOT NULL  
shop_id     UUID NULL (NULL = global category)
parent_id   UUID NULL (untuk hierarchical structure future)
created_at  TIMESTAMP
updated_at  TIMESTAMP

-- Indexes:
UNIQUE KEY unique_shop_name (shop_id, name)
UNIQUE KEY unique_shop_slug (shop_id, slug)
INDEX idx_shop_categories (shop_id)
```

#### Category-Product Relationship:
```sql
-- Table: category_product (Pivot Table)
id          UUID PRIMARY KEY
category_id UUID FOREIGN KEY (categories.id)
product_id  UUID FOREIGN KEY (products.id)
created_at  TIMESTAMP

-- Indexes:
UNIQUE KEY unique_category_product (category_id, product_id)
INDEX idx_product_categories (product_id)
INDEX idx_category_products (category_id)
```

### 2. **Validation Rules**

#### CategoryStoreRequest:
```php
Rules:
- name: required|string|max:255|unique:categories,name,NULL,id,shop_id,{shop_id}
- slug: nullable|string|max:255|unique:categories,slug

Custom Logic:
- Auto-generate slug if empty
- Ensure uniqueness within shop scope
- Handle special characters in name
- Prevent duplicate slugs globally
```

#### CategoryUpdateRequest:
```php
Rules:
- name: required|string|max:255|unique:categories,name,{id},id,shop_id,{shop_id}
- slug: nullable|string|max:255|unique:categories,slug,{id}

Update Logic:
- Exclude current record dari uniqueness check
- Regenerate slug if name changed dan slug empty
- Preserve manual slug if exists
- Validate shop ownership before update
```

### 3. **Controller Logic Flow**

#### Category Management Flow:
```php
// Index: List categories dengan search
1. Get shop dari authenticated user
2. Apply search filter jika ada query parameter
3. Paginate results (20 per page)
4. Return view dengan categories collection

// Store: Create new category
1. Validate input via CategoryStoreRequest
2. Auto-generate slug jika tidak provided
3. Ensure slug uniqueness dalam shop scope
4. Create category dengan shop_id assignment
5. Redirect dengan success message

// Update: Edit existing category  
1. Validate ownership (category.shop_id === user.shop.id)
2. Validate input via CategoryUpdateRequest
3. Handle slug regeneration logic
4. Update record dengan validated data
5. Redirect dengan success message

// Destroy: Delete category
1. Validate ownership
2. Check products count = 0 (prevent deletion if in use)
3. Delete record dari database
4. Redirect dengan success message
```

---

## Integration dengan Sistem Lain

### 1. **Product Management Integration**

#### Product Creation/Editing:
```php
// Product form akan show:
1. Global Categories (required):
   - Platform-wide categories
   - SEO dan marketplace categorization
   - Public search filtering

2. Shop Categories (optional):
   - Internal shop categories
   - Custom organization
   - Business logic grouping

// Database relationship:
Many-to-Many: Product dapat belong ke multiple categories
Mixed Types: Global + shop categories pada same product
```

### 2. **Shop Frontend Integration**

#### Category Display di Shop:
```
Shop Category Usage:

1. Shop Navigation:
   - Display shop categories as menu items
   - Filter products by internal categories
   - Custom shop organization

2. Product Listing:
   - Group products by shop categories
   - "Best Sellers", "New Arrivals" sections
   - Custom business showcase

3. Search Enhancement:
   - Additional filtering options
   - Combined dengan global category filtering
   - Improved user experience
```

### 3. **Analytics Integration**

#### Category Performance Tracking:
```
Category Analytics:

1. Usage Statistics:
   - Products per category count
   - Empty categories identification  
   - Most/least used categories

2. Business Intelligence:
   - Category effectiveness analysis
   - Customer interaction patterns
   - Sales performance per category

3. Optimization Insights:
   - Category structure recommendations
   - Unused category cleanup suggestions
   - Performance improvement tips
```

---

## Best Practices

### 1. **Category Naming Strategy**
```
Naming Best Practices:

1. Clear dan Descriptive:
   ✓ "Best Sellers" (clear purpose)
   ✓ "New Arrivals" (time-based)
   ✓ "Premium Collection" (quality-based)
   "Misc Items" (too vague)
   "Category 1" (not descriptive)

2. Business-Focused:
   ✓ "Featured Products" (marketing focus)
   ✓ "Seasonal Items" (inventory management)
   ✓ "Bundle Deals" (sales strategy)

3. Consistent Naming Convention:
   ✓ Use consistent terminology
   ✓ Maintain parallel structure
   ✓ Consider alphabetical ordering
```

### 2. **Category Organization Strategy**
```
Organization Best Practices:

1. Limit Category Count:
   - 5-10 categories optimal untuk most shops
   - Too many = customer confusion
   - Too few = limited organization

2. Regular Maintenance:
   - Review category usage monthly
   - Remove unused categories
   - Update naming as business evolves

3. Strategic Purpose:
   - Each category should serve clear business purpose
   - Align dengan marketing strategy
   - Support customer navigation needs
```

### 3. **SEO dan Marketing Optimization**
```
Optimization Tips:

1. SEO-Friendly Slugs:
   ✓ Use relevant keywords
   ✓ Keep slugs short dan descriptive
   ✓ Avoid special characters
   ✓ Consider search volume keywords

2. Marketing Alignment:
   - Create categories untuk marketing campaigns
   - Seasonal category updates
   - Promotional category management
   - Customer journey optimization

3. Performance Monitoring:
   - Track category click-through rates
   - Monitor conversion per category
   - Analyze customer behavior patterns
   - Optimize based pada data insights
```

---

## Troubleshooting

### Problem: "Category name already exists"
**Diagnosis**:
- Name uniqueness enforced per shop
- Case-insensitive comparison
- Previous category dengan same name exists
- Soft-deleted records might conflict

**Solution**:
1. Try slight variation: "Best Sellers 2024"
2. Check existing categories untuk duplicates
3. Consider different naming approach
4. Contact support jika persistent issues

### Problem: "Cannot delete category"
**Diagnosis**:
- Category has products assigned to it
- Foreign key constraint prevents deletion
- Need to reassign products first
- Database relationship integrity

**Solution**:
1. Go to product management
2. Remove category assignment dari all products
3. Verify products count = 0
4. Try delete again
5. Alternative: Keep category but rename untuk clarity

### Problem: "Slug generation issues"
**Diagnosis**:
- Special characters dalam name
- JavaScript slug generation failing
- Unique constraint violations
- Browser compatibility issues

**Solution**:
1. Manually specify slug yang valid
2. Use only alphanumeric + hyphens
3. Clear browser cache
4. Try different browser jika persistent
5. Contact support untuk technical issues

### Problem: "Categories not showing in product form"
**Diagnosis**:
- Shop categories query failing
- Permission issues
- Database relationship problems
- Cache issues

**Solution**:
1. Refresh product creation page
2. Verify shop categories exist
3. Check shop ownership dan permissions
4. Clear application cache
5. Contact technical support

---

## Security dan Permissions

### 1. **Access Control**
- **Authentication**: User must be logged in sebagai seller
- **Shop Ownership**: Can only manage own shop categories
- **KYC Requirement**: Shop must have approved KYC status
- **Suspension Check**: Shop must not be suspended

### 2. **Data Validation**
- **Input Sanitization**: All inputs validated dan sanitized
- **SQL Injection Prevention**: Prepared statements used
- **XSS Protection**: Output escaped properly
- **CSRF Protection**: Forms protected dengan CSRF tokens

### 3. **Business Logic Security**
- **Uniqueness Enforcement**: Name/slug unique per shop
- **Cascade Protection**: Prevent deletion if products exist
- **Ownership Validation**: Verify shop ownership before operations
- **Audit Trail**: Log important category operations

---

## Performance Considerations

### 1. **Database Optimization**
```sql
-- Optimized queries dengan proper indexing

-- Index untuk shop categories lookup
CREATE INDEX idx_categories_shop_id ON categories(shop_id);

-- Composite index untuk search
CREATE INDEX idx_categories_shop_search ON categories(shop_id, name, slug);

-- Category products count optimization
CREATE INDEX idx_category_product_category ON category_product(category_id);
```

### 2. **Query Optimization**
```php
// Efficient category loading dengan eager loading
$categories = Category::where('shop_id', $shop->id)
    ->withCount(['products' => function($query) use ($shop) {
        $query->where('shop_id', $shop->id);
    }])
    ->latest()
    ->paginate(20);

// Avoid N+1 queries dengan proper relationships
```

### 3. **Caching Strategy**
```
Caching Implementation:

1. Category List Cache:
   - Cache category list per shop
   - TTL: 1 hour (categories don't change frequently)
   - Invalidate on category CRUD operations

2. Products Count Cache:
   - Cache products count per category
   - TTL: 30 minutes
   - Invalidate on product assignment changes

3. Search Results Cache:
   - Cache search results untuk common queries
   - TTL: 15 minutes
   - Key includes search term dan shop_id
```

---

## Monitoring dan Analytics

### 1. **Usage Analytics**
```
Category Usage Monitoring:

1. Creation Patterns:
   - Categories created per day/month
   - Most common category names
   - Shop adoption rates

2. Usage Effectiveness:
   - Categories dengan most products
   - Empty categories identification
   - Category assignment frequency

3. Performance Metrics:
   - Category management page load times
   - Search performance
   - CRUD operation success rates
```

### 2. **Business Intelligence**
```
Category Intelligence:

1. Shop Behavior Analysis:
   - Category creation patterns
   - Naming conventions analysis
   - Usage optimization opportunities

2. Platform Insights:
   - Popular category types
   - Successful categorization strategies
   - Best practice identification

3. Recommendations Engine:
   - Suggest categories based pada product types
   - Category optimization recommendations
   - Automated cleanup suggestions
```

---

## Dukungan dan Bantuan

Untuk bantuan terkait category management:

### **Support Channels:**
```
Email Categories : categories-support@pasarsantri.com
WhatsApp        : +62 812-3456-7890 (Category Issues)
Live Chat       : Available di seller dashboard
Help Center     : help.pasarsantri.com/categories
Developer       : PT. Sidogiri Fintech Utama
```

### **Jam Operasional:**
```
Category Support:
Senin - Jumat  : 08:00 - 17:00 WIB  
Sabtu          : 08:00 - 12:00 WIB
Minggu         : Closed

Technical Support:
24/7 untuk critical system issues
```

### **Resources:**
```
Category Guide      : docs.pasarsantri.com/seller/categories
Video Tutorials     : youtube.com/pasarsantri/categories  
Best Practices      : help.pasarsantri.com/category-tips
FAQ                : faq.pasarsantri.com/categories
Troubleshooting     : support.pasarsantri.com/category-issues
```

---

## Frequently Asked Questions (FAQ)

### Q: Apa perbedaan antara shop categories dan global categories?
**A**: Shop categories adalah kategori internal yang Anda buat sendiri untuk organisasi toko, seperti "Best Sellers" atau "New Arrivals". Global categories adalah kategori platform seperti "Electronics" atau "Fashion" yang digunakan untuk SEO dan pencarian marketplace.

### Q: Berapa maksimal kategori yang bisa dibuat?
**A**: Tidak ada limit hard, tapi direkomendasikan 5-10 kategori untuk menghindari customer confusion. Lebih baik fokus pada kategori yang benar-benar berguna untuk business logic Anda.

### Q: Bisakah mengubah nama kategori setelah produk sudah assigned?
**A**: Ya, bisa. Mengubah nama kategori tidak akan affect assignment ke produk. Slug juga akan auto-update jika Anda kosongkan field slug saat edit.

### Q: Bagaimana jika slug yang diinginkan sudah dipakai?
**A**: Sistem akan otomatis menambahkan counter (category-name-1, category-name-2, dst). Atau Anda bisa manual specify slug yang berbeda dan unik.

### Q: Kenapa tidak bisa delete kategori tertentu?
**A**: Kategori yang masih memiliki produk tidak bisa dihapus untuk menjaga data integrity. Hapus assignment dari semua produk dulu, baru kategori bisa didelete.

### Q: Apakah kategori ini affect SEO marketplace?
**A**: Shop categories lebih untuk internal organization. Untuk SEO marketplace, gunakan global categories saat create/edit produk. Kombinasi keduanya memberikan fleksibilitas maksimal.

### Q: Bisakah membuat hierarchy kategori (parent-child)?
**A**: Saat ini sistem support parent_id field tapi belum diimplementasikan di UI. Feature ini planned untuk future update.

### Q: Bagaimana backup atau export category list?
**A**: Saat ini tidak ada export feature, tapi data categories tersimpan aman di database. Contact support jika perlu backup untuk keperluan tertentu.

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: September 2025*
