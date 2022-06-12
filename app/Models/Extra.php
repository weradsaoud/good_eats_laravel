<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'extra_variant', 'extra_id', 'variant_id');
    }
}
