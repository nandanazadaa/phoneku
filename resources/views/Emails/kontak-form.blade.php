<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak Baru</title>
    <style> 
        /* Style untuk mobile */
        @media screen and (max-width: 600px) {
            .content-container {
                width: 100% !important;
                padding: 15px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7f6; font-family: Arial, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 20px 0;">
                <table class="content-container" role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="padding: 30px 20px 20px 20px;">
                            {{-- Ganti "URL_LOGO_ANDA" dengan URL logo PhoneKu --}}
                            <img src="https://i.imgur.com/9zUSuEN.png" alt="PhoneKu Logo" width="150" style="display: block;">
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 30px;">
                            <h2 style="font-size: 24px; color: #0d6efd; margin-top: 0; margin-bottom: 20px;">Pesan Kontak Baru Diterima</h2>
                            <p style="font-size: 16px; color: #555; margin-bottom: 25px;">Berikut adalah rincian pesan yang masuk melalui formulir kontak website Anda:</p>
                            
                            <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 20px 0;">

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding-bottom: 10px; font-size: 16px; color: #555;"><strong>Nama Lengkap:</strong></td>
                                    <td style="padding-bottom: 10px; font-size: 16px; color: #333; text-align: right;">{{ $data['nama_lengkap'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 10px; font-size: 16px; color: #555;"><strong>Email Pengirim:</strong></td>
                                    <td style="padding-bottom: 10px; font-size: 16px; color: #333; text-align: right;">{{ $data['email'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 20px; font-size: 16px; color: #555;"><strong>Subjek:</strong></td>
                                    <td style="padding-bottom: 20px; font-size: 16px; color: #333; text-align: right;">{{ $data['subjek'] }}</td>
                                </tr>
                            </table>

                            <h3 style="font-size: 18px; color: #333; margin-top: 20px; border-bottom: 2px solid #0d6efd; padding-bottom: 8px;">Isi Pesan</h3>
                            <div style="background-color: #f9fafb; border-radius: 5px; padding: 15px; margin-top: 15px;">
                                <p style="font-size: 16px; color: #555; white-space: pre-wrap; margin: 0;">{{ $data['pesan'] }}</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 30px 20px; background-color: #f4f7f6; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                            <p style="font-size: 14px; color: #999; margin: 0;">© {{ date('Y') }} PhoneKu. Semua Hak Cipta Dilindungi.</p>
                            <p style="font-size: 12px; color: #aaa; margin: 5px 0 0 0;">Email ini dikirim secara otomatis.</p>
                        </td>
                    </tr>

                </table>
                </td>
        </tr>
    </table>
</body>
</html>