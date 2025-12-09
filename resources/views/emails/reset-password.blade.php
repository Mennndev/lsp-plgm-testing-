<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LSP PLGM</title>
</head>

<body style="margin:0; padding:0; background:#f4f6fb; font-family:Arial, sans-serif;">

    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">

                <table width="580" cellpadding="0" cellspacing="0" style="background:#ffffff; margin-top:40px; border-radius:12px; overflow:hidden; box-shadow:0 4px 14px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td align="center" style="background:#233C7E; padding:24px 0;">
                            <img src="{{ asset('images/logo.png') }}" width="120" alt="LSP PLGM">
                            <h2 style="color:#ffffff; margin:10px 0 0; font-weight:600;">
                                Reset Password Akun Anda
                            </h2>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:32px; color:#333; font-size:15px; line-height:1.7;">
                            <p>Halo,</p>

                            <p>
                                Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.
                                Silakan klik tombol di bawah ini untuk mengatur ulang password:
                            </p>

                            <br>

                            <!-- BUTTON -->
                            <div style="text-align:center;">
                                <a href="{{ $url }}"
                                   style="background:#233C7E; color:#ffffff; padding:14px 24px;
                                          font-size:15px; text-decoration:none; border-radius:6px;
                                          display:inline-block;">
                                    Reset Password
                                </a>
                            </div>

                            <br><br>

                            <p>
                                Jika Anda tidak meminta reset password, abaikan email ini.
                                Link reset password ini hanya berlaku selama **60 menit**.
                            </p>

                            <p>Terima kasih,<br><strong>LSP Politeknik LP3I Global Mandiri</strong></p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="background:#f0f2f7; padding:18px; font-size:12px; color:#666;">
                            © {{ date('Y') }} LSP PLGM — Semua Hak Dilindungi.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
