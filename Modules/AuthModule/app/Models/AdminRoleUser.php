<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AuthModule\Database\Factories\AdminRoleUserFactory;

class AdminRoleUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): AdminRoleUserFactory
    {
        //return AdminRoleUserFactory::new();
    }
}
