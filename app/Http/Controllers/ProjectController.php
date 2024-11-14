<?php

namespace App\Http\Controllers;

use App\Models\M_Project;
use App\Models\M_TJob;
use App\Models\M_TMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    function index() {
        $filename = 'data_project';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $resultData = M_Project::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Daftar Proyek',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function form_project($id = null) {

        $filename = 'data_project_create';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        if($id) {
            $resultData = M_Project::find($id);
        } else {
            $resultData = [];
        }
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Form Data Proyek',
            'auth_user' => $data,
            'project' => $resultData
        ]);

    }

    function getProjectBySPK(Request $request) {

        $result = M_Project::where('spk_number', $request->spk_number)->first();
        if($result) {
            $result['value_total_job'] = M_TJob::where('project_id', $result->id)->sum('total_price');
            $result['value_total_material'] = M_TMaterial::where('project_id', $result->id)->sum('total_price');
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Proyek tidak ditemukan.'], 404);
        }
    }

    function getProjectById(Request $request) {

        $result = M_Project::find($request->project_id);
        if($result) {
            $result['value_total_job'] = M_TJob::where('project_id', $result->id)->sum('total_price');
            $result['value_total_material'] = M_TMaterial::where('project_id', $result->id)->sum('total_price');
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Proyek tidak ditemukan.'], 404);
        }
    }

    function jobOfProject(Request $request) {

        $result = M_TJob::where('project_id', $request->project_id)->get();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Pekerjaan tidak ditemukan.'], 404);
        }
    }

    function materialOfProject(Request $request) {

        $result = M_TMaterial::where('project_id', $request->project_id)->get();

        if($result) {
            return response()->json($result, 200);
        } else {
            return response()->json(['message'=> 'Kode Pekerjaan tidak ditemukan.'], 404);
        }
    }

    function saveProject(Request $request) {
        if($request->project_id) {
            $result = M_Project::find($request->project_id)->update($request->except('code_job', 'qty_job', 'code_material', 'qty_material') + [
                'supervisor_name' => ucwords($request->supervisor_name),
                'project_name' => ucwords($request->project_name),
            ]);
            return redirect('/project-list/');
        } else {
            $result = M_Project::create($request->except('code_job', 'qty_job', 'code_material', 'qty_material') + [
                'supervisor_name' => ucwords($request->supervisor_name),
                'project_name' => ucwords($request->project_name),
            ]);
            return redirect('/form-project/'.$result->id);
        }

    }

    function deleteProject(Request $request, $id) {
        $data = M_Project::find($id);

        if($data) {
            M_TJob::where('project_id', $id)->delete();
            M_TMaterial::where('project_id', $id)->delete();
            $result = $data->delete();
            if($result) {
                $request->session()->flash('success', 'Data berhasil dihapus');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            }
        } else {
            $request->session()->flash('failed', 'Proses gagal, Data Tidak Ditemukan');
        }

        return redirect('/project-list/');
    }
}
