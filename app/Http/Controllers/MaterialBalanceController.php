<?php

namespace App\Http\Controllers;

use App\Models\M_BalanceReport;
use App\Models\M_BalanceReportDetail;
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

        $resultData = M_BalanceReport::get();

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
            $resultData = M_BalanceReport::find($id);
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
            ->join('t_materials as tm', 'tm.project_id', '=', 'p.id')
            ->leftJoin('material_pickups as mp', 'mp.project_id', '=', 'p.id')
            ->leftJoin('material_pickup_details as mpd', function($join) {
                $join->on('mpd.material_pickup_id', '=', 'mp.id')
                     ->on('mpd.code', '=', 'tm.code');
            })
            ->leftJoin('daily_material_reports as dmr', 'dmr.project_id', '=', 'p.id')
            ->leftJoin('daily_material_report_details as dmrd', function($join) {
                $join->on('dmrd.daily_report_id', '=', 'dmr.id')
                     ->on('dmrd.code', '=', 'tm.code');
            })
            ->select(
                'tm.code',
                'tm.name',
                'tm.unit',
                'tm.qty as total_qty',
                DB::raw('COALESCE(SUM(mpd.qty), 0) as pickup_qty'),
                DB::raw('COALESCE(SUM(dmrd.qty), 0) as daily_qty'),
                DB::raw('CASE
                    WHEN COALESCE(SUM(mpd.qty), 0) = COALESCE(SUM(dmrd.qty), 0) THEN "Sesuai"
                    ELSE "Tidak Sesuai"
                END as status')
            )
            ->groupBy('tm.code', 'tm.name', 'tm.unit', 'tm.qty')
            ->where('p.id', $id)
            ->get();
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
            $result = M_BalanceReport::find($request->balance_id)->update($request->except('balance_id', 'value_contract', 'value_total_job', 'value_total_material') + [
                'value_contract' => cleanForPrice($request->value_contract),
                'value_total_job' => cleanForPrice($request->value_total_job),
                'value_total_material' => cleanForPrice($request->value_total_material)
            ]);
            // dd($result);
            return redirect('/material-balance/');
        } else {
            $request->merge(['status' => 'Pending']);
            $result = M_BalanceReport::create($request->except('balance_id', 'value_contract', 'value_total_job', 'value_total_material') + [
                'value_contract' => cleanForPrice($request->value_contract),
                'value_total_job' => cleanForPrice($request->value_total_job),
                'value_total_material' => cleanForPrice($request->value_total_material)
            ]);
            return redirect('/form-material-balance/'.$result->id);
        }
    }

    function deleteMaterialBalance(Request $request, $id) {
        $data = M_BalanceReport::find($id);
        if($data) {
            M_BalanceReportDetail::where('balance_id', $id)->delete();
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
