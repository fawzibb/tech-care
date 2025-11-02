<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - Tech Care Store</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color:#f8f9fa; color:#333; margin:0; padding:0; }
        .container { background:white; max-width:600px; margin:40px auto; padding:30px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        .logo { text-align:center; margin-bottom:20px; }
        .logo img { height:50px; }
        .btn { background-color:#0d6efd; color:white; padding:12px 25px; text-decoration:none; border-radius:6px; display:inline-block; font-weight:600; }
        .footer { text-align:center; margin-top:30px; font-size:13px; color:#777; }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Tech Care Store Logo">
    </div>
    <h2>Hello,</h2>
    <p>Thank you for signing up with <strong>Tech Care Store</strong>!</p>
    <p>Please verify your email address by clicking the button below:</p>

    <p style="text-align:center;">
        <a href="{{ $url }}" class="btn">Verify Email Address</a>
    </p>

    <p>If you didn’t create this account, you can safely ignore this email.</p>

    <p>Best regards,<br><strong>Tech Care Store Team</strong></p>

    <div class="footer">
        &copy; {{ date('Y') }} Tech Care Store. All rights reserved.
    </div>
</div>
</body>
</html>
