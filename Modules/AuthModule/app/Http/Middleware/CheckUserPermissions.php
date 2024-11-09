<?php

namespace Modules\AuthModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\AuthModule\Models\AdminPermission;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermissions
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        $user = \Auth::guard('admin')->user(); // get admin user
        $role = @$user->adminUserRole->adminRole; // get admin role/

        if (!$user || $user->status == 0) {
            abort(Response::HTTP_FORBIDDEN, 'Your account has been suspended or has not been verified.');
        }
        // check if user is super admin or system admin
        if ($user->is_super_admin || $user->is_system_admin) {
            return $next($request);
        }
       

        $requestController = $request->route()->getAction()['controller'];
        [$controller, $method] = explode('@', class_basename($requestController));
        $permissions = AdminPermission::query()
            ->select('id', 'controller', 'method', 'status')
            ->where([
                'controller' => $controller,
                'method' => $method,
                'status' => '1'
            ])->first();

        if (!$permissions) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to access this page.');
        }

        foreach ($role->role_permissions as $role_permission) {
            if ($role_permission->admin_permission_id == $permissions->id) {
                return $next($request);
            }
        }

        abort(Response::HTTP_FORBIDDEN, 'You do not have permission to access this page.');
        // return $next($request);
    }
}
