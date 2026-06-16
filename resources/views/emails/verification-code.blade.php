<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your verification code</title>
</head>
<body style="margin:0;background:#0b0f1a;font-family:Helvetica,Arial,sans-serif;color:#e8ecf5;">
    <div style="max-width:480px;margin:0 auto;padding:40px 24px;">
        <div style="text-align:center;margin-bottom:28px;">
            <span style="display:inline-block;font-size:22px;font-weight:800;color:#ffffff;">Wamo</span><span style="font-size:22px;font-weight:800;color:#8ab4ff;"> International</span>
        </div>

        <div style="background:#121726;border:1px solid #232a3d;border-radius:20px;padding:32px;text-align:center;">
            <h1 style="margin:0 0 8px;font-size:20px;color:#ffffff;">Verify your email</h1>
            <p style="margin:0 0 24px;font-size:14px;line-height:1.6;color:#9aa4bd;">
                Hi {{ $name }}, use the code below to confirm your email address and activate your Wamo account.
            </p>

            <div style="display:inline-block;background:#0b0f1a;border:1px solid #2b3450;border-radius:14px;padding:18px 28px;">
                <span style="font-size:40px;font-weight:800;letter-spacing:14px;color:#8ab4ff;">{{ $code }}</span>
            </div>

            <p style="margin:24px 0 0;font-size:13px;color:#9aa4bd;">
                This code expires in 10 minutes. If you didn’t request it, you can safely ignore this email.
            </p>
        </div>

        <p style="text-align:center;margin:24px 0 0;font-size:12px;color:#5f6982;">
            © {{ date('Y') }} Wamo International. Investing involves risk. Capital at risk.
        </p>
    </div>
</body>
</html>
