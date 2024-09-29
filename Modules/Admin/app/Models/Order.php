<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // cusomer 
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // order product
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
    // delivary location
    public function delivaryLocation()
    {
        return $this->belongsTo(DelivaryLocation::class, 'delivary_location_id');
    }
}
