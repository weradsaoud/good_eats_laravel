<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'sat_from',
        'sat_to',
        'sun_from',
        'sun_to',
        'mon_from',
        'mon_to',
        'tue_from',
        'tue_to',
        'wed_from',
        'wed_to',
        'thur_from',
        'thur_to',
        'fri_from',
        'fri_to',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
