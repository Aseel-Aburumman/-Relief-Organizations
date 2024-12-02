<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }

        .email-header {
            background-color: #28a745;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
            line-height: 1.6;
        }

        .email-body p {
            margin: 10px 0;
        }

        .email-footer {
            text-align: center;
            padding: 10px;
            background-color: #f1f3f5;
            font-size: 12px;
            color: #6c757d;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Reset Your Password</h1>
        </div>
        <div class="email-body">
            <p>Dear User,</p>
            <p>You recently requested to reset your password for your account at <strong>Charifit</strong>. Click the
                button below to reset it:</p>
            <a href="{{ $resetLink }}" class="button">Reset Password</a>
            <p>If you didn’t request a password reset, please ignore this email or let us know.</p>
            <p>Thank you for using <strong>Charifit</strong>.</p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Charifit. All rights reserved.
        </div>
    </div>
</body>

</html>
