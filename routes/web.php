<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VoiceActorController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('animes.index'); 
})->name('index');

Route::get('/animes', [AnimeController::class, 'index'])->name('animes.index');
Route::get('/animes/{anime}', [AnimeController::class, 'show'])->name('animes.show');
Route::get('/voice-actors', [VoiceActorController::class, 'index'])->name('voice-actors.index');
Route::get('/voice-actors/{voiceActor}', [VoiceActorController::class, 'show'])->name('voice-actors.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('dashboard/animes', [DashboardController::class, 'store'])->name('dashboard.animes.store');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::get('/imdb/search', [\App\Http\Controllers\ImdbController::class, 'search']);
Route::get('/imdb/show', [\App\Http\Controllers\ImdbController::class, 'show']);


require __DIR__.'/auth.php';
