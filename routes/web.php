<?php

use App\Livewire\Front\Auth\{LoginComponent};
use App\Livewire\Front\{Dashboard};
use Illuminate\Support\Facades\{Artisan, Route};

Route::get('/optimize', function () {
    try {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:cache');
        Artisan::call('optimize:clear');
    } catch (\Exception $e) {
    }
    return 'Application cache has been cleared';
});

Route::middleware('guest:web')->group(function () {

    Route::get('/', LoginComponent::class)->name('home');
    Route::get('/login', LoginComponent::class)->name('login');
    // Route::get('/register', Register::class)->name('register');
});
Route::middleware('auth.guard:web')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('logout', [LoginComponent::class, 'logout'])->name('logout');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/api.php';