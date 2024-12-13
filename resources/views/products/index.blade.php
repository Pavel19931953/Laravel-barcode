
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление продуктами</title>
    <style>
body { font-family: DejaVu Sans, sans-serif; background-color: #f4f4f4; }
    h1 { margin-bottom: 20px; }
        form { margin-bottom: 30px; background: #fff; padding: 20px; border-radius: 5px; }
    .product-list { margin-top: 20px; list-style-type: none; padding: 0; }
        .product-list li { background: #fff; margin-bottom: 10px; padding: 10px; }
    </style>
</head>
<body>
    <h1>Управление продуктами</h1>

    <form action="{{ route('products.store') }}" method="POST">
@csrf
<input type="text" name="name" placeholder="Название продукта" required>
<input type="number" name="price" placeholder="Цена продукта" required>
<button type="submit">Создать продукт</button>
</form>

<h2>Список продуктов</h2>
<ul class="product-list">
    @foreach ($products as $product)
        <li>
            {{ $product->name }} - {{ $product->price }} грн. (Штрихкод: {{ $product->barcode }})
            <form action="{{ route('products.generatePDF', $product->id) }}" method="GET">
                <button type="submit">Скачать PDF</button>
            </form>
        </li>
    @endforeach
</ul>
</body>
</html>

