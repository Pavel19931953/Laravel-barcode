<!-- resources/views/barcodes/pdf.blade.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
</head>
<body>
@foreach ($barcodes as $barcode)
    <div style="page-break-after: always; text-align: center; margin-top: 200px;">
        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcode['barcode'], 'C39') }}" alt="barcode">
        <p>{{ $barcode['barcode'] }}</p>
    </div>
@endforeach
</body>
</html>
