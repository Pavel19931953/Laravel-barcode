<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <style>

        /* Устанавливаем шрифт DejaVu Sans для поддержки кириллицы */
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('https://example.com/path/to/DejaVuSans.ttf'); /* Укажите реальный путь к шрифту, если он не установлен */
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            text-align: center;
            font-size: 14px;
            color: #333;
        }
        .product-info {
            font-size: 18px;
            margin-top: 10px;
        }
        .barcode-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Информация о продукте</h1>
<div class="product-info">
    <p><strong>Название:</strong> {{ $product->name }}</p>
    <p><strong>Цена:</strong> {{ $product->price }} грн.</p>
    <p><strong>Штрихкод:</strong> {{ $product->barcode }}</p>
</div>

<div class="barcode-container">
    <img src="data:image/png;base64,{{ $barcode }}" alt="Штрихкод продукта">
</div>
</body>
</html>
