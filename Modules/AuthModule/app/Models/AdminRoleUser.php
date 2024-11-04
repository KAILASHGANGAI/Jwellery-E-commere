<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminRoleUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];


    //user 

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id', 'id');
    }
    // role 

    /**
     * The admin role that this user belongs to.
     */
    public function adminRole()
    {
      return $this->hasOne(AdminRole::class, 'id', 'admin_role_id');
    }
}
