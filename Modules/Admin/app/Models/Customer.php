<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    public function delivaryLocation()
    {
        return $this->hasMany(DelivaryLocation::class, 'customer_id');
    }
}