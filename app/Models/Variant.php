<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $fillable = [
        'options',
        'price'
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'extra_variant', 'variant_id', 'extra_id');
    }
}
