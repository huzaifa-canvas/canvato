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
    Route::middleware('permission:view roles')->group(function () {
        Route::get('access-roles', [\App\Http\Controllers\Apps\RoleController::class, 'index'])->name('access-roles.index');
    });
    Route::middleware('permission:create roles')->group(function () {
        Route::post('access-roles', [\App\Http\Controllers\Apps\RoleController::class, 'store'])->name('access-roles.store');
    });
    Route::middleware('permission:edit roles')->group(function () {
        Route::put('access-roles/{access_role}', [\App\Http\Controllers\Apps\RoleController::class, 'update'])->name('access-roles.update');
    });
    Route::middleware('permission:delete roles')->group(function () {
        Route::delete('access-roles/{access_role}', [\App\Http\Controllers\Apps\RoleController::class, 'destroy'])->name('access-roles.destroy');
    });

    Route::middleware('permission:view permissions')->group(function () {
        Route::get('access-permission', [\App\Http\Controllers\Apps\PermissionController::class, 'index'])->name('access-permission.index');
    });
    Route::middleware('permission:create permissions')->group(function () {
        Route::post('access-permission', [\App\Http\Controllers\Apps\PermissionController::class, 'store'])->name('access-permission.store');
    });
    Route::middleware('permission:edit permissions')->group(function () {
        Route::put('access-permission/{access_permission}', [\App\Http\Controllers\Apps\PermissionController::class, 'update'])->name('access-permission.update');
    });
    Route::middleware('permission:delete permissions')->group(function () {
        Route::delete('access-permission/{access_permission}', [\App\Http\Controllers\Apps\PermissionController::class, 'destroy'])->name('access-permission.destroy');
    });

    // User Management
    Route::middleware('permission:view users')->group(function () {
        Route::get('user/list', [\App\Http\Controllers\Apps\UserController::class, 'index'])->name('app-user-list');
    });
    Route::middleware('permission:create users')->group(function () {
        Route::get('user/create', [\App\Http\Controllers\Apps\UserController::class, 'create'])->name('app-user-create');
        Route::post('user/store', [\App\Http\Controllers\Apps\UserController::class, 'store'])->name('app-user-store');
    });
    Route::middleware('permission:edit users')->group(function () {
        Route::get('user/edit/{id}', [\App\Http\Controllers\Apps\UserController::class, 'edit'])->name('app-user-edit');
        Route::put('user/update/{id}', [\App\Http\Controllers\Apps\UserController::class, 'update'])->name('app-user-update');
    });
    Route::middleware('permission:delete users')->group(function () {
        Route::delete('user/delete/{id}', [\App\Http\Controllers\Apps\UserController::class, 'destroy'])->name('app-user-delete');
    });

    // E-Commerce / Catalog Management
    Route::middleware('permission:view categories')->group(function () {
        Route::get('categories', [\App\Http\Controllers\Apps\CategoryController::class, 'index'])->name('categories.index');
    });
    Route::middleware('permission:create categories')->group(function () {
        Route::get('categories/create', [\App\Http\Controllers\Apps\CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [\App\Http\Controllers\Apps\CategoryController::class, 'store'])->name('categories.store');
    });
    Route::middleware('permission:edit categories')->group(function () {
        Route::get('categories/{category}/edit', [\App\Http\Controllers\Apps\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [\App\Http\Controllers\Apps\CategoryController::class, 'update'])->name('categories.update');
    });
    Route::middleware('permission:delete categories')->group(function () {
        Route::delete('categories/{category}', [\App\Http\Controllers\Apps\CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    
    // Type Routes for active menu states
    Route::middleware('permission:view products')->group(function () {
        Route::get('templates/printable-templates', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.printable');
        Route::get('templates/product-mockups', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.mockups');
        Route::get('templates/social-media', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.social');
        Route::get('templates/websites', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.websites');
        Route::get('templates/ux-ui-toolkits', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.ux');
        Route::get('templates/infographics', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.infographics');
        Route::get('templates/logos', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.logos');
        Route::get('templates/scene-generators', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.type.scene');
        Route::get('templates', [\App\Http\Controllers\Apps\TemplateController::class, 'index'])->name('templates.index');
        Route::get('templates/{template}', [\App\Http\Controllers\Apps\TemplateController::class, 'show'])->name('templates.show');
    });
    Route::middleware('permission:create products')->group(function () {
        Route::get('templates/create', [\App\Http\Controllers\Apps\TemplateController::class, 'create'])->name('templates.create');
        Route::post('templates', [\App\Http\Controllers\Apps\TemplateController::class, 'store'])->name('templates.store');
    });
    Route::middleware('permission:edit products')->group(function () {
        Route::get('templates/{template}/edit', [\App\Http\Controllers\Apps\TemplateController::class, 'edit'])->name('templates.edit');
        Route::put('templates/{template}', [\App\Http\Controllers\Apps\TemplateController::class, 'update'])->name('templates.update');
    });
    Route::middleware('permission:delete products')->group(function () {
        Route::delete('templates/{template}', [\App\Http\Controllers\Apps\TemplateController::class, 'destroy'])->name('templates.destroy');
    });

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

