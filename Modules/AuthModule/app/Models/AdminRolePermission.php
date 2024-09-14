<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AuthModule\Database\Factories\AdminRolePermissionFactory;

class AdminRolePermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
}
