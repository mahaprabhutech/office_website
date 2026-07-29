<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectImageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:8,1')
            ->name('login.submit');
    });

    Route::middleware(AdminAuthenticate::class)->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::resource('users', AdminUserController::class)->except(['show']);

        Route::get('/manage/{module}', [ContentController::class, 'index'])->name('content.index');
        Route::get('/manage/{module}/create', [ContentController::class, 'create'])->name('content.create');
        Route::post('/manage/{module}', [ContentController::class, 'store'])->name('content.store');
        Route::get('/manage/{module}/{id}', [ContentController::class, 'show'])->name('content.show');
        Route::get('/manage/{module}/{id}/edit', [ContentController::class, 'edit'])->name('content.edit');
        Route::put('/manage/{module}/{id}', [ContentController::class, 'update'])->name('content.update');
        Route::delete('/manage/{module}/{id}', [ContentController::class, 'destroy'])->name('content.destroy');

        Route::post('/projects/{project}/images', [ProjectImageController::class, 'store'])
            ->name('projects.images.store');
        Route::delete('/projects/{project}/images/{image}', [ProjectImageController::class, 'destroy'])
            ->name('projects.images.destroy');
    });
});
