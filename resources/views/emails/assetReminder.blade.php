<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asset Expiration Reminder</title>
</head>
<body>
    <h2>Pengingat Kalibrasi Alat</h2>

    <p>Halo,</p>

    <p>Berikut adalah pengingat bahwa aset berikut akan segera <strong>kedaluwarsa</strong>:</p>

    <ul>
        <li><strong>Nama Aset:</strong> {{ $asset->category->category }}</li>
        <li><strong>Serial Number:</strong> {{ $asset->series_number }}</li>
        <li><strong>Expired Date:</strong> {{ \Carbon\Carbon::parse($asset->expired_date)->format('d M Y') }}</li>
    </ul>

    <p>Segera lakukan tindakan untuk memastikan aset tetap sesuai standar kalibrasi.</p>

    <p>Terima kasih.</p>
</body>
</html>