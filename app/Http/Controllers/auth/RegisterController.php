<?php

namespace App\Http\Controllers\auth;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the user
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'ip_address' => request()->ip(),
            'password' => Hash::make($request->password),
        ]);

        // Login the user
        auth()->attempt($request->only('email', 'password'));

        // Redirect after successful registration
        return redirect()->route('home');
    }
}
