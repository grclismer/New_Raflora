<?php

use Illuminate\Support\Facades\Route;

// Home Page: Landing page route
Route::get('/', fn () => view('home'))->name('home');
// Gallery Page: Dedicated gallery showcase
Route::get('/gallery', fn () => view('gallery'))->name('gallery');

// About Page: Dedicated about page
Route::get('/about', fn () => view('about'))->name('about');


// Dev Preview Logout: Clears session flag and redirects to home
Route::post('/logout', function () {
    session()->forget('dev_user');
    return redirect()->route('home');
})->name('logout');

// Auth Pages: Guest-only authentication routes (register, forgot password, login)
Route::middleware('guest')->group(function () {
    // Login Page: Displays login form
    Route::get('/login', fn () => view('auth.login'))->name('login');
    // Login Attempt: Sets session flag and redirects to home
    Route::post('/login', function () {
        session(['dev_user' => true]);
        return redirect()->route('home');
    })->name('login.attempt');

    // Register Page: Displays registration form
    Route::get('/register', fn () => view('auth.register'))->name('register');
    // Register Attempt: Processes registration POST request
    Route::post('/register', fn () => back()->with('error', 'Register controller not yet implemented'))->name('register.attempt');
    
    // Forgot Password Page: Displays password reset request form
    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('forgot-password');
    // Password Email: Sends reset link to provided email
    Route::post('/forgot-password', fn () => back()->with('error', 'Password reset controller not yet implemented'))->name('password.email');
});

// Dashboard Page: Client dashboard overview (redirects to home if authenticated or dev preview)
Route::get('/dashboard', function () {
    if (auth()->check() || session('dev_user')) {
        return redirect()->route('home');
    }
    return view('client.dashboard');
})->name('dashboard');
// Bookings Page: Lists user's active bookings
Route::get('/bookings', fn () => view('client.bookings'))->name('bookings');

// Booking Create Page: Displays new booking form
Route::get('/bookings/create', fn () => view('client.booking-create'))->name('bookings.create');
// Bookings Store: Processes booking form submission and shows AI analysis
Route::post('/bookings/create', fn () => view('client.booking-analysis'))->name('bookings.store');

// Booking History Page: Shows past bookings
Route::get('/booking-history', fn () => view('client.booking-history'))->name('booking-history');
// Account Settings Page: User profile management
Route::get('/account-settings', fn () => view('client.account-settings'))->name('account-settings');

// Admin Routes: Protected by admin authentication middleware
Route::prefix('admin')->group(function () {
    // Admin Dashboard: Main admin panel overview
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    // Admin Bookings: Booking management listing
    Route::get('/bookings', fn () => view('admin.bookings'))->name('admin.bookings');
    // Admin Booking Review: Specific booking detail view
    Route::get('/bookings/{id}', fn () => view('admin.booking-show'))->name('admin.bookings.show');
    // Admin Inventory: Inventory management listing
    Route::get('/inventory', fn () => view('admin.inventory'))->name('admin.inventory');
    // Admin Users: User management listing
    Route::get('/users', fn () => view('admin.users'))->name('admin.users');
    // Admin AI Analysis: Review AI suggested floral materials and pricing
    Route::get('/ai-analysis', fn () => view('admin.ai-analysis'))->name('admin.ai-analysis');
    // Admin Quotations: Manage price reconfirmation and quotations
    Route::get('/quotations', fn () => view('admin.quotations'))->name('admin.quotations');
    // Admin Return Tracking: Manage post-event asset returns
    Route::get('/return-tracking', fn () => view('admin.return-tracking'))->name('admin.return-tracking');
    // Admin Reports: KPI charts and audit logs
    Route::get('/reports', fn () => view('admin.reports'))->name('admin.reports');
    // Admin Client Records: View client history and records
    Route::get('/client-records', fn () => view('admin.client-records'))->name('admin.client-records');
    // Admin Settings: System preferences and admin controls
    Route::get('/settings', fn () => view('admin.settings'))->name('admin.settings');
});