<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\{TicketController, DashboardController};
use App\Http\Controllers\Admin\{CategoryController};
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentTicketController;
use App\Http\Controllers\CommentController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root logic: Redirect to dashboard if logged in
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

/**
 * AUTHENTICATED ROUTES
 */
Route::middleware(['auth'])->group(function () {

    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Centralized Comments (Shared by User, Admin, and Agent)
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');

    // --- ADMIN ROUTES ---
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
        Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::post('/tickets/{ticket}/assign', [AdminTicketController::class, 'assign'])->name('tickets.assign');
        Route::delete('/tickets/{ticket}/comments/{comment}', [AdminTicketController::class, 'deleteComment'])->name('tickets.delete-comment');
        
        // User Management for Admin
        Route::resource('users', AdminUserController::class);
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');
    });

    // --- AGENT ROUTES ---
    Route::prefix('agent')->name('agent.')->group(function () {
        Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/tickets', [AgentTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AgentTicketController::class, 'show'])->name('tickets.show');
        Route::patch('/tickets/{ticket}/status', [AgentTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    });

    // --- USER SIDE TICKETS ---
    Route::resource('tickets', TicketController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::post('/tickets/{ticket}/reopen', [TicketController::class, 'reopen'])->name('tickets.reopen');
    Route::post('/tickets/{ticket}/feedback', [TicketController::class, 'feedback'])->name('tickets.feedback');

    // Profile & Lock Screen
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/lock', [ProfileController::class, 'show'])->name('lock');
    Route::post('/lock/unlock', [ProfileController::class, 'unlock'])->name('lock.unlock');
     
});

Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms.service');

Route::view('/privacy-policy', 'pages.privacy')->name('privacy');

require __DIR__.'/auth.php';