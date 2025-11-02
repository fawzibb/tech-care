@php
    $isReset = Str::contains($slot ?? '', 'Reset Password');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $isReset ? 'Reset Your Password' : 'Verify Your Email' }} | Tech Care Store</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #fff;
            max-width: 600px;
            margin: 40px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px 40px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            height: 50px;
        }
        h1 {
            color: #0d6efd;
            font-size: 22px;
            text-align: center;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
            margin-top: 25px;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Tech Care Store Logo">
        </div>

        <h1>{{ $isReset ? 'Reset Your Password' : 'Hello!' }}</h1>

        @if($isReset)
            <p>We received a request to reset your password for your <strong>Tech Care Store</strong> account.</p>
            <p>Click the button below to set a new password:</p>
        @else
            <p>Thank you for signing up with <strong>Tech Care Store</strong>.</p>
            <p>Please verify your email address by clicking the button below:</p>
        @endif

        <div style="text-align:center;">
            <a href="{{ $actionUrl }}" class="btn">
                {{ $isReset ? 'Reset Password' : 'Verify Email Address' }}
            </a>
        </div>

        @if($isReset)
            <p>If you didn’t request a password reset, you can safely ignore this email.</p>
        @else
            <p>If you didn’t create this account, you can safely ignore this email.</p>
        @endif

        <p>Best regards,<br><strong>Tech Care Store Team</strong></p>

        <div class="footer">
            © {{ date('Y') }} Tech Care Store. All rights reserved.
        </div>
    </div>
</body>
</html>
