<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'options'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
