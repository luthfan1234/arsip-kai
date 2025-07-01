<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Document routes
    Route::resource('documents', DocumentController::class);
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Division routes (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('divisions', DivisionController::class)->except(['show', 'create', 'edit']);
        Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    });
});

require __DIR__.'/auth.php';


