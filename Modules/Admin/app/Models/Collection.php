<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    // self relation 

    public function products() {
        return $this->hasMany(Product::class);
    }

    //parent child relation 

    public function parent() {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function children() {
        return $this->hasMany(Collection::class, 'collection_id');
    }
   
}
