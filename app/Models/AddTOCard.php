<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Order;
use Modules\Admin\Models\Product;

class AddTOCard extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected    $table = 'add_to_cards';
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateTotalPrice($quantity, $unit_price, $discount = 0)
    {
        $subtotal = $quantity * $unit_price;
        return $subtotal - $discount;
    }

}
