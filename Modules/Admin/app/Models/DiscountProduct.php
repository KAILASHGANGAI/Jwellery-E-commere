<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\DiscountProductFactory;

class DiscountProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
}
