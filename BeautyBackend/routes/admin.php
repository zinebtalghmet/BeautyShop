<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingRateController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\TaxRateController;

Route::prefix('admin')->group(function () {
    // Redirect /admin to dashboard (only if authenticated)
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect('/admin/dashboard');
        }
        return redirect('/admin/login');
    });

    // Guest admin routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    });

    // Authenticated admin routes
    Route::middleware(['admin.auth', 'auth.session'])->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::delete('/products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('admin.products.images.destroy');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');

        // Slides
        Route::get('/slides', [SlideController::class, 'index'])->name('admin.slides.index');
        Route::get('/slides/create', [SlideController::class, 'create'])->name('admin.slides.create');
        Route::post('/slides', [SlideController::class, 'store'])->name('admin.slides.store');
        Route::get('/slides/{slide}/edit', [SlideController::class, 'edit'])->name('admin.slides.edit');
        Route::put('/slides/{slide}', [SlideController::class, 'update'])->name('admin.slides.update');
        Route::delete('/slides/{slide}', [SlideController::class, 'destroy'])->name('admin.slides.destroy');

        // Reviews
        Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::put('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

        // Tax Rates
        Route::get('/tax-rates', [TaxRateController::class, 'index'])->name('admin.tax-rates.index');
        Route::get('/tax-rates/create', [TaxRateController::class, 'create'])->name('admin.tax-rates.create');
        Route::post('/tax-rates', [TaxRateController::class, 'store'])->name('admin.tax-rates.store');
        Route::get('/tax-rates/{taxRate}/edit', [TaxRateController::class, 'edit'])->name('admin.tax-rates.edit');
        Route::put('/tax-rates/{taxRate}', [TaxRateController::class, 'update'])->name('admin.tax-rates.update');
        Route::delete('/tax-rates/{taxRate}', [TaxRateController::class, 'destroy'])->name('admin.tax-rates.destroy');

        // Shipping Rates
        Route::get('/shipping-rates', [ShippingRateController::class, 'index'])->name('admin.shipping-rates.index');
        Route::get('/shipping-rates/create', [ShippingRateController::class, 'create'])->name('admin.shipping-rates.create');
        Route::post('/shipping-rates', [ShippingRateController::class, 'store'])->name('admin.shipping-rates.store');
        Route::get('/shipping-rates/{shippingRate}/edit', [ShippingRateController::class, 'edit'])->name('admin.shipping-rates.edit');
        Route::put('/shipping-rates/{shippingRate}', [ShippingRateController::class, 'update'])->name('admin.shipping-rates.update');
        Route::delete('/shipping-rates/{shippingRate}', [ShippingRateController::class, 'destroy'])->name('admin.shipping-rates.destroy');

        // Contacts
        Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    });
});
