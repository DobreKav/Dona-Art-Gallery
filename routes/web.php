<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaintingController as AdminPaintingController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bio', [HomeController::class, 'bio'])->name('bio');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{painting}', [ShopController::class, 'show'])->name('shop.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{painting}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{painting}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{painting}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Order routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{order}/success', [OrderController::class, 'success'])->name('order.success');

// Admin auth routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin protected routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Paintings management
    Route::resource('paintings', AdminPaintingController::class);
    
    // Orders management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

// Storage fallback route (for shared hosting without symlink support)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $mime = mime_content_type($filePath);
    return response()->file($filePath, ['Content-Type' => $mime]);
})->where('path', '.*')->name('storage.serve');
