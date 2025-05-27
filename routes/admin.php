<?php

use App\Livewire\Admin\Auth\{LoginComponent};
use App\Livewire\Admin\{Dashboard, ParkCrud, WildlifeCrud};
use Illuminate\Support\Facades\{Route};

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/', LoginComponent::class);
        Route::get('login', LoginComponent::class)->name('login');
    });

    Route::middleware(['auth.guard:admin', 'admin'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('logout', [LoginComponent::class, 'logout'])->name('logout');
        Route::get('/park', ParkCrud::class)->name('park');
        Route::get('/wild-life', WildlifeCrud::class)->name('wildlife');
    });
});
