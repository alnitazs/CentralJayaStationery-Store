<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">

    <p>Halo, {{ $formData['user']->name }}</p>

    <h1>Anda telah meminta untuk mereset kata sandi:</h1>

    <p>Tolong tekan link dibawah untuk reset kata sandi</p>

    <a href="{{ route('front.resetPassword',$formData['token']) }}">Click here</a>

    <p>Terima kasih</p>

</body>
</html>