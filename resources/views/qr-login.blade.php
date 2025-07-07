<!DOCTYPE html>
<html>
<head>
    <title>QR Login</title>
</head>
<body>
    <h2>Scan this QR code with your mobile app:</h2>
    {!! QrCode::size(300)->generate($token) !!}
    <p>Token: {{ $token }}</p>
</body>
</html>
