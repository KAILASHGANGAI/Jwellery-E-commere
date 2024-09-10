<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
