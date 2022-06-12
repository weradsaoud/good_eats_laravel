<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'scategory_store', 'scategory_id', 'store_id');
    }
    
}
