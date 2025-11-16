<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthAdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $admin = User::where('email', $request->email)
            ->where('role', 'admin')->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id]);
            return redirect('/admin/products');
        }

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        session()->forget('admin_id');
        session()->flush();
        return redirect('/admin/login')->with('success', 'Berhasil logout!');
    }

}
