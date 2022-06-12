<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'adress',
        'logo',
        'cover',
        'active',
        'description',
        'can_deliver',
        'deliver_minimum_spend',
        'can_pickup',
        'pickup_minimum_spend',
        'can_table_order',
        'table_oredr_minimum_spend'
    ];
    // public function __construct(
    //     string $name,
    //     string $email,
    //     string $phone,
    //     //string $adress,
    //     string $logo,
    //     string $cover,
    //     bool $active,
    //     string $description,
    //     bool $can_deliver,
    //     float $deliver_minimum_spend,
    //     bool $can_pickup,
    //     float $pickup_minimum_spend,
    //     bool $can_table_order,
    //     float $table_oredr_minimum_spend
    // ) {
    //     $this->name = $name;
    //     $this->email = $email;
    //     $this->phone = $phone;
    //     $this->adress = 'good_eats';
    //     $this->logo = $logo;
    //     $this->cover = $cover;
    //     $this->active = $active;
    //     $this->description = $description;
    //     $this->can_deliver = $can_deliver;
    //     $this->deliver_minimum_spend = $deliver_minimum_spend;
    //     $this->can_pickup = $can_pickup;
    //     $this->pickup_minimum_spend = $pickup_minimum_spend;
    //     $this->can_table_order = $can_table_order;
    //     $this->table_oredr_minimum_spend = $table_oredr_minimum_spend;
    // }
    public function hour()
    {
        return $this->hasOne(Hour::class, 'store_id');
    }

    public function tables()
    {
        return $this->hasMany(Table::class, 'store_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'store_id');
    }

    public function icatecories()
    {
        return $this->hasMany(Icategory::class, 'store_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'store_id');
    }

    public function scategories()
    {
        return $this->belongsToMany(Scategory::class, 'scategory_store', 'store_id', 'scategory_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user', 'store_id', 'user_id');
    }
}
