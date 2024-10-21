<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\AuthModule\Models\AdminUser;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    // created with created by user 
    public function createdBy()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }

    // categories 
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
