<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

// Home Page: Landing page route
Route::get('/', fn () => view('home'))->name('home');
// Gallery Page: Dedicated gallery showcase
Route::get('/gallery', fn () => view('gallery'))->name('gallery');
// About Page: Dedicated about page
Route::get('/about', fn () => view('about'))->name('about');

// Authentication Routes: Real session-based authentication
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');

    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout Route: Authenticated users only
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Client Routes: Protected by authentication middleware
Route::prefix('client')->middleware('auth')->group(function () {
    // Client Dashboard: Main portal overview
    Route::get('/dashboard', fn () => view('client.dashboard'))->name('client.dashboard');

    // Client Bookings: Lists user's active bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');

    // Client Booking Create: Displays new booking form
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');

    // Client Booking Store: Processes booking form submission and shows AI analysis
    Route::post('/bookings/create', [BookingController::class, 'store'])->name('bookings.store');

    // Client Booking Analysis: Shows booking AI analysis result
    Route::get('/bookings/analysis/{booking}', [BookingController::class, 'analysis'])->name('bookings.analysis');
    Route::post('/bookings/{booking}/accept', [BookingController::class, 'acceptQuotation'])->name('bookings.accept');
    Route::post('/bookings/{booking}/payment-reference', [BookingController::class, 'submitPaymentReference'])->name('bookings.payment.reference');

    // Client Booking History: Shows past bookings
    Route::get('/booking-history', [BookingController::class, 'history'])->name('booking-history');

    // Client Account Settings: User profile management
    Route::get('/account-settings', function (Request $request) {
        $user = $request->user();
        return view('client.account-settings', [
            'user' => $user,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    })->name('account-settings');

    Route::post('/account-settings', function (Request $request) {
        $user = $request->user();
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'mobile_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'required_with:current_password', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            if ($request->hasFile('profile_image')) {
                if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                    \Storage::disk('public')->delete($user->profile_image);
                }
                $path = $request->file('profile_image')->store('profile-images', 'public');
                $user->profile_image = $path;
            }

            if ($request->filled('current_password') || $request->filled('new_password')) {
                if (!\Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
                }

                if ($request->filled('new_password')) {
                    $user->password = \Hash::make($request->new_password);
                }
            }

            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->name = $data['first_name'] . ' ' . $data['last_name'];
            $user->email = $data['email'];
            $user->mobile_number = $data['mobile_number'] ?? null;
            $user->address = $data['address'] ?? null;
            $user->save();

            return redirect()->route('account-settings')->with('success', 'Account settings updated successfully.');
        } catch (\Throwable $e) {
            \Log::error('Account settings update error: ' . $e->getMessage());
            return back()->withErrors(['account' => 'Update failed. Please try again.'])->withInput();
        }
    })->name('account-settings.update');
});

// Admin Routes: Protected by authentication and admin role middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard: Main admin panel overview
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::whereIn('status', ['pending', 'quotation_sent', 'payment_pending'])->count(),
            'totalUsers' => User::count(),
            'recentBookings' => Booking::with('client')->latest()->limit(5)->get(),
        ]);
    })->name('admin.dashboard');
    // Admin Bookings: Booking management listing
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings');
    // Admin Booking Review: Specific booking detail view
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    // Admin actions: verify payment and decline booking
    Route::post('/payments/{payment}/verify', [AdminBookingController::class, 'verifyPayment'])->name('admin.payments.verify');
    Route::post('/bookings/{booking}/decline', [AdminBookingController::class, 'decline'])->name('admin.bookings.decline');
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
