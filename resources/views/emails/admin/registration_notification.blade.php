<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Pengguna Baharu</title>
</head>
<body>
    <h2>Pengguna Baharu Telah Berdaftar</h2>
    <p>Seorang pengguna baharu telah mendaftar di platform:</p>
    <p><strong>Nama:</strong> {{ $userName }}</p>
    <p><strong>email:</strong> {{ $userEmail }}</p>
    <p><strong>No. Telefon:</strong> {{ $userPhone }}</p>
    <p>Sila log masuk ke sistem untuk menyemak pendaftaran ini dan mengambil tindakan selanjutnya.</p>
    <p><a href="{{ route('auth.login') }}" target="_blank">Klik di sini untuk ke laman web</a></p>
</body>
</html>
