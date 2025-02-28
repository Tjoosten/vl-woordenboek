<?php

use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Articles\StoreArticleSuggestionController;
use App\Http\Controllers\Authentication\MyWelcomeController;
use App\Http\Controllers\Definitions\DefinitionInformationController;
use App\Http\Controllers\Definitions\UpdateDefinitionController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use Spatie\WelcomeNotification\WelcomesNewUsers;

Route::get('/', SearchController::class)->name('home');
Route::view('/voorwaarden', 'info.terms')->name('terms-of-service');

// Lemma routes
Route::get('/resultaten', SearchController::class)->name('search.results');

// Article information routes
Route::get('/woord/{word}', DefinitionInformationController::class)->name('word-information.show');

Route::middleware('auth')->group(function () {
    Route::get('/woord/{word}/aanpassen', [UpdateDefinitionController::class, 'edit'])->name('definitions.update');
    Route::patch('/woord/{word}/aanpassen', [UpdateDefinitionController::class, 'update'])->name('article.update');
});

// Authentication routes
Route::group(['middleware' => ['web', WelcomesNewUsers::class]], function (): void {
    Route::get('welkom/{user}', [MyWelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welkom/{user}', [MyWelcomeController::class, 'savePassword']);
});

Route::group(['prefix' => 'definities'], function (): void {
    Route::view('/regio-informatie', 'region-information')->name('definitions.region-info');
    Route::get('insturen', [StoreArticleSuggestionController::class, 'create'])->name('definitions.create');
    Route::post('insturen', [StoreArticleSuggestionController::class, 'store'])
        ->middleware(ProtectAgainstSpam::class)
        ->name('definitions.store');
});

// Accout routes
Route::get('/profiel/{user}', ProfileController::class)->name('profile');

Route::middleware(['auth'])->group(function (): void {
    Route::get('account-instellingen', SettingsController::class)->name('profile.settings');
});
