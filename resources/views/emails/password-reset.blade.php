<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-wrapper {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ffffff;
            text-decoration: none;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a5f;
            margin: 0 0 20px 0;
        }
        .email-text {
            font-size: 16px;
            color: #555555;
            margin: 0 0 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #1d4ed8;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .link-text {
            font-size: 14px;
            color: #666666;
            word-break: break-all;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            font-size: 12px;
            color: #9ca3af;
            margin: 0;
        }
        .warning-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-text {
            font-size: 14px;
            color: #92400e;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-wrapper">
            <!-- Header -->
            <div class="email-header">
                <a href="{{ config('app.url') }}" class="logo">{{ $appName }}</a>
            </div>

            <!-- Body -->
            <div class="email-body">
                <h1 class="email-title">Reset Your Password</h1>
                
                <p class="email-text">
                    Hello,
                </p>
                
                <p class="email-text">
                    We received a request to reset your password for your <strong>{{ $appName }}</strong> account. 
                    Click the button below to create a new password.
                </p>

                <!-- Button -->
                <div class="button-container">
                    <a href="{{ $resetUrl }}" class="button">Reset Password</a>
                </div>

                <p class="email-text">
                    If you didn't request a password reset, you can safely ignore this email. 
                    Your password will remain unchanged.
                </p>

                <!-- Warning Box -->
                <div class="warning-box">
                    <p class="warning-text">
                        <strong>Important:</strong> This password reset link will expire in 60 minutes for security reasons. 
                        If you didn't request this, please contact our support team immediately.
                    </p>
                </div>

                <!-- Direct Link -->
                <p class="email-text" style="margin-top: 30px;">
                    If the button above doesn't work, copy and paste the following link into your browser:
                </p>
                <p class="link-text">
                    <a href="{{ $resetUrl }}" style="color: #2563eb;">{{ $resetUrl }}</a>
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p class="footer-text">
                    &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.
                </p>
                <p class="footer-text" style="margin-top: 8px;">
                    This is an automated message. Please do not reply directly to this email.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
