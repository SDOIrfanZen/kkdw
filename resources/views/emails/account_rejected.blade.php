<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akaun Anda Telah Ditolak</title>
</head>
<body>
    <h1>Akaun Anda Telah Ditolak</h1>
    <p>Hai, {{ $user->nama }}</p>
    <p>Maaf, akaun anda tidak diluluskan oleh pihak pentadbir sistem. Ini mungkin disebabkan oleh maklumat yang tidak lengkap atau tidak memenuhi keperluan pendaftaran.</p>
    <p><strong>Sebab Penolakan:</strong> {{ $remark }}</p>
    <p>Sila semak semula maklumat yang telah diberikan dan hubungi kami jika anda memerlukan bantuan lanjut.</p>
</body>
</html>
