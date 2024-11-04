<?php

namespace Modules\AuthModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'admin_users';


    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'status',
        'is_super_admin',
        'is_system_admin',
        'email_verified_at',
        'password',
        'last_login',
        'last_logout',
        'ip_address',
        'user_agent',
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
        'is_super_admin' => 'boolean',
        'is_system_admin' => 'boolean',
    ];

    // Additional methods related to AdminUser can be added here

    /**
     * Log the last login time for the admin user.
     */
    public function logLastLogin()
    {
        $this->last_login = now();
        $this->ip_address = request()->ip();
        $this->user_agent = request()->userAgent();
        $this->save();
    }

    /**
     * Log the last logout time for the admin user.
     */
    public function logLastLogout()
    {
        $this->last_logout = now();
        $this->save();
    }

    //attach roles


    public function adminUserRole()
    {
        return $this->hasOne(AdminRoleUser::class, 'admin_user_id', 'id');
    }

    // has permission 
    public function hasPermission(string $permission): bool
    {
        // Assuming 'permissions' is a JSON column with an array of permissions
        return in_array($permission, $this->permissions ?? []);
    }
}
