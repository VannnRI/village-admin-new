<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminDesaController;
use App\Http\Controllers\AdminDesa\LetterRequestController;
use App\Http\Controllers\AdminDesa\LetterTemplateController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\MasyarakatController;

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Super Admin Routes
Route::middleware(['auth', 'super.admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    
    // Village Management
    Route::get('/villages', [SuperAdminController::class, 'villages'])->name('villages');
    Route::get('/villages/create', [SuperAdminController::class, 'createVillage'])->name('villages.create');
    Route::post('/villages', [SuperAdminController::class, 'storeVillage'])->name('villages.store');
    Route::get('/villages/{id}/edit', [SuperAdminController::class, 'editVillage'])->name('villages.edit');
    Route::put('/villages/{id}', [SuperAdminController::class, 'updateVillage'])->name('villages.update');
    Route::delete('/villages/{id}', [SuperAdminController::class, 'deleteVillage'])->name('villages.delete');
    
    // User Management
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::get('/users/create', [SuperAdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [SuperAdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [SuperAdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [SuperAdminController::class, 'deleteUser'])->name('users.delete');
    Route::put('/users/{id}/reset-password', [SuperAdminController::class, 'resetPassword'])->name('users.reset-password');
});

// Admin Desa Routes
Route::middleware(['auth', 'admin.desa'])->prefix('admin-desa')->name('admin-desa.')->group(function () {
    Route::get('/dashboard', [AdminDesaController::class, 'dashboard'])->name('dashboard');
    
    // Village Profile
    Route::get('/village/profile', [AdminDesaController::class, 'villageProfile'])->name('village.profile');
    Route::post('/village/profile', [AdminDesaController::class, 'updateVillageProfile'])->name('village.profile.update');
    
    // Profile Management
    Route::get('/profile', [AdminDesaController::class, 'profile'])->name('profile');
    Route::put('/profile/update-username', [AdminDesaController::class, 'updateUsername'])->name('profile.update-username');
    Route::put('/profile/update-password', [AdminDesaController::class, 'updatePassword'])->name('profile.update-password');

    // Citizen Management
    Route::get('/citizens', [AdminDesaController::class, 'citizens'])->name('citizens.index');
    Route::get('/citizens/create', [AdminDesaController::class, 'createCitizen'])->name('citizens.create');
    Route::post('/citizens', [AdminDesaController::class, 'storeCitizen'])->name('citizens.store');
    Route::get('/citizens/{citizen}/edit', [AdminDesaController::class, 'editCitizen'])->name('citizens.edit');
    Route::put('/citizens/{citizen}', [AdminDesaController::class, 'updateCitizen'])->name('citizens.update');
    Route::delete('/citizens/{citizen}', [AdminDesaController::class, 'destroyCitizen'])->name('citizens.destroy');
    Route::get('/citizens/template/download', [AdminDesaController::class, 'downloadTemplate'])->name('citizens.template.download');
    Route::post('/citizens/import', [AdminDesaController::class, 'importCitizens'])->name('citizens.import');
    
    // Reset Password Masyarakat
    Route::get('/citizens/reset-password', [AdminDesaController::class, 'resetPasswordPage'])->name('citizens.reset-password');
    Route::put('/citizens/{user}/reset-password', [AdminDesaController::class, 'resetPasswordMasyarakat'])->name('citizens.reset-password-user');
    
    // Letter Requests
    Route::get('letter-requests', [AdminDesaController::class, 'letterRequests'])->name('letter-requests.index');
    Route::get('letter-requests/{id}', [AdminDesaController::class, 'showLetterRequest'])->name('letter-requests.show');
    
    // Letter Templates
    Route::resource('letter-templates', LetterTemplateController::class);
    Route::get('letter-templates/{id}/preview', [LetterTemplateController::class, 'preview'])->name('letter-templates.preview');

    Route::prefix('archives')->name('archives.')->group(function () {
        Route::get('/', [AdminDesaController::class, 'archives'])->name('archives');
        Route::get('/general', [AdminDesaController::class, 'generalArchives'])->name('archives.general');
        Route::get('/population', [AdminDesaController::class, 'populationArchives'])->name('archives.population');
        Route::get('/letters', [AdminDesaController::class, 'letterArchives'])->name('archives.letters');
        Route::get('/download/{type}/{format?}', [AdminDesaController::class, 'downloadArchive'])->name('archives.download');
        Route::post('/general', [AdminDesaController::class, 'storeGeneralArchive'])->name('archives.general.store');
        Route::put('/general/{id}', [AdminDesaController::class, 'updateGeneralArchive'])->name('archives.general.update');
        Route::delete('/general/{id}', [AdminDesaController::class, 'destroyGeneralArchive'])->name('archives.general.destroy');
        Route::get('/general/{id}/edit', [AdminDesaController::class, 'editGeneralArchive'])->name('archives.general.edit');
    });

    Route::resource('village-officials', App\Http\Controllers\AdminDesa\VillageOfficialController::class);

    // Route::get('government-structure', [AdminDesaController::class, 'governmentStructure'])->name('government-structure');
    // Route::post('government-structure', [AdminDesaController::class, 'updateGovernmentStructure'])->name('government-structure.update');

    Route::get('/letter-requests/{id}/download', [\App\Http\Controllers\AdminDesa\LetterTemplateController::class, 'downloadLetter'])->name('letter-requests.download');
});

// Perangkat Desa Routes
Route::middleware(['auth', 'perangkat.desa'])->prefix('perangkat-desa')->name('perangkat-desa.')->group(function () {
    Route::get('/dashboard', [PerangkatDesaController::class, 'dashboard'])->name('dashboard');
    Route::get('/letter-requests', [PerangkatDesaController::class, 'letterRequests'])->name('letter-requests');
    Route::get('/letter-requests/{id}', [PerangkatDesaController::class, 'showLetterRequest'])->name('letter-requests.show');
    Route::post('/letter-requests/{id}/approve', [PerangkatDesaController::class, 'approveLetterRequest'])->name('letter-requests.approve');
    Route::post('/letter-requests/{id}/reject', [PerangkatDesaController::class, 'rejectLetterRequest'])->name('letter-requests.reject');
    Route::get('/letter-requests/{id}/download', [PerangkatDesaController::class, 'downloadLetter'])->name('letter-requests.download');
    
    // Profile Management
    Route::get('/profile', [PerangkatDesaController::class, 'profile'])->name('profile');
    Route::put('/profile/update-username', [PerangkatDesaController::class, 'updateUsername'])->name('profile.update-username');
    Route::put('/profile/update-password', [PerangkatDesaController::class, 'updatePassword'])->name('profile.update-password');
});

// Masyarakat Routes
Route::middleware(['auth', 'masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    Route::get('/dashboard', [MasyarakatController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MasyarakatController::class, 'profile'])->name('profile');
    Route::put('/profile', [MasyarakatController::class, 'updateProfile'])->name('profile.update');
    Route::get('/letter-form', [MasyarakatController::class, 'letterForm'])->name('letter-form');
    Route::post('/letters/submit', [MasyarakatController::class, 'submitLetter'])->name('letters.submit');
    Route::get('/letters/status', [MasyarakatController::class, 'lettersStatus'])->name('letters.status');
    Route::get('/letters/{id}/download', [MasyarakatController::class, 'downloadLetter'])->name('letters.download');
    Route::post('/letters/resubmit/{id}', [MasyarakatController::class, 'resubmitLetter'])->name('letters.resubmit');
    
    // Profile Management
    Route::put('/profile/update-username', [MasyarakatController::class, 'updateUsername'])->name('profile.update-username');
    Route::put('/profile/update-password', [MasyarakatController::class, 'updatePassword'])->name('profile.update-password');
});
