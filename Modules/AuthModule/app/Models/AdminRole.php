<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AuthModule\Database\Factories\AdminRoleFactory;

class AdminRole extends Model
{
    use HasFactory, SoftDeletes;

   protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function role_permissions()
    {
        return $this->hasMany(AdminRolePermission::class, 'admin_role_id', 'id');
    }

    public function role_users()
    {
        return $this->hasMany(AdminRoleUser::class, 'admin_role_id', 'id');
    }

}
