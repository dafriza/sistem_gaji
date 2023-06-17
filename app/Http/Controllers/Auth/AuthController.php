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
            if(Auth::user()->hasPermissionTo('PT_SMK')){
                $request->session()->regenerate();
                $request->session()->put('pt', 'PT Sekawan Mitra Kreasi');
            }else if(Auth::user()->hasPermissionTo('PT_SMK')){
                $request->session()->regenerate();
                $request->session()->put('pt', 'PT Avatar Express Indonesia');
            }else{
                $request->session()->regenerate();
                $request->session()->put('pt', 'PT Sekawan Group');
            }
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
