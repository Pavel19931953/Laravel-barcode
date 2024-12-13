<?php

// app/Models/Page.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    // Определяем заполняемые поля
    protected $fillable = ['barcode', 'status'];

    // Задаем статусы в виде массива
    public const STATUSES = [
        'на складе',   // Товар находится на складе
        'в пути',      // Товар в процессе доставки
        'доставлен',   // Товар доставлен
    ];

    // Метод для получения всех доступных статусов
    public static function getAvailableStatuses()
    {
        return self::STATUSES;
    }
}
