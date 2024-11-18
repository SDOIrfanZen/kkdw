<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akaun Anda Telah Diluluskan</title>
</head>
<body>
    <h1>Akaun Anda Telah Diluluskan</h1>
    <p>Hai, {{ $user->nama }}</p>
    <p>Tahniah! Akaun anda telah berjaya diluluskan oleh pihak pentadbir sistem. Anda kini boleh log masuk ke platform menggunakan maklumat yang anda berikan semasa pendaftaran.</p>
    <p><strong>Pautan log masuk:</strong> <a href="{{ route('auth.login') }}" target="_blank">Klik di sini untuk log masuk</a></p>
</body>
</html>
