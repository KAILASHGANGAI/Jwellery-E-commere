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
    

    
}
