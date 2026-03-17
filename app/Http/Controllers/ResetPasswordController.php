<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset form.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle a password reset request.
     * 
     * Implements security measures:
     * - Strong password validation
     * - Password confirmation matching
     * - bcrypt hashing
     * - Token validation
     * - Logging for security monitoring
     */
    public function reset(Request $request)
    {
        // Validate the password reset request
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.mixed_case' => 'The password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'The password must contain at least one number.',
            'password.symbols' => 'The password must contain at least one special character.',
            'password.uncompromised' => 'The password has been compromised. Please choose a different password.',
        ]);

        // Attempt to reset the password
        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Set the new password with bcrypt hashing
                $user->password = Hash::make($password);
                
                // Regenerate the remember token for security
                $user->setRememberToken(Str::random(60));
                
                // Save the user
                $user->save();

                // Log the password change for security monitoring
                Log::info('Password reset successful', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
            }
        );

        // Log the password reset attempt
        Log::info('Password reset attempt', [
            'email' => $request->email,
            'status' => $status,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Return appropriate response
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('userslogin')->with('status', 'Your password has been reset successfully! Please login with your new password.');
        }

        // Return error with generic message to prevent user enumeration
        return back()->withInput($request->only('email'))
            ->with('error', 'The password reset link is invalid or has expired. Please request a new one.');
    }
}
