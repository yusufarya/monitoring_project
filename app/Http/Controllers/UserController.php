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

    function getDetailUser(Request $request) {
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

    function storeUser(Request $request) {
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

    function editFormUser($number) {
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

    function updateUser(Request $request) {
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

    function deleteUser(Request $request, string $number) {

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

    function registrantData() {
        $filename = 'data_participant';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $dataParticipants = Participant::get();
        return view('admin-page.'.$filename, [
            'candidate' => '',
            'script' => $filename_script,
            'title' => 'Data Pendaftar Akun',
            'auth_user' => $data,
            'dataParticipants' => $dataParticipants
        ]);
    }

    function deleteRegistrant(Request $request, string $number) {
        $checkDataExist = Registrant::where("participant_number", $number)->count();
        if($checkDataExist > 0) {
            $request->session()->flash('message', 'Akun tidak dapat dihapus, karna telah mengikuti pelatihan');
            return redirect('/registrant-data');
        }
        $data = Participant::find($number);
        // dd($data);
        if($data->id_card) {
            Storage::delete($data->id_card);
        }
        if($data->ak1) {
            Storage::delete($data->ak1);
        }
        if($data->ijazah) {
            Storage::delete($data->ijazah);
        }
        if($data->image) {
            Storage::delete($data->image);
        }
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/registrant-data');
    }

    function candidateData() {
        $filename = 'data_participant';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $dataParticipants = Participant::with('sub_districts')->where('participant', 'Y')->get();
        return view('admin-page.'.$filename, [
            'candidate' => 'Y',
            'script' => $filename_script,
            'title' => 'Data Calon Peserta',
            'auth_user' => $data,
            'dataParticipants' => $dataParticipants
        ]);
    }

    // DETAIL CALON PESERTA
    function detailParticipant(string $number, $pageCandidate = '') {
        $filename = 'detail_participant';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $participant = new Participant;
        $data_part = $participant->getUserProfileByNumber($number);
        // dd($participant);
        return view('admin-page.'.$filename, [
            'candidate' => $pageCandidate,
            'script' => $filename_script,
            'title' => 'Detail Peserta',
            'auth_user' => $data,
            'detailParticipant' => $data_part
        ]);
    }

    function resetPassword(Request $request, string $number) {

        $password = Hash::make($request->password);

        $result = Participant::where('number', $number)->update(['password'=>$password]);

        if($result) {
            $request->session()->flash('success', 'Password baru berhasil disimpan');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/detail-participant/'.$number);
    }

    function registrant(Request $request) {
        $filename = 'registrant';
        $filename_script = getContentScript(true, $filename);

        $status_approve = $request->status ? $request->status : NULL;

        $data = Auth::guard('web')->user();
        $registrant = new Registrant;
        $result = $registrant->getRegistrants($status_approve,$request->fullname);
        // dd($result);
        return view('admin-page.'.$filename, [
            'status' => $status_approve,
            'search_name' => $request->fullname,
            'script' => $filename_script,
            'title' => 'Data Pendaftar Pelatihan',
            'auth_user' => $data,
            'participant' => $result
        ]);
    }

    function participantPassed(Request $request) {
        $filename = 'participant_passed';
        $filename_script = getContentScript(true, $filename);

        $status_passed = $request->passed ? $request->passed : "X";

        $data = Auth::guard('web')->user();
        $registrant = new Registrant;
        $result = $registrant->getParticipantPassed($status_passed, $request->fullname);
        // dd($result);
        return view('admin-page.'.$filename, [
            'passed' => $status_passed,
            'search_name' => $request->fullname,
            'script' => $filename_script,
            'title' => 'Data Kelulusan Pelatihan',
            'auth_user' => $data,
            'participant' => $result
        ]);
    }

    function approveParticipant(Request $request, $number) {

        $data = Auth::guard('web')->user();

        $dataUpdate = [
            'approval_on' => date('Y-m-d H:i:s'),
            'approval_by' => $data->username,
            'approve' => 'Y',
        ];

        Registrant::where(['participant_number'=> $number, 'training_id' => $request->training_id])->update($dataUpdate);

        return redirect('registrant');
    }

    function declineParticipant(Request $request, $number) {
        // dd($request);
        $dataUpdate = [
            'approve' => 'N',
        ];
        Registrant::where(['participant_number'=> $number, 'training_id' => $request->training_id])->update($dataUpdate);
        return redirect('registrant');
    }

    function updateStatusPassed(Request $request) {
        $data = Auth::guard('web')->user();

        $selectedId = explode(',', $request->selectedId);
        foreach ($selectedId as $value) {

            $dataUpdate = [
                'approval_on' => date('Y-m-d H:i:s'),
                'approval_by' => $data->username,
                'passed' =>  $request->status_passed,
            ];

            Registrant::where(['id'=> $value])->update($dataUpdate);
        }

        return response()->json(['status' => 'success']);
    }


    // DETAIL PESERTA PELATIHAN YANG TELAH DI APPROVE
    function detailParticipantAppr(string $number, int $training_id) {
        // dd($training_id);
        $filename = 'detail_participant_appr';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        // $participant = new Participant;
        // $data_part = $participant->getUserProfileByNumber($number);
        $resultData = Registrant::with('participants', 'periods', 'service.service_detail', 'service.periods')
                                ->where(['participant_number'=> $number, 'training_id' => $training_id])->first();
        // dd($resultData);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Detail Peserta Pelatihan',
            'auth_user' => $data,
            // 'detailParticipant' => $data_part,
            'resultData' => $resultData
        ]);
    }

    function passedParticipant(Request $request, $number) {

        $data = Auth::guard('web')->user();
        // dd($request->training_id);
        $dataUpdate = [
            'passed_on' => date('Y-m-d H:i:s'),
            'passed' => $request->passed,
        ];

        Registrant::where(['participant_number'=> $number, 'training_id' => $request->training_id])->update($dataUpdate);

        return redirect('registrant');
    }

    function participantAlreadyWorking(Request $request) {
        $filename = 'participant_already_working';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();

        $filter = $request->sub_district ? $request->sub_district : NULL;
        if($request->fullname) {
            if($request->session()->get('fullname') != $request->fullname) {
                session()->forget('fullname');
            }
            $request->session()->push('fullname', $request->fullname);
        } else {
            session()->forget('fullname');
        }
        if($request->sub_district) {
            if($request->session()->get('sub_district') != $request->sub_district) {
                session()->forget('sub_district');
            }
            $request->session()->push('sub_district', $request->sub_district);
        } else {
            session()->forget('sub_district');
        }
        $modelParticipantWorlk = new ParticipantWork;
        $resultData = $modelParticipantWorlk->dataPartisipantWork($filter, $request->fullname);
        //  dd($resultData);
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'filter' => $filter,
            'sub_district_data' => SubDistrict::get(),
            'search_name' => $request->fullname,
            'title' => 'Daftar Peserta Sudah Bekerja',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function getDetailParticipant(Request $request) {
        $participant_number = $request->number;
        $result = Participant::with('sub_districts')->find($participant_number);

        $where = [
            'participant_number' => $participant_number,
            'passed' => 'Y'
        ];
        $getLatestTraining = Registrant::with('service')->where($where)->orderBy('id', 'DESC')->limit('1')->first();
        // dd($getLatestTraining);
        if($getLatestTraining) {
            if($result) {
                return response()->json(['status' => 'success', 'data' => $result, 'training_name' => $getLatestTraining->service->title]);
            } else {
                return response()->json(['status' => 'failed']);
            }
        } else {
            return response()->json(['status' => 'warning', 'message' => "Peserta belum lulus mengikuti pelatihan"]);
        }
    }

    function addParticipantWork() {
        $filename = 'add_participant_already_working';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();

        $getParticipant = Registrant::with('participants')->where('passed', 'Y')->get();

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Peserta Sudah Bekerja',
            'auth_user' => $data,
            // 'detailParticipant' => $data_part,
            'participantData' => $getParticipant
        ]);
    }

    function storeParticipantWord(Request $request) {

        $validatedData = $request->validate([
            'participant_number' => 'required|unique:participant_works',
            'date_year' => 'required|max:10',
            'company_name' => 'required|max:100',
            'position' => 'required|max:50',
        ]);

        $validatedData['date_year'] = date('m-Y', strtotime($request->date_year));
        // dd($validatedData);
        $result = ParticipantWork::create($validatedData);

        if($result) {
            return redirect('/participant-already-working');
        } else {
            die('Proses gagal, Hubungi administrator');
        }

    }

    function editParticipantWork(Request $request, string $number) {
        $filename = 'edit_participant_already_working';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $resultData = ParticipantWork::where('participant_number', $number)->first();

        $getParticipant = Registrant::with('participants')->where('passed', 'Y')->get();

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Peserta Sudah Bekerja',
            'auth_user' => $data,
            'resultData' => $resultData,
            'participantData' => $getParticipant
        ]);
    }

    function updateParticipantWork(Request $request, string $number) {

        $validatedData = $request->validate([
            'date_year' => 'required|max:10',
            'company_name' => 'required|max:100',
            'position' => 'required|max:50',
        ]);

        $validatedData['date_year'] = date('m-Y', strtotime($request->date_year));
        // dd($validatedData);
        $result = ParticipantWork::where('participant_number', $number)->update($validatedData);

        return redirect('/participant-already-working');

    }

    function deleteParticipantWork(Request $request, string $number) {

        $data = ParticipantWork::where(['participant_number' => $number ]);
        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/participant-already-working');
    }

}
