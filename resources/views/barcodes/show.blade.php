<!-- resources/views/barcodes/show.blade.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о товаре</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Информация о товаре</h1>
    <table class="table">
        <tr>
            <th>Штрихкод</th>
            <td>{{ $page->barcode }}</td>
        </tr>
        <tr>
            <th>Статус</th>
            <td>{{ $page->status }}</td>
        </tr>
        <tr>
            <th>Дата создания</th>
            <td>{{ $page->created_at->format('d.m.Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Дата обновления</th>
            <td>{{ $page->updated_at->format('d.m.Y H:i:s') }}</td>
        </tr>
    </table>

    <!-- Сообщения об ошибках и успехах -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Форма для обновления статуса -->
    <form action="{{ route('barcodes.updateStatus', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="status" class="form-label">Обновить статус</label>
            <select name="status" id="status" class="form-select" required>
                @foreach (App\Models\Page::STATUSES as $status)
                    <option value="{{ $status }}" {{ $status === $page->status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Обновить статус</button>
    </form>

    <a href="{{ route('barcodes.index') }}" class="btn btn-secondary mt-3">Назад</a>
</div>
</body>
</html>
