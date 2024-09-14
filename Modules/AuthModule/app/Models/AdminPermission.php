<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AuthModule\Database\Factories\AdminPermissionFactory;

class AdminPermission extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
  protected $guarded = [];

  protected $hidden = ['created_at', 'updated_at'];
}
