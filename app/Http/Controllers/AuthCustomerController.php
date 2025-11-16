<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthCustomerController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'role' => 'customer',
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('role', 'customer')
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session(['customer_id' => $user->id]);
            return redirect('/');
        }

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        session()->forget('customer_id');
        session()->flush();
        return redirect('/login')->with('success', 'Berhasil logout!');
    }

}
