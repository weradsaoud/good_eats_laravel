<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'available',
        'vat'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function extras()
    {
        return $this->hasMany(Extra::class, 'item_id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'item_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'item_id');
    }

    public function icategories()
    {
        return $this->belongsToMany(Icategory::class, 'icategory_item', 'item_id', 'icategory_id');
    }
}
