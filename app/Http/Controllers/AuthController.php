<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\PhpMailerService;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request with email and password.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $login = $validated['login'];
        $password = $validated['password'];

        $attempts = [];
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $attempts[] = ['email' => $login, 'password' => $password];
        }
        $attempts[] = ['username' => $login, 'password' => $password];

        foreach ($attempts as $credentials) {
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();

                $user = Auth::user();
                $redirectRoute = $user->role === 'admin' || $user->role === 'staff'
                    ? route('admin.dashboard')
                    : route('client.dashboard');

                return redirect()->intended($redirectRoute)
                    ->with('success', 'Welcome back, ' . $user->first_name . '!');
            }
        }

        return back()
            ->withInput($request->only('login'))
            ->with('error', 'Invalid login credentials. Please try again.');
    }

    /**
     * Show the registration page.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        // Get validated data
        $validated = $request->validated();

        // Create new user
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'mobile_number' => $validated['mobile_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'client', // New registrations default to client role
        ]);

        // Automatically log in the newly registered user
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        return redirect()->route('client.dashboard')->with('success', 'Account created successfully! Welcome, ' . $user->first_name . '!');
    }

    /**
     * Show the forgot password page.
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send the password reset link to the provided email address.
     */
    public function sendPasswordResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'No account was found with that email address.',
        ]);

        // If configured to use PHPMailer, create the token and send via PHPMailer
        if (env('USE_PHPMAILER', false)) {
            $user = User::where('email', $request->input('email'))->first();
            if (! $user) {
                return back()->withErrors(['email' => 'No account was found with that email address.']);
            }

            // Create and store the password reset token manually so we can send a custom HTML email.
            // This mirrors Laravel's broker behavior but allows a Gmail/PHPMailer email template.
            $token = Password::broker()->createToken($user);
            $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

            // Send polished HTML email via PHPMailer
            try {
                $mailer = new PhpMailerService();
                $sent = $mailer->sendPasswordReset($user->email, $user->first_name ?? $user->name, $resetUrl);
                if (! $sent) {
                    \Log::warning('PHPMailer reported failure sending reset email to ' . $user->email);
                    return back()->withErrors(['email' => 'Failed to send reset email. Please try again later.']);
                }
            } catch (\Throwable $e) {
                \Log::error('Error sending PHPMailer reset: ' . $e->getMessage());
                return back()->withErrors(['email' => 'Failed to send reset email. Please try again later.']);
            }

            return back()->with('status', 'Password reset link sent.');
        }

        // Fallback: use Laravel's broker which sends via the configured mailer
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the password reset page.
     */
    public function showResetPasswordForm(Request $request, ?string $token = null): View
    {
        $email = $request->email;
        $user = $email ? User::where('email', $email)->first() : null;

        // Pass the full name to the view so the reset form displays the user's name.
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
            'fullName' => $user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) : null,
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'No account was found with that email address.',
            'password.required' => 'New password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password has been reset. You can now log in.')
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Handle logout request.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        // Invalidate session
        request()->session()->invalidate();

        // Regenerate CSRF token
        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
