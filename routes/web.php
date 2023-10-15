<?php

use App\Http\Controllers\Admin\Dashboard\AdminsController;
use App\Http\Controllers\Admin\Dashboard\CategoryController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Dashboard\ImportProductsController;
use App\Http\Controllers\Admin\Dashboard\ProductController;
use App\Http\Controllers\Admin\Dashboard\ProfileController;
use App\Http\Controllers\Admin\Dashboard\RolesController;
use App\Http\Controllers\Front\Auth\SocialController;
use App\Http\Controllers\Front\Auth\SocialLoginController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\DeliveryController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\StripePaymentController;
use App\Http\Controllers\Front\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//require __DIR__.'/auth.php'; if depend on Breeze package

Route::name('admin.')
    ->prefix('admin/dashboard')
    ->middleware([
        'auth:admin',
    ])
    ->group(function () {

        Route::get('/', [DashboardController::class,'index'])
            ->name('dashboard');

        Route::get('/profile', [ProfileController::class,'edit'])
            ->name('profile.edit');

        Route::patch('/profile',[ProfileController::class, 'update'])
            ->name('profile.update');

        Route::resources([
            '/categories' => CategoryController::class,
            '/products' => ProductController::class,
            '/roles' => RolesController::class,
            '/admins' => AdminsController::class,
        ]);

        // Ajax search for roles
        Route::get('/roles-search', [RolesController::class, 'ajax_search'])->name('roles.search');
        // Ajax pagination for roles
        Route::get('/roles-pagination', [RolesController::class, 'ajax_paginate']);

        // Ajax search for admins
        Route::get('/admins-search', [AdminsController::class, 'ajax_search'])->name('admins.search');
        // Ajax pagination for admins
        Route::get('/admins-pagination', [AdminsController::class, 'ajax_paginate']);


        Route::get('/deleted-products',[ProductController::class,'getDeletedItems'])
            ->name('products.deleted');

        Route::get('/product/{id}/restore',[ProductController::class,'restore'])
            ->name('product.restore');

        Route::delete('/product/{id}/force-delete',[ProductController::class,'forceDelete'])
            ->name('product.force-delete');

        Route::get('/import-products', [ImportProductsController::class,'create'])
            ->name('products.import');

        Route::post('/import-products', [ImportProductsController::class,'store'])
            ->name('products.save');
});


Route::prefix(LaravelLocalization::setLocale())
    ->group( function() {

    Route::get('/',[HomeController::class, 'index'])
        ->name('home');

    Route::get('/two-factor-authentication', [TwoFactorAuthenticationController::class,'create'])
        ->name('two-factor.create');

    Route::get('/products', [ProductsController::class, 'index'])
        ->name('products.index');
    Route::get('/product/{product:slug}', [ProductsController::class,'show'])
        ->name('product.show');

    Route::resource('/cart', CartController::class);

    Route::middleware('auth')->group(function () {
        Route::get('/order',[OrderController::class,'create'])->name('order.create');
        Route::post('/order',[OrderController::class,'store'])->name('order.store');

        Route::get('/pay/order/card/stripe',[StripePaymentController::class, 'showFormStripe'])
            ->name('stripe.show');
        Route::post('/pay/order/card/stripe',[StripePaymentController::class, 'storeStripe'])
            ->name('stripe.post');
    });

        Route::post('/currency',[CurrencyConverterController::class,'store'])
        ->name('currency.store');

        Route::get('/auth/{provider}/redirect',[SocialLoginController::class, 'redirect'])
            ->name('auth.socialite.redirect');

        Route::get('/auth/{provider}/callback',[SocialLoginController::class, 'callback'])
            ->name('auth.socialite.callback');

        Route::get('/auth/{provider}/user', [SocialController::class, 'index']);

        Route::any('/stripe/webhook', [StripeWebhookController::class, 'handle']);

        Route::get('/order-delivery/{order}', [DeliveryController::class, 'show'])
            ->name('order-delivery.show');

})->middleware([ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]);

