<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link to the given email.
     * 
     * Implements security measures:
     * - No user enumeration (same message regardless of email existence)
     * - Rate limiting via throttle middleware
     * - Logging for security monitoring
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate email input - we DON'T check if email exists to prevent enumeration
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Attempt to send the password reset link
        // We use the 'users' broker as configured in config/auth.php
        // This will return INVALID_USER if email doesn't exist, but we handle that
        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        // Log the password reset request for security monitoring
        Log::info('Password reset link requested', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status,
        ]);

        // Always return the same message to prevent user enumeration
        // regardless of whether the email exists or not
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'We have emailed your password reset link!');
        }

        // If we get here (invalid user or other error), still return success message
        // to prevent user enumeration
        return back()->with('status', 'We have emailed your password reset link!');
    }
}
