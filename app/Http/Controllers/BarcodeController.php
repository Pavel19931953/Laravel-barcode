<?php
// app/Http/Controllers/BarcodeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarcodeController extends Controller
{
    public function index()
    {
        $pages = Page::all(); // Получаем все страницы (товары)
        return view('barcodes.index', compact('pages')); // Возвращаем представление с данными
    }

    public function generateBarcode()
    {
        // Получаем последний штрихкод из базы данных
        $lastPage = Page::orderBy('created_at', 'desc')->first();
        $barcode = $lastPage ? (int)$lastPage->barcode + 1 : 100000; // Определяем новый штрихкод

        // Проверяем, существует ли уже этот штрихкод
        while (Page::where('barcode', $barcode)->exists()) {
            $barcode++;
        }

        // Создаем новый штрихкод с полем статуса "на складе"
        $page = Page::create(['barcode' => $barcode, 'status' => 'на складе']);

        // Генерация QR-кода с ссылкой на товар
        $url = route('barcodes.show', ['barcode' => $barcode, 'status' => $page->status]); // Включаем статус в URL
        $qrCode = QrCode::size(200)->generate($url); // Генерация QR-кода

        return [
            'barcode' => $barcode,
            'qrCode' => $qrCode // Возвращаем штрихкод и QR-код
        ];
    }

    public function generatePdf(Request $request)
    {
        $count = $request->input('count', 1); // Получаем количество штрихкодов
        $barcodes = []; // Массив для хранения штрихкодов

        for ($i = 0; $i < $count; $i++) {
            $result = $this->generateBarcode(); // Генерация штрихкода
            $barcodes[] = $result; // Добавляем в массив
        }

        $pdf = Pdf::loadView('barcodes.pdf', compact('barcodes')); // Загружаем представление для PDF
        return $pdf->download('barcodes.pdf'); // Возвращаем скачиваемый PDF
    }

    // Новый метод для отображения информации о товаре
    public function show($barcode)
    {
        $page = Page::where('barcode', $barcode)->first(); // Поиск товара по штрихкоду

        if (!$page) {
            return redirect()->route('barcodes.index')->with('error', 'Товар не найден.'); // Если не найден, возвращаем сообщение
        }

        return view('barcodes.show', compact('page')); // Возвращаем представление с товаром
    }

    public function updateStatus(Request $request, Page $page)
    {
        // Валидация входных данных
        $request->validate([
            'status' => 'required|string|in:' . implode(',', Page::STATUSES),
        ]);

        // Получаем статус
        $status = $request->input('status');

        // Проверяем, если статус — это массив, и берем первое значение
        if (is_array($status)) {
            $status = $status[0]; // Получаем первое значение массива
        }

        // Обновление статуса страницы
        $page->status = strtoupper($status); // Применение strtoupper для верхнего регистра
        $page->save(); // Сохраняем изменения

        return redirect()->back()->with('success', 'Статус обновлен'); // Возвращаем сообщение об успехе
    }
}
