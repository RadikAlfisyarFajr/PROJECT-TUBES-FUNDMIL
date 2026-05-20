<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password FUNDMIL Soreang</title>
</head>
<body style="margin:0;background:#f2f5f1;font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;color:#17211b;">
    <div style="max-width:560px;margin:0 auto;padding:32px 18px;">
        <div style="background:#ffffff;border:1px solid #e2ebe4;border-radius:16px;padding:28px;">
            <h1 style="margin:0 0 12px;font-size:22px;color:#096b26;">Reset Password</h1>
            <p style="margin:0 0 16px;line-height:1.6;">Halo {{ $user->name }},</p>
            <p style="margin:0 0 22px;line-height:1.6;">
                Kami menerima permintaan reset password untuk akun FUNDMIL Soreang Anda. Link ini berlaku selama 1 jam.
            </p>
            <p style="margin:0 0 24px;">
                <a href="{{ $resetUrl }}" style="display:inline-block;background:#0f722b;color:#ffffff;text-decoration:none;padding:13px 18px;border-radius:12px;font-weight:700;">
                    Reset Password
                </a>
            </p>
            <p style="margin:0 0 16px;line-height:1.6;color:#536058;">
                Jika tombol tidak dapat diklik, buka link berikut:
            </p>
            <p style="margin:0 0 20px;word-break:break-all;color:#096b26;">{{ $resetUrl }}</p>
            <p style="margin:0;line-height:1.6;color:#536058;">
                Abaikan email ini jika Anda tidak meminta reset password.
            </p>
        </div>
    </div>
</body>
</html>
