<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'image',
        'price',
        'type',
    ];
    public $timestamps = false;

    public function presets()
    {
        return $this->belongsToMany(Preset::class, 'preset_ingredients')
                    ->withPivot('amount');
    }
}
