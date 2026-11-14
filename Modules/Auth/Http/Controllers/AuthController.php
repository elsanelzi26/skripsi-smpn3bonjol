<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('auth::login');
    }

    public function proseslogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            Alert::success('Sukses', 'Selamat Anda Berhasil Login');
            return redirect()->route('dashboard')->with('success', 'Selamat Anda Berhasil Login');
        }
        return redirect()->route('login')->with('message', 'Gagal!! Username atau Password Salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Alert::success('Sukses', 'Selamat Anda Berhasil Logout');
        return redirect()->route('login');
    }
}
