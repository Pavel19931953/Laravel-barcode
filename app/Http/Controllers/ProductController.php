<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    // Метод для отображения формы и списка продуктов
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Метод для добавления нового продукта
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Генерация уникального EAN-13 штрихкода
        $barcode = $this->generateUniqueBarcode();

        // Создание продукта
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'barcode' => $barcode,
        ]);

        return redirect()->route('products.index')->with('success', 'Продукт успешно добавлен!');
    }

    // Генерация уникального штрихкода EAN-13
    private function generateUniqueBarcode()
    {
        do {
            $number = str_pad(random_int(0, 999999999999), 12, '0', STR_PAD_LEFT);
            $barcode = $number . $this->calculateEAN13Checksum($number);
        } while (Product::where('barcode', $barcode)->exists());

        return $barcode;
    }

    // Подсчет контрольного символа для штрихкода
    private function calculateEAN13Checksum($number)
    {
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += ($i % 2 === 0 ? 1 : 3) * $number[$i];
        }
        return (10 - ($sum % 10)) % 10;
    }

    // Метод для генерации PDF со штрихкодом
    public function generatePDF(Product $product)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($product->barcode, $generator::TYPE_EAN_13);

        $pdf = Pdf::loadView('products.barcode_pdf', [
            'product' => $product,
            'barcode' => base64_encode($barcode),
        ]);

        return $pdf->download('product_' . $product->id . '.pdf');
    }
}
