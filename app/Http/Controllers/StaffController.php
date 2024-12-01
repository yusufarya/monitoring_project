<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    function dataStaff() {
        $filename = 'data_staff';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $dataStaff = User::with('user_level')->where('level_id', 2)->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Operator',
            'auth_user' => $data,
            'dataStaff' => $dataStaff
        ]);
    }

    function addFormStaff() {
        $filename = 'add_new_staff';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $admin = User::with('user_level')->get();
        $user_level = UserLevel::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Data Operator',
            'auth_user' => $data,
            'level_id' => $user_level
        ]);
    }

    function storeStaff(Request $request) {

        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:users',
            'gender'        => 'required',
            'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'no_telp'       => 'required|max:15',
            'email'         => 'required|max:100|email|unique:users',
            'password'      => 'required|min:6|max:255',
            'images'     => 'image|file|max:1024',
        ]);

        if($request->file('images')) {
            $validatedData['images'] = $request->file('images')->store('profile-images');
        }

        $validatedData['number'] = getLastNumberStaff();
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
            return redirect('/data-staff');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/form-add-staff');
        }

    }

    function editFormStaff($number) {
        $filename = 'edit_new_staff';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $data_staff = User::find($number);
        $user_level = UserLevel::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Edit Data Operator',
            'auth_user' => $data,
            'data_staff' => $data_staff,
            'level' => $user_level
        ]);
    }

    function updateStaff(Request $request) {
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
                return redirect('/data-staff');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
                return redirect('/form-edit-staff/'.$validatedData['number']);
            }
        } else {
            $request->session()->flash('failed', 'Username sudah ada');
            return redirect('/form-edit-staff/'.$validatedData['number']);
        }

    }

    function deleteStaff(Request $request, string $number) {

        if(auth()->guard('web')->user()->number == $number) {
            $request->session()->flash('failed', 'Proses gagal, Anda tidak dapat menghapus akun anda sendiri');
            return redirect('/data-staff');
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
        return redirect('/data-staff');
    }
}
