<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    public const CATEGORIES = ['entradas', 'platos-fuertes', 'ensaladas', 'postres', 'bebidas'];

    protected $fillable = ['name', 'description', 'price', 'category', 'is_available'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }
}
