<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin_login');
    }

    public function dashboard()
    {
        return view('admin.index');
    }
    public function login(Request $request)
    {
        
        $data = $request->all();

        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return redirect()->route('admin.dashboard')->with('error','Berhasil Login');
        } else {
            return redirect()->back()->with('error', 'Email atau Password salah');
        }
        


        
    }
}
