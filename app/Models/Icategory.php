<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'icategory_item', 'icategory_id', 'item_id');
    }
}
