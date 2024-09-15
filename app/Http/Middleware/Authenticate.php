<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Check if the request is for admin guard and redirect accordingly
        if ($request->is('myadmin') || $request->is('myadmin/*')) {
            return route('admin.login');  // Redirect to the admin login route
        }

        // Default redirection for other users (like web guard users)
        if (!$request->expectsJson()) {
            return route('login');  // Default login route for non-admin users
        }
    }
}
