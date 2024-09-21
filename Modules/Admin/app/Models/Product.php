<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }   
  
}
