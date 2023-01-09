<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredienteType extends Model
{
    use HasFactory;
    const FRUITS = 'fruits';
    const VEGETABLES = 'vegetables';
    const LIQUID = 'liquid';
}
