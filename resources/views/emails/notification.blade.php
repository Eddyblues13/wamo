<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $heading }}</title>
</head>
<body style="margin:0;background:#0b0f1a;font-family:Helvetica,Arial,sans-serif;color:#e8ecf5;">
    <div style="max-width:520px;margin:0 auto;padding:40px 24px;">
        <div style="text-align:center;margin-bottom:26px;">
            <span style="font-size:22px;font-weight:800;color:#ffffff;">Wamo</span><span style="font-size:22px;font-weight:800;color:#8ab4ff;"> International</span>
        </div>

        <div style="background:#121726;border:1px solid #232a3d;border-radius:20px;padding:32px;">
            <h1 style="margin:0 0 6px;font-size:20px;color:#ffffff;">{{ $heading }}</h1>
            <p style="margin:0 0 18px;font-size:14px;color:#9aa4bd;">Hi {{ $greetingName }},</p>

            @foreach ($lines as $line)
                <p style="margin:0 0 12px;font-size:14px;line-height:1.6;color:#c7cede;">{{ $line }}</p>
            @endforeach

            @if (! empty($details))
                <table style="width:100%;border-collapse:collapse;margin:18px 0 6px;">
                    @foreach ($details as $key => $value)
                        <tr>
                            <td style="padding:11px 0;border-bottom:1px solid #232a3d;font-size:13px;color:#9aa4bd;">{{ $key }}</td>
                            <td style="padding:11px 0;border-bottom:1px solid #232a3d;font-size:13px;color:#ffffff;font-weight:600;text-align:right;">{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif

            @if ($note)
                <p style="margin:16px 0 0;font-size:13px;line-height:1.6;color:#9aa4bd;">{{ $note }}</p>
            @endif

            @if ($ctaText && $ctaUrl)
                <div style="text-align:center;margin-top:26px;">
                    <a href="{{ $ctaUrl }}" style="display:inline-block;background:#5b6cff;color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;padding:13px 28px;border-radius:12px;">{{ $ctaText }}</a>
                </div>
            @endif
        </div>

        <p style="text-align:center;margin:24px 0 0;font-size:12px;line-height:1.7;color:#5f6982;">
            © {{ date('Y') }} Wamo International. Investing involves risk. Capital at risk.<br>
            This is an automated message — please do not reply.
        </p>
    </div>
</body>
</html>
