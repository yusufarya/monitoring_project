<?php

namespace App\Http\Controllers;

use App\Models\M_DailyJobReport;
use App\Models\M_DailyJobDetailReport;
use App\Models\M_TMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyReportJobController extends Controller
{
    function index() {
        $filename = 'data_daily_report_job';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $resultData = M_DailyJobReport::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Harian Pekerjaan',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function formJobDailyReport($id = null) {

        $filename = 'data_daily_report_job_create';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        if($id) {
            $resultData = M_DailyJobReport::find($id);
        } else {
            $resultData = [];
        }
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Form Laporan Harian Pekerjaan',
            'auth_user' => $data,
            'dailyReport' => $resultData
        ]);

    }

    function jobOfDailyReportDetails(Request $request) {

        $result = M_DailyJobDetailReport::where('daily_report_id', $request->daily_report_id)->get();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Pekerjaan tidak ditemukan.'], 404);
        }
    }

    function saveDailyReport(Request $request) {
        // dd($request->all());
        cleanForPriceHD($request->value_total_job);
        if($request->daily_report_id) {
            $result = M_DailyJobReport::find($request->daily_report_id)->update($request->except('code_job', 'qty_job', 'code_material', 'qty_material', 'value_contract', 'value_total_job', 'value_total_material') + [
                'project_name' => ucwords($request->project_name),
                'value_contract' => cleanForPriceHD($request->value_contract),
                'value_total_job' => cleanForPriceHD($request->value_total_job),
                'value_total_material' => cleanForPriceHD($request->value_total_material)
            ]);
            return redirect('/job-daily-report/');
        } else {
            $result = M_DailyJobReport::create($request->except('code_job', 'qty_job', 'code_material', 'qty_material', 'value_contract', 'value_total_job', 'value_total_material') + [
                'project_name' => ucwords($request->project_name),
                'value_contract' => cleanForPriceHD($request->value_contract),
                'value_total_job' => cleanForPriceHD($request->value_total_job),
                'value_total_material' => cleanForPriceHD($request->value_total_material)
            ]);
            return redirect('/form-job-daily-report/'.$result->id);
        }

    }

    function deleteDailyReport(Request $request, $id) {
        $data = M_DailyJobReport::find($id);

        if($data) {
            M_DailyJobDetailReport::where('daily_report_id', $id)->delete();
            $result = $data->delete();
            if($result) {
                $request->session()->flash('success', 'Data berhasil dihapus');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Proses gagal, Data Tidak Ditemukan');
        }

        return redirect('/job-daily-report/');
    }
}
