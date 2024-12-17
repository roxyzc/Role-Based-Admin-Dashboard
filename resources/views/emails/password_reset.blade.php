<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .button {
            display: inline-block;
            background-color: #007BFF;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 25px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }
        p a.button {
            color: white;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .message {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Permintaan Reset Password</h2>
        <p class="message">Halo,</p>
        <p class="message">Kami menerima permintaan untuk mereset password akun Anda. Jika Anda yang mengajukan permintaan ini, Anda dapat mereset password dengan mengklik tombol di bawah ini.</p>
        
        <p>
            <a href="{{ $resetLink }}" class="button">Reset Password Anda</a>
        </p>

        <p class="message">Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini. Password Anda akan tetap aman.</p>

        <p class="message">Terima kasih,<br>Tim Kami</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis. Harap tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
