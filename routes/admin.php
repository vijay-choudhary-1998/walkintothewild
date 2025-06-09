<?php

use App\Livewire\Admin\Auth\{LoginComponent};
use App\Livewire\Admin\{AlbumForm, AlbumList, CityCrud, ContactSettingForm, ContactUsManager, CountryCrud, Dashboard, FaqCategoryManager, FaqManager, ParkCrud, ShareSafariCrud, SiteSettingForm, StateCrud, WildlifeCrud};
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
        Route::get('/city', CityCrud::class)->name('city');
        Route::get('/state', StateCrud::class)->name('state');
        Route::get('/country', CountryCrud::class)->name('country');
        Route::get('/share-safari', ShareSafariCrud::class)->name('share.safari');

        Route::get('/faqs', FaqManager::class)->name('faqs');
        Route::get('/faqs-category', FaqCategoryManager::class)->name('faqs.category');

        Route::get('albums', AlbumForm::class)->name('albums');

        Route::get('/contact-us', ContactSettingForm::class)->name('contact_us');
        Route::get('/pages', ContactSettingForm::class)->name('pages');
        Route::get('/settings', SiteSettingForm::class)->name('settings');
    });
});
