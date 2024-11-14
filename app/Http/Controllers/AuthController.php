<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function index() {
        return view('admin-page.auth.login_admin', [
            'title' => 'Login User'
        ]);
    }

    public function auth(Request $request) {

        $credentials = $request->validate([
            'email'  => 'required',
            'password'  => 'required'
        ]);
        // dd($credentials);
        $resultUser = User::where('email', $credentials['email'])->count();

        if(!$resultUser) {
            $request->session()->flash('failed', 'Akun tidak terdaftar.');
            return redirect('/login-admin');
        }

        if (auth('web')->attempt($credentials)) {

            $isActive = Auth::guard('web')->user()->is_active == "Y";
            if ($isActive == true) {
                return redirect()->intended('/dashboard');
            } else {
                Auth::guard('web')->logout();
                $request->session()->flash('failed', 'Akun belum aktif, Hubungi administrator.');
                return redirect('/login-admin');
            }
        }

        return back()->with('failed', 'Username atau Password salah!');
    }

    function register() {
        return view('admin-page/auth/register_admin', [
            'title' => 'Register User'
        ]);
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:admins',
            'gender'        => 'required',
            'no_telp'       => 'required',
            'email'         => 'required|email|unique:admins',
            'password'      => 'required|confirmed|min:6|max:255',
            'password_confirmation' => 'required|min:6|max:255'
        ]);

        $validatedData['number'] = $this->getLastNumber();
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = $validatedData['username'];
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['level_id'] = 1;
        // dd($validatedData);
        $result = User::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/login-admin');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
            return redirect('/register-admin');
        }
    }

    function logout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->flash('success', 'Anda berhasil logout');
        return redirect('/login-admin');
    }

    function getLastNumber() {

        $lastNumber = User::max('number');

        if($lastNumber) {
            $lastNumber = substr($lastNumber, -4);
            $code_ = sprintf('%04d', $lastNumber+1);
            $numberFix = "ADM".date('Ymd').$code_;
        } else {
            $numberFix = "ADM".date('Ymd')."0001";
        }

        return $numberFix;
    }
}
