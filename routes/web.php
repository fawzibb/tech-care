<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ShopController,
    CartController,
    OrderController,
    SettingsController,
    WishlistController,
    ChannelController
};
use App\Http\Controllers\Admin\{
    CategoryController as AdminCategory,
    ProductController as AdminProduct
};

// --------------------------------------------------
// 🏠 الواجهة العامة (المتجر + القنوات + الدعوات)
// --------------------------------------------------

// الصفحة الرئيسية → المتجر
Route::get('/', fn() => redirect()->route('shop.index'));

// 🛍️ المتجر (عرض المنتجات)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

// 🛒 السلة
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// 💬 الطلب عبر واتساب
Route::post('/order/whatsapp', [OrderController::class, 'whatsapp'])->name('order.whatsapp');

// 💖 المفضلة
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');

// --------------------------------------------------
// 🔐 إعدادات المستخدم (يتطلب تسجيل دخول)
// --------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// 🔓 تسجيل الخروج
Route::post('/signout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('shop.index');
})->name('signout');

// --------------------------------------------------
// 📺 القنوات (Live TV)
// --------------------------------------------------
Route::get('/live-tv', [ChannelController::class, 'index'])->name('live.index');
Route::get('/live-tv/{channel}', [ChannelController::class, 'show'])->name('live.show');

// --------------------------------------------------
// 🧭 لوحة التحكم الإدارية (Admin)
// --------------------------------------------------
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {
        // ✅ لوحة التحكم
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // ✅ التصنيفات والمنتجات
        Route::resource('categories', AdminCategory::class);
        Route::resource('products', AdminProduct::class);

        // ✅ إدارة القنوات
        Route::get('/channels', [ChannelController::class, 'adminIndex'])->name('channels.index');
        Route::get('/channels/create', [ChannelController::class, 'create'])->name('channels.create');
        Route::post('/channels', [ChannelController::class, 'store'])->name('channels.store');
        Route::get('/channels/{channel}/edit', [ChannelController::class, 'edit'])->name('channels.edit');
        Route::put('/channels/{channel}', [ChannelController::class, 'update'])->name('channels.update');
        Route::delete('/channels/{channel}', [ChannelController::class, 'destroy'])->name('channels.destroy');
    });
    Route::get('/cart/dropdown', [CartController::class, 'dropdown'])->name('cart.dropdown');


// --------------------------------------------------
// 🔑 نظام الدخول والتسجيل
// --------------------------------------------------
require __DIR__ . '/auth.php';
