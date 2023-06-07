<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }
    public function authentication(Request $request)
    {
        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if ($auth) {
            $request->session()->regenerate();
            return redirect()
                ->route('dashboard')
                ->with('success', 'Anda berhasil login!');
        } else {
            return redirect()
                ->back()
                ->with('errors', 'Anda gagal login');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();
        return redirect('/')->with('success','Anda berhasil logout');
    }
}
