# 📦 Fitur Product Variants & Promo

## ✅ Fitur yang Sudah Diimplementasi

### 1. **Product Variants (Varian Produk)**
- ✅ Admin bisa menambah, edit, dan hapus varian produk
- ✅ Setiap varian memiliki:
  - Nama varian (contoh: "1 Hari", "1 Bulan", "3 Bulan")
  - Harga sendiri per varian
  - Stok sendiri per varian
  - Status aktif/nonaktif
- ✅ Varian dapat dikelola langsung dari halaman edit produk
- ✅ Tab "Varian Produk" di admin panel

### 2. **Promo / Diskon**
- ✅ Promo diterapkan ke **varian tertentu** (bukan semua produk)
- ✅ Dua tipe promo:
  - **Nominal**: Potongan harga dalam rupiah (contoh: Rp 10.000)
  - **Persen**: Potongan dalam persen (contoh: 20%)
- ✅ Promo memiliki tanggal mulai & tanggal berakhir
- ✅ Harga akhir dihitung otomatis (harga varian - promo)
- ✅ Admin bisa tambah, edit, dan hapus promo
- ✅ Tab "Promo & Diskon" di admin panel

### 3. **Integrasi Frontend (Buyer)**
- ✅ Buyer melihat pilihan varian di halaman detail produk
- ✅ Harga otomatis update saat pilih varian berbeda
- ✅ Menampilkan harga coret jika ada promo aktif
- ✅ Menampilkan label promo dan jumlah hemat
- ✅ Buyer bisa pilih varian sebelum checkout
- ✅ Info varian dan promo ditampilkan di halaman checkout
- ✅ Info varian tersimpan di order history

### 4. **Database Structure**

#### Tabel `product_variants`
```sql
- id
- product_id (foreign key ke products)
- name (nama varian)
- price (harga varian)
- stock (stok varian)
- is_active (status aktif/nonaktif)
- created_at, updated_at
```

#### Tabel `promos`
```sql
- id
- variant_id (foreign key ke product_variants)
- name (nama promo)
- type (enum: 'nominal', 'percent')
- value (nilai diskon)
- start_date (tanggal mulai)
- end_date (tanggal berakhir)
- is_active (status aktif/nonaktif)
- created_at, updated_at
```

#### Tabel `order_items` (ditambahkan)
```sql
- variant_id (nullable, foreign key ke product_variants)
- variant_name (nullable, simpan nama varian untuk history)
```

## 🎯 Cara Menggunakan

### Admin:

1. **Menambah Varian Produk:**
   - Masuk ke Admin Panel → Products
   - Klik "Edit" pada produk yang ingin ditambah varian
   - Scroll ke bawah, ada tab "Varian Produk"
   - Isi form: Nama Varian, Harga, Stok
   - Klik "Tambah"

2. **Menambah Promo:**
   - Masih di halaman edit produk yang sama
   - Klik tab "Promo & Diskon"
   - Pilih varian yang ingin diberi promo
   - Isi: Nama Promo, Tipe (Nominal/Persen), Nilai, Tanggal
   - Klik "Tambah Promo"

3. **Edit/Hapus Varian atau Promo:**
   - Di tab yang sama, langsung edit inline atau klik tombol hapus

### Buyer:

1. **Membeli Produk dengan Varian:**
   - Kunjungi halaman detail produk
   - Pilih varian yang diinginkan (jika ada)
   - Harga akan otomatis update
   - Klik "Checkout Sekarang"
   - Varian yang dipilih akan terbawa ke halaman checkout

## 🔧 File yang Diubah/Dibuat

### Models:
- `app/Models/ProductVariant.php` (baru)
- `app/Models/Promo.php` (baru)
- `app/Models/Product.php` (tambah relasi)
- `app/Models/OrderItem.php` (tambah fillable)

### Controllers:
- `app/Http/Controllers/Admin/AdminProductVariantController.php` (baru)
- `app/Http/Controllers/Admin/AdminPromoController.php` (baru)
- `app/Http/Controllers/Front/CheckoutController.php` (update)

### Migrations:
- `2025_12_15_105212_create_product_variants_table.php`
- `2025_12_15_105228_create_promos_table.php`
- `2025_12_15_112940_add_variant_id_to_order_items_table.php`

### Views:
- `resources/views/admin/products/edit.blade.php` (tambah tab variants & promos)
- `resources/views/front/products/show.blade.php` (tambah pilihan varian)
- `resources/views/front/checkout/checkout.blade.php` (handle varian)
- `resources/views/admin/orders/show.blade.php` (tampilkan varian)
- `resources/views/buyer/dashboard.blade.php` (tampilkan varian)
- `resources/views/buyer/orders.blade.php` (tampilkan varian)

### Routes:
- `routes/web.php` (tambah route variants & promos)

## 💡 Fitur Tambahan yang Sudah Ada

1. **Accessor di Model:**
   - `ProductVariant::$active_promo` - Get promo aktif yang sedang berlaku
   - `ProductVariant::$final_price` - Hitung harga akhir setelah promo
   - `ProductVariant::$discount_amount` - Hitung jumlah diskon
   - `Promo::$is_valid` - Cek apakah promo masih berlaku
   - `Promo::$discount_label` - Format label diskon (Rp atau %)

2. **Validasi & Error Handling:**
   - ✅ Cek stok varian sebelum checkout
   - ✅ Otomatis kurangi stok saat order dibuat
   - ✅ Validasi tanggal promo (end_date harus >= start_date)

3. **UI/UX:**
   - ✅ Tab navigation yang responsive
   - ✅ Visual indicator untuk promo aktif
   - ✅ Harga coret untuk menampilkan diskon
   - ✅ Badge "Hemat Rp xxx" untuk promo
   - ✅ Real-time price update saat pilih varian

## 🚀 Testing

Untuk test fitur ini:

1. Login sebagai Admin
2. Edit produk yang sudah ada (contoh: Netflix Premium)
3. Tambahkan beberapa varian:
   - 1 Hari - Rp 10.000
   - 1 Minggu - Rp 50.000
   - 1 Bulan - Rp 150.000
4. Tambahkan promo ke salah satu varian:
   - Nama: "Promo Akhir Tahun"
   - Tipe: Persen
   - Nilai: 20
   - Periode: 2025-12-15 s/d 2025-12-31
5. Logout, kunjungi halaman produk sebagai buyer
6. Lihat varian dan harga promo
7. Lakukan checkout dengan varian yang dipilih

## 📝 Notes

- Promo hanya berlaku untuk **1 varian** per promo
- Jika produk tidak memiliki varian, akan tetap menggunakan harga produk asli
- Varian yang stok-nya habis tetap ditampilkan tapi tidak bisa dibeli
- History order akan menyimpan nama varian untuk referensi (meski varian dihapus)
- Admin dapat menonaktifkan varian/promo tanpa menghapusnya

---
**Created:** December 15, 2025
**Status:** ✅ Ready for Production
