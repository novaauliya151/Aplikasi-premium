# 🔐 Panduan Role-Based Access Control

## ✅ Yang Sudah Dibuat:

### 1. User Model Updated
- ✅ Field `role` ditambahkan ke `$fillable`
- ✅ Method `isAdmin()` untuk cek apakah user admin
- ✅ Method `isBuyer()` untuk cek apakah user buyer

### 2. Admin Seeder
- ✅ File: `database/seeders/AdminSeeder.php`
- ✅ Membuat user admin default

### 3. Middleware
- ✅ `IsAdmin` - Proteksi route untuk admin
- ✅ `IsBuyer` - Proteksi route untuk buyer
- ✅ Sudah terdaftar di `bootstrap/app.php`

---

## 🚀 Cara Menggunakan:

### 1. Jalankan Seeder untuk Membuat Admin
```bash
php artisan db:seed --class=AdminSeeder
```

**Kredensial Admin Default:**
- Email: `admin@apkpremium.com`
- Password: `admin123`
- ⚠️ **JANGAN LUPA GANTI PASSWORD SETELAH LOGIN!**

---

### 2. Cara Menggunakan Middleware di Routes

#### Contoh untuk Route Admin:
```php
// routes/web.php

// Route individual
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'admin']);

// Group routes untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::get('/admin/users', [AdminController::class, 'users']);
});
```

#### Contoh untuk Route Buyer:
```php
// routes/web.php

// Route individual
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware(['auth', 'buyer']);

// Group routes untuk buyer
Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/orders/my-orders', [OrderController::class, 'myOrders']);
});
```

#### Contoh Route yang Bisa Diakses Keduanya:
```php
// Hanya perlu auth, tidak peduli role
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});
```

---

### 3. Cara Cek Role di Blade Template

```blade
{{-- Cek apakah user adalah admin --}}
@if(auth()->check() && auth()->user()->isAdmin())
    <a href="/admin/dashboard">Dashboard Admin</a>
@endif

{{-- Cek apakah user adalah buyer --}}
@if(auth()->check() && auth()->user()->isBuyer())
    <a href="/checkout">Checkout</a>
@endif

{{-- Tampilkan menu sesuai role --}}
@auth
    @if(auth()->user()->isAdmin())
        <!-- Menu untuk Admin -->
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/products">Kelola Produk</a>
        <a href="/admin/orders">Kelola Pesanan</a>
    @else
        <!-- Menu untuk Buyer -->
        <a href="/product">Produk</a>
        <a href="/checkout">Checkout</a>
        <a href="/orders/my-orders">Pesanan Saya</a>
    @endif
@endauth
```

---

### 4. Cara Cek Role di Controller

```php
use Illuminate\Support\Facades\Auth;

class SomeController extends Controller
{
    public function someMethod()
    {
        // Cara 1: Menggunakan method helper
        if (auth()->user()->isAdmin()) {
            // Kode untuk admin
        }

        if (auth()->user()->isBuyer()) {
            // Kode untuk buyer
        }

        // Cara 2: Cek langsung
        $user = Auth::user();
        if ($user->role === 'admin') {
            // Kode untuk admin
        }
    }
}
```

---

### 5. Membuat Admin Secara Manual

Jika Anda ingin membuat admin baru secara manual:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin Baru',
    'email' => 'admin2@apkpremium.com',
    'password' => Hash::make('password123'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

Atau lewat Tinker:
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Super Admin',
    'email' => 'superadmin@apkpremium.com',
    'password' => Hash::make('superadmin123'),
    'role' => 'admin',
    'email_verified_at' => now()
]);
```

---

### 6. Update Role User yang Sudah Ada

Lewat Tinker:
```bash
php artisan tinker
```
```php
$user = User::where('email', 'user@example.com')->first();
$user->role = 'admin';
$user->save();
```

Atau buat route khusus (hanya untuk development):
```php
Route::get('/make-admin/{id}', function($id) {
    $user = User::findOrFail($id);
    $user->role = 'admin';
    $user->save();
    return "User {$user->name} sekarang adalah admin";
})->middleware('auth');
```

---

## 🎯 Contoh Lengkap Implementasi di Routes

```php
// routes/web.php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;

// Route Public (tanpa login)
Route::get('/', [ProductController::class, 'index']);
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Route untuk ADMIN (perlu login + role admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
});

// Route untuk BUYER (perlu login + role buyer)
Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'view'])->name('checkout.view');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
    Route::get('/orders/my-orders', [OrderController::class, 'myOrders'])->name('orders.mine');
});

// Route untuk SEMUA USER yang login (tidak peduli role)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

---

## 🔒 Keamanan

1. **Jangan hardcode password** di seeder untuk production
2. **Ganti password default admin** setelah deploy
3. **Gunakan environment variable** untuk kredensial admin di production
4. **Implementasi rate limiting** untuk login
5. **Log semua aksi admin** untuk audit trail

---

## 📝 Testing

Test apakah middleware bekerja:

1. **Daftar sebagai buyer** → Coba akses `/admin/dashboard` → Harus error 403
2. **Login sebagai admin** → Coba akses `/checkout` → Harus error 403
3. **Sesuaikan dengan route yang Anda buat**

---

## 💡 Tips

- Gunakan middleware `admin` untuk melindungi semua route admin
- Gunakan middleware `buyer` untuk melindungi route pembelian
- Untuk route yang bisa diakses semua role, cukup gunakan `auth`
- Buat redirect otomatis setelah login berdasarkan role

---

## 🎨 Bonus: Redirect Otomatis Setelah Login

Edit `app/Providers/FortifyServiceProvider.php`:

```php
use Laravel\Fortify\Fortify;

Fortify::authenticateUsing(function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        return $user;
    }
});

// Redirect setelah login
Fortify::redirects('login', function () {
    if (auth()->user()->isAdmin()) {
        return '/admin/dashboard';
    }
    return '/product';
});
```

---

**Selesai!** 🎉 Sistem role-based access control Anda sudah siap digunakan.
