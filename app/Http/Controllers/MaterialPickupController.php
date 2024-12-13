<?php

namespace App\Http\Controllers;

use App\Models\M_MaterialPickup;
use App\Models\M_MaterialPickupDetail;
use App\Models\M_Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialPickupController extends Controller
{
    function index() {
        $filename = 'data_material_pickup';
        $filename_script = getContentScript(true, $filename);
        $data = Auth::guard('web')->user();

        $resultData = M_MaterialPickup::all();

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pengambilan Material',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function formMaterialPickup($id = null) {
        $filename = 'data_material_pickup_create';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $resultData = M_MaterialPickup::find($id);
        $projectData = M_Project::get();

        if($id) {
            $resultData = M_MaterialPickup::find($id);
        } else {
            $resultData = [];
        }

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Form Pengambilan Material',
            'auth_user' => $data,
            'material_pickup' => $resultData,
            'projectData' => $projectData
        ]);
    }

    function saveMaterialPickup(Request $request) {
        // dd($request->all());
        if($request->material_pickup_id) {
            $result = M_MaterialPickup::find($request->material_pickup_id)->update($request->except('material_pickup_id', 'value_contract', 'value_total_job', 'value_total_material') + [
                'value_contract' => cleanForPriceHD($request->value_contract),
                'value_total_job' => cleanForPriceHD($request->value_total_job),
                'value_total_material' => cleanForPriceHD($request->value_total_material)
            ]);
            return redirect('/material-pickup/');
        } else {
            $result = M_MaterialPickup::create($request->except('material_pickup_id', 'value_contract', 'value_total_job', 'value_total_material') + [
                'value_contract' => cleanForPriceHD($request->value_contract),
                'value_total_job' => cleanForPriceHD($request->value_total_job),
                'value_total_material' => cleanForPriceHD($request->value_total_material)
            ]);
            return redirect('/form-material-pickup/'.$result->id);
        }
    }

    function materialPickupDetails(Request $request) {
        $result = M_MaterialPickupDetail::where('material_pickup_id', $request->material_pickup_id)->get();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Data tidak ditemukan.'], 404);
        }
    }

    function deleteMaterialPickup(Request $request, $id) {

        $data = M_MaterialPickup::find($id);
        if($data) {
            M_MaterialPickupDetail::where('material_pickup_id', $id)->delete();
            $result = $data->delete();
            if($result) {
                $request->session()->flash('success', 'Data berhasil dihapus');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Proses gagal, Data Tidak Ditemukan');
        }

        return redirect('/material-pickup/');
    }
}
