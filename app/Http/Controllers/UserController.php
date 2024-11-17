<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use App\Models\ParticipantWork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    function index() {
        $number = Auth::guard('web')->user()->number;
        $data = User::with('user_level')->find($number)->first();
        return view('admin-page.profile', [
            'title' => 'Profile',
            'auth_user' => $data
        ]);
    }

    function dataUser() {
        $filename = 'data_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $admin = User::with('user_level')->where('level_id', 3)->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data User',
            'auth_user' => $data,
            'dataUser' => $admin
        ]);
    }

    function getDetailAdmin(Request $request) {
        $number = $request->number;
        $data = User::with('user_level')->find($number)->first();

        $data->address = $data->address ? $data->address : " - ";
        $data->place_of_birth = $data->place_of_birth ? $data->place_of_birth : " - ";
        $data->date_of_birth = $data->date_of_birth ? date('d-m-Y', strtotime($data->date_of_birth)) : " - - -";
        $data->created_at = date('d-m-Y', strtotime($data->created_at));
        $data->gender = $data->gender == "M" ? "Laki-laki" : "Perempuan";
        $data->level = $data->user_level->name;
        echo json_encode($data);
    }

    function addFormUser() {
        $filename = 'add_new_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $admin = User::with('user_level')->get();
        $user_level = UserLevel::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Data User',
            'auth_user' => $data,
            'level_id' => $user_level
        ]);
    }

    function storeAdmin(Request $request) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:admins',
            'gender'        => 'required',
            'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'no_telp'       => 'required|max:15',
            'email'         => 'required|max:100|email|unique:admins',
            'password'      => 'required|min:6|max:255',
            'images'     => 'image|file|max:1024',
        ]);

        if($request->file('images')) {
            $validatedData['images'] = $request->file('images')->store('profile-images');
        }

        $validatedData['number'] = getLastNumberUser();
        $validatedData['address'] = $request['address'];
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('web')->user()->username;
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['level_id'] = $validatedData['level_id'];
        $validatedData['is_active'] = $request['is_active'] ? "Y" : "N";
        // dd($validatedData);
        $result = User::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/data-admin');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/form-add-admin');
        }

    }

    function editFormAdmin($number) {
        $filename = 'edit_new_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $data_admin = User::find($number);
        $user_level = UserLevel::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Edit Data User',
            'auth_user' => $data,
            'data_admin' => $data_admin,
            'level' => $user_level
        ]);
    }

    function updateAdmin(Request $request) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30',
            'gender'        => 'required',
            'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'no_telp'       => 'required|max:15',
            'images'     => 'image|file|max:1024',
        ]);

        $username_exist = false;
        if($request['username1'] != $request['username']) {
            $username_exist = User::where('username', $request['username'])->first();
        }

        if($request->file('images')) {
            $validatedData['images'] = $request->file('images')->store('profile-images');
        }

        $validatedData['number'] = $request['number'];
        $validatedData['address'] = $request['address'];
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_by'] = Auth::guard('web')->user()->username;
        if($request['password']) {
            $validatedData['password'] = Hash::make($request['password']);
        }
        $validatedData['level_id'] = $validatedData['level_id'];
        $validatedData['is_active'] = $request['is_active'] ? "Y" : "N";

        if($username_exist === false) {
            $result = User::where(['number' => $validatedData['number']])->update($validatedData);

            if($result) {
                $request->session()->flash('success', 'Akun berhasil dibuat');
                return redirect('/data-admin');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
                return redirect('/form-edit-admin/'.$validatedData['number']);
            }
        } else {
            $request->session()->flash('failed', 'Username sudah ada');
            return redirect('/form-edit-admin/'.$validatedData['number']);
        }

    }

    function deleteAdmin(Request $request, string $number) {

        if(auth()->guard('web')->user()->number == $number) {
            $request->session()->flash('failed', 'Proses gagal, Anda tidak dapat menghapus akun anda sendiri');
            return redirect('/data-admin');
        }
        $data = User::find($number);

        if($data->image) {
            Storage::delete($data->image);
        }

        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-admin');
    }

}
