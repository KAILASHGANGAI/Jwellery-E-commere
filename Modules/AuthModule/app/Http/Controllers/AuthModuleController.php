<?php

namespace Modules\AuthModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthModuleController extends Controller
{
    public function showLoginForm()
    {
        // Render the login view
        return view('authmodule::Auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        try {
            // Validate the form data
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            // Attempt to log the user in
            if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                // Redirect to the admin dashboard
                return redirect()->intended(route('admin.dashboard'));
            }
            // If unsuccessful, redirect back with an error message
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        } catch (Exception $th) {
            dd($th->getMessage());
           return back()->with('error', 'Something went wrong')->withInput($request->all());
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
