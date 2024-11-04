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

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    //get always only status =1 dataalways only status =1 data

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id', 'id');
    }

    public function permission()
    {
        return $this->hasMany(AdminPermission::class, 'admin_permission_id', 'id');
    }
}
