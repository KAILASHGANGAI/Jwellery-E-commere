<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AuthModule\Database\Factories\AdminRoleFactory;

class AdminRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): AdminRoleFactory
    {
        //return AdminRoleFactory::new();
    }
}
