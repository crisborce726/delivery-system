<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP Verification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .otp-code { 
            font-size: 32px; 
            font-weight: bold; 
            letter-spacing: 10px; 
            background: #f4f4f4; 
            padding: 15px; 
            text-align: center; 
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📧 OTP Verification Code</h2>
        
        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        
        <p>Thank you for registering! Please use the following OTP code to verify your account:</p>
        
        <div class="otp-code">
            {{ $otpCode }}
        </div>
        
        <p><strong>This code will expire in {{ $expiresIn }} minutes.</strong></p>
        
        <p>Enter this code on the verification page to complete your registration.</p>
        
        <div class="footer">
            <p>If you didn't request this, please ignore this email.</p>
            <p>Thank you,<br><strong>{{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>
</html>