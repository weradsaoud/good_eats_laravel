<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_phone',
        'price',
        'order_time',
        'status',
        'client_address',
        'client_note'
    ];


    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_order', 'order_id', 'item_id')
        ->withPivot('count');
    }
    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'extra_order', 'order_id', 'extra_id')
        ->withPivot('count');
    }
    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'order_variant', 'order_id', 'variant_id')
        ->withPivot('count');
    }
}
