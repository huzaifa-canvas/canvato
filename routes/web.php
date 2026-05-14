<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\FrontendController;

// ═══════════════════════════════════════════════════
// FRONTEND ROUTES (Canvato Design — Public)
// ═══════════════════════════════════════════════════
Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/design-templates', [FrontendController::class, 'templates'])->name('frontend.templates');
Route::get('/design-templates/{type}', [FrontendController::class, 'templates'])
    ->whereIn('type', ['printable-templates', 'product-mockups', 'social-media', 'websites', 'ux-ui-toolkits', 'infographics', 'logos', 'scene-generators'])
    ->name('frontend.templates.type');
Route::get('/design-template/{slug?}', [FrontendController::class, 'singleTemplate'])->name('frontend.single-template');

// Frontend — Customer Dashboard (auth required)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-profile', [FrontendController::class, 'profile'])->name('frontend.profile');
    Route::put('/my-profile/update', [FrontendController::class, 'updateProfile'])->name('frontend.profile.update');
    Route::put('/my-profile/password', [FrontendController::class, 'updatePassword'])->name('frontend.profile.password');
    Route::get('/my-orders', [FrontendController::class, 'orders'])->name('frontend.orders');
    Route::get('/my-orders/{id}', [FrontendController::class, 'orderDetail'])->name('frontend.order-detail');
    Route::get('/checkout', [FrontendController::class, 'checkout'])->name('frontend.checkout');
    Route::get('/checkout/{template:slug}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{template:slug}/process', [\App\Http\Controllers\Frontend\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/download/{template:slug}', [\App\Http\Controllers\Frontend\DownloadController::class, 'secureDownload'])->name('download.secure');
});

// ═══════════════════════════════════════════════════
// ADMIN ROUTES (Vuexy Design — Admin roles only)
// ═══════════════════════════════════════════════════
Route::get('admin/login', [\App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
Route::post('admin/login', [\App\Http\Controllers\AdminAuthController::class, 'login'])->middleware('guest');
Route::post('admin/logout', [\App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [HomePage::class, 'index'])->name('pages-home');
    Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

    // Apps -> Roles & Permissions
    Route::resource('access-roles', \App\Http\Controllers\Apps\RoleController::class)->except(['create', 'show', 'edit']);
    Route::resource('access-permission', \App\Http\Controllers\Apps\PermissionController::class)->except(['create', 'show', 'edit']);

    // User Management
    Route::get('user/list', [\App\Http\Controllers\Apps\UserController::class, 'index'])->name('app-user-list');
    Route::get('user/edit/{id}', [\App\Http\Controllers\Apps\UserController::class, 'edit'])->name('app-user-edit');
    Route::put('user/update/{id}', [\App\Http\Controllers\Apps\UserController::class, 'update'])->name('app-user-update');
    Route::delete('user/delete/{id}', [\App\Http\Controllers\Apps\UserController::class, 'destroy'])->name('app-user-delete');

    // E-Commerce / Catalog Management
    Route::resource('categories', \App\Http\Controllers\Apps\CategoryController::class)->except(['show']);
    
    // Type Routes for active menu states
    Route::get('templates/printable-templates', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.printable');
    Route::get('templates/product-mockups', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.mockups');
    Route::get('templates/social-media', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.social');
    Route::get('templates/websites', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.websites');
    Route::get('templates/ux-ui-toolkits', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.ux');
    Route::get('templates/infographics', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.infographics');
    Route::get('templates/logos', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.logos');
    Route::get('templates/scene-generators', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.scene');
    
    Route::resource('templates', \App\Http\Controllers\Apps\TemplateController::class);

    // Admin Profile
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [\App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Secure File Downloads
    Route::get('/downloads/generate/{filename}', [\App\Http\Controllers\DownloadController::class, 'generateUrl'])->name('secure.download.generate');
    Route::get('/downloads/file/{filename}', [\App\Http\Controllers\DownloadController::class, 'download'])
        ->name('secure.download')
        ->middleware('signed');
});

// ═══════════════════════════════════════════════════
// MISC
// ═══════════════════════════════════════════════════
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// Note: Authentication routes (login, register, password reset) are automatically handled by Laravel Fortify.

