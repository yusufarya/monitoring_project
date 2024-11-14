<?php

namespace App\Http\Controllers;

use App\Models\M_BalanceMaterial;
use App\Models\M_BalanceMaterialDetail;
use App\Models\M_DailyMaterialDetailReport;
use App\Models\M_DailyMaterialReport;
use App\Models\M_MaterialPickup;
use App\Models\M_MaterialPickupDetail;
use App\Models\M_Project;
use App\Models\M_TMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialBalanceController extends Controller {

    function index() {
        $filename = 'data_material_balance';
        $filename_script = getContentScript(true, $filename);
        $data = Auth::guard('web')->user();

        $resultData = M_BalanceMaterial::get();

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Material Balance',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function formMaterialBalance($id = null) {

        $filename = 'data_material_balance_create';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        if($id) {
            $resultData = M_BalanceMaterial::find($id);
        } else {
            $resultData = [];
        }
        return view('admin-page.'.$filename, [
            'title' => 'Form Material Balance',
            'auth_user' => $data,
            'script' => $filename_script,
            'balance' => $resultData
        ]);
    }

    function detailMaterialBalance(Request $request) {
        $id = $request['project_id'];

        // Get material balance data with joins
        $balanceData = DB::table('projects as p')
            ->join('material_pickups as mp', 'mp.project_id', '=', 'p.id')
            ->join('material_pickup_details as mpd', 'mpd.material_pickup_id', '=', 'mp.id')
            ->join('daily_material_reports as dmr', 'dmr.project_id', '=', 'p.id')
            ->join('daily_material_report_details as dmrd', 'dmrd.daily_report_id', '=', 'dmr.id')
            ->select(
                'mpd.*',
                'mpd.qty as pickup_qty',
                'dmrd.qty as daily_qty',
                DB::raw('CASE WHEN mpd.qty = dmrd.qty THEN "Sesuai" ELSE "Tidak Sesuai" END as status'),
                'p.*'
            )
            ->distinct()
            ->where('p.id', $id)
            ->get();

            // Add note with pickup and daily quantities
        foreach($balanceData as $data) {
            $data->note = "Diambil: {$data->pickup_qty}, Digunakan: {$data->daily_qty}";
        }

        if($balanceData) {
            return response()->json(['data' => $balanceData], 200);
        } else {
            return response()->json(['message'=> 'Kode Material tidak ditemukan.'], 404);
        }
    }

    function saveMaterialBalance(Request $request) {
        // dd($request->all());
        if($request->balance_id) {
            $request->merge(['status' => 'Closed']);
            $result = M_BalanceMaterial::find($request->balance_id)->update($request->except('balance_id'));
            // dd($result);
            return redirect('/material-balance/');
        } else {
            $request->merge(['status' => 'Pending']);
            $result = M_BalanceMaterial::create($request->except('balance_id'));
            return redirect('/form-material-balance/'.$result->id);
        }
    }

    function deleteMaterialBalance(Request $request, $id) {
        $data = M_BalanceMaterial::find($id);
        if($data) {
            M_BalanceMaterialDetail::where('balance_id', $id)->delete();
            $result = $data->delete();
            if($result) {
                $request->session()->flash('success', 'Data berhasil dihapus');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Proses gagal, Data Tidak Ditemukan');
        }

        return redirect('/data-material-balance/');
    }
}
