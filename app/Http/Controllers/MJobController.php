<?php

namespace App\Http\Controllers;

use App\Models\M_MJob;
use App\Models\M_TJob;
use App\Models\M_DailyJobDetailReport;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MJobController extends Controller
{
    function dataJob() {
        $filename = 'data_master_job';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $dataJob = M_MJob::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pekerjaan',
            'auth_user' => $data,
            'dataJob' => $dataJob
        ]);
    }

    function getMasterJob(Request $request) {
        $code = $request['code_job'];

        $result = M_MJob::where('code', $code)->first();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Pekerjaan tidak ditemukan.'], 404);
        }
    }

    function storeJob(Request $request) {

        $validatedData = $request->validate([
            'code'      => 'required|max:20',
            'name'      => 'required|max:200',
            'unit'      => 'required|max:10',
            'price'      => 'required',
        ]);

        $validatedData['price'] = cleanForPriceHD($request->price);

        $result = M_MJob::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Pekerjaan berhasil ditambahkan');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-job');

    }

    function updateJob(Request $request) {
        // dd($request);

        $validatedData = $request->validate([
            'code'      => 'required|max:20',
            'name'      => 'required|max:200',
            'unit'      => 'required|max:10',
            'price'      => 'required',
        ]);

        $code_exist = false;
        if($request['code1'] != $request['code']) {
            $code_exist = M_MJob::where('id', $request['id'])->first();
        }

        $validatedData['price'] = cleanForPriceHD($request->price);

        if($code_exist === false) {
            $result = M_MJob::find($request['id'])->update($validatedData);

            if($result) {
                $request->session()->flash('success', 'Pekerjaan berhasil diubah');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Kode Pekerjaan sudah ada');
        }

        return redirect('/data-job');

    }

    function deleteJob(Request $request, string $id) {

        $data = M_MJob::find($id);

        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-job');
    }

    function saveTrJob(Request $request) {
        // $formJob = $request->all();
        $result = M_TJob::create($request->except('price', 'total_price') + [
            'price' => cleanForPrice($request->price),
            'total_price' => cleanForPrice($request->total_price),
        ]);
        if($result) {
            return response()->json(['message'=> 'Berhasil Menambahkan Data Pekerjaan', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menambahkan data.'], 400);
        }
    }

    function deleteTrJob(Request $request) {
        $idTrJob = $request->id;
        $result = M_TJob::find($idTrJob)->delete();
        if($result) {
            return response()->json(['message'=> 'Berhasil Menghapus Data Pekerjaan', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menghapus data.'], 400);
        }
    }

    function saveReportJob(Request $request) {
        // $formJob = $request->all();
        $result = M_DailyJobDetailReport::create($request->except('price', 'total_price') + [
            'price' => cleanForPrice($request->price),
            'total_price' => cleanForPrice($request->total_price),
        ]);
        if($result) {
            return response()->json(['message'=> 'Berhasil Menambahkan Data Pekerjaan', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menambahkan data.'], 400);
        }
    }

    function deleteDailyReportJob(Request $request) {
        $idTrJob = $request->id;
        $result = M_DailyJobDetailReport::find($idTrJob)->delete();
        if($result) {
            return response()->json(['message'=> 'Berhasil Menghapus Data Pekerjaan', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menghapus data.'], 400);
        }
    }
}
