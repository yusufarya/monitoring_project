<?php

namespace App\Http\Controllers;

use App\Models\M_BalanceReportDetail;
use App\Models\M_MMaterial;
use App\Models\M_TMaterial;
use App\Models\M_DailyMaterialDetailReport;
use App\Models\M_MaterialPickup;
use App\Models\M_MaterialPickupDetail;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MMaterialController extends Controller
{
    function dataMaterial() {
        $filename = 'data_master_material';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $dataMaterial = M_MMaterial::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Material',
            'auth_user' => $data,
            'dataMaterial' => $dataMaterial
        ]);
    }

    function getMasterMaterial(Request $request) {
        $code = $request['code_material'];

        $result = M_MMaterial::where('code', $code)->first();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Material tidak ditemukan.'], 404);
        }
    }

    function getMaterialUsed(Request $request) {
        $code = $request['code_material'];

        $result = M_MMaterial::where('code', $code)->first();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Material tidak ditemukan.'], 404);
        }
    }

    function getMaterialBalance(Request $request) {
        $project_id = $request['project_id'];

        $result = M_MaterialPickup::where('project_id', $project_id)->first();

        if($result) {
            $getDetail = M_MaterialPickupDetail::where('material_pickup_id', $result->id)->get();
            return response()->json(['data' => $result, 'detail' => $getDetail], 200);
        } else {
            return response()->json(['message'=> 'Kode Material tidak ditemukan.'], 404);
        }
    }

    function storeJob(Request $request) {

        $validatedData = $request->validate([
            'code'      => 'required|max:20',
            'name'      => 'required|max:200',
            'unit'      => 'required|max:10',
            'price'      => 'required',
        ]);

        $validatedData['price'] = cleanForPrice($request->price);

        $result = M_MMaterial::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Material berhasil ditambahkan');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-material');

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
            $code_exist = M_MMaterial::where('id', $request['id'])->first();
        }

        $validatedData['price'] = cleanForPrice($request->price);

        if($code_exist === false) {
            $result = M_MMaterial::find($request['id'])->update($validatedData);

            if($result) {
                $request->session()->flash('success', 'Material berhasil diubah');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Kode Material sudah ada');
        }

        return redirect('/data-material');

    }

    function deleteJob(Request $request, string $id) {

        $data = M_MMaterial::find($id);

        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-material');
    }

    function saveTrMaterial(Request $request) {
        // $formMaterial = $request->all();
        $result = M_TMaterial::create($request->except('price', 'total_price') + [
            'price' => cleanForPrice($request->price),
            'total_price' => cleanForPrice($request->total_price),
        ]);
        if($result) {
            return response()->json(['message'=> 'Berhasil Menambahkan Data Material', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menambahkan data.'], 400);
        }
    }

    function deleteTrMaterial(Request $request) {
        $idTrJob = $request->id;
        $result = M_TMaterial::find($idTrJob)->delete();
        if($result) {
            return response()->json(['message'=> 'Berhasil Menghapus Data Material', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menghapus data.'], 400);
        }
    }

    function saveReportMaterial(Request $request) {
        // $formJob = $request->all();
        $result = M_DailyMaterialDetailReport::create($request->except('price', 'total_price') + [
            'price' => cleanForPrice($request->price),
            'total_price' => cleanForPrice($request->total_price),
        ]);
        if($result) {
            return response()->json(['message'=> 'Berhasil Menambahkan Data Material', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menambahkan data.'], 400);
        }
    }

    function deleteDailyReportMaterial(Request $request) {
        $idTrJob = $request->id;
        $result = M_DailyMaterialDetailReport::find($idTrJob)->delete();
        if($result) {
            return response()->json(['message'=> 'Berhasil Menghapus Data Material', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menghapus data.'], 400);
        }
    }

    function saveMaterialPickup(Request $request) {
        $formJob = $request->all();
        // dd($formJob);
        $result = M_MaterialPickupDetail::create($formJob);
        if($result) {
            return response()->json(['message'=> 'Berhasil Menambahkan Data Pengambilan Material', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menambahkan data.'], 400);
        }
    }

    function deleteMaterialPickup(Request $request) {
        $idTrJob = $request->id;
        $result = M_MaterialPickupDetail::find($idTrJob)->delete();
        if($result) {
            return response()->json(['message'=> 'Berhasil Menghapus Data Pengambilan Material', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menghapus data.'], 400);
        }
    }

    function saveMaterialBalance(Request $request) {
        $formJob = $request->all();
        $result = M_BalanceReportDetail::create($formJob);
        if($result) {
            return response()->json(['message'=> 'Berhasil Menambahkan Data Material Balance', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menambahkan data.'], 400);
        }
    }

    function deleteMaterialBalance(Request $request) {
        $idTrJob = $request->id;
        $result = M_BalanceReportDetail::find($idTrJob)->delete();
        if($result) {
            return response()->json(['message'=> 'Berhasil Menghapus Data Material Balance', 'data' => $result], 200);
        } else {
            return response()->json(['message'=> 'Gagal Menghapus data.'], 400);
        }
    }
}
