
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Генерация Штрихкодов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label, input, select, button {
            font-size: 16px;
        }
        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .table-container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Создание и Управление Штрихкодами</h2>

    <!-- Форма для создания штрихкодов -->
    <form action="{{ route('barcodes.pdf') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="count">Количество штрихкодов:</label>
            <input type="number" id="count" name="count" min="1" required>
        </div>
        <div class="form-group">
            <label for="status">Статус продукции:</label>
            <select id="status" name="status">
                <option value="на складе">На складе</option>
                <option value="в пути">В пути</option>
                <option value="доставлен">Доставлен</option>
            </select>
        </div>
        <button type="submit">Создать PDF</button>
    </form>

    <!-- Таблица для отображения существующих штрихкодов -->
    <div class="table-container">
        <h3 class="text-center">Существующие штрихкоды</h3>
        <table class="table table-striped mt-4">
            <thead>
            <tr>
                <th>Штрихкод</th>
                <th>Статус</th>
                <th>Обновить статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->barcode }}</td>
                    <td>{{ ucfirst($page->status) }}</td>
                    <td>
                        <form action="{{ route('barcodes.updateStatus', $page->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <select name="status" class="form-select">
                                    <option value="на складе" {{ $page->status == 'на складе' ? 'selected' : '' }}>На складе</option>
                                    <option value="в пути" {{ $page->status == 'в пути' ? 'selected' : '' }}>В пути</option>
                                    <option value="доставлен" {{ $page->status == 'доставлен' ? 'selected' : '' }}>Доставлен</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
