<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.home');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate(['username' => 'required|string', 'password' => 'required|string']);

        $admin = Admin::where('username', $cred['username'])->first();

        if (!$admin || !Hash::check($cred['password'], $admin->password)) {
            return back()->withInput($request->only('username'))->with('error', 'Username atau password salah.');
        }

        $request->session()->regenerate();
        session(['admin_id' => $admin->id_admin, 'admin_nama' => $admin->nama]);

        return redirect()->route('admin.home');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_nama']);
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Anda sudah keluar.');
    }
}
