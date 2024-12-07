<?php

namespace App\Http\Controllers;

use App\Models\M_DailyMaterialReport;
use App\Models\M_DailyMaterialDetailReport;
use App\Models\M_TMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyReportMaterialController extends Controller
{
    function index() {
        $filename = 'data_daily_report_material';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $resultData = M_DailyMaterialReport::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Harian Material',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function formMaterialDailyReport($id = null) {

        $filename = 'data_daily_report_material_create';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        if($id) {
            $resultData = M_DailyMaterialReport::find($id);
        } else {
            $resultData = [];
        }
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Form Laporan Harian Material',
            'auth_user' => $data,
            'dailyReport' => $resultData
        ]);

    }

    function materialOfDailyReportDetails(Request $request) {

        $result = M_DailyMaterialDetailReport::where('daily_report_id', $request->daily_report_id)->get();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Material tidak ditemukan.'], 404);
        }
    }

    function saveDailyReport(Request $request) {
        // dd($request->all());
        if($request->daily_report_id) {
            $result = M_DailyMaterialReport::find($request->daily_report_id)->update($request->except('code_material', 'qty_job', 'code_material', 'qty_material', 'value_contract', 'value_total_job', 'value_total_material') + [
                'project_name' => ucwords($request->project_name),
                'value_contract' => cleanForPriceHD($request->value_contract),
                'value_total_job' => cleanForPriceHD($request->value_total_job),
                'value_total_material' => cleanForPriceHD($request->value_total_material)
            ]);
            return redirect('/material-daily-report/');
        } else {
            $result = M_DailyMaterialReport::create($request->except('code_material', 'qty_job', 'code_material', 'qty_material', 'value_contract', 'value_total_job', 'value_total_material') + [
                'project_name' => ucwords($request->project_name),
                'value_contract' => cleanForPriceHD($request->value_contract),
                'value_total_job' => cleanForPriceHD($request->value_total_job),
                'value_total_material' => cleanForPriceHD($request->value_total_material)
            ]);
            return redirect('/form-material-daily-report/'.$result->id);
        }

    }

    function deleteDailyReport(Request $request, $id) {
        $data = M_DailyMaterialReport::find($id);

        if($data) {
            M_DailyMaterialDetailReport::where('daily_report_id', $id)->delete();
            $result = $data->delete();
            if($result) {
                $request->session()->flash('success', 'Data berhasil dihapus');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Proses gagal, Data Tidak Ditemukan');
        }

        return redirect('/material-daily-report/');
    }
}
