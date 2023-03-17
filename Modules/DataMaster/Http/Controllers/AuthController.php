<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Contracts\Support\Renderable;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('datamaster::pages.auth.login');
    }

    public function proseslogin(Request $request)
    { 
        // dd($request->all());
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        if (Auth::attempt($request->only('username', 'password'))) {
            Alert::success('Sukses','Selamat Anda Berhasil Login');
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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('datamaster::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('datamaster::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('datamaster::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
