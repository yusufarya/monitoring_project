<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\M_Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Dashboard extends Controller
{

    public function __construct(protected User $admin) {
        $user = Auth::guard('web')->user();
    }

    function index() {

        $countRegistrant = User::count();

        $projectData = M_Project::where('date', date('Y-m-d'))->get();

        $todayProject = DB::table('projects as h')
                        ->leftJoin('t_jobs as dj', 'dj.project_id', '=', 'h.id')
                        ->leftJoin('t_materials as dm', 'dm.project_id', '=', 'h.id')
                        ->select(DB::raw('COALESCE(SUM(dj.qty), 0) as total_qty_j'), DB::raw('COALESCE(SUM(dm.qty), 0) as total_qty_m'))
                        ->where('date', date('Y-m-d'))
                        ->get();

        $todayJobDone = DB::table('daily_job_reports as h')
                        ->leftJoin('daily_job_report_details as d', 'd.daily_report_id', '=', 'h.id')
                        ->select(DB::raw('COALESCE(SUM(d.qty), 0) as total_qty'))
                        ->where('date', date('Y-m-d'))
                        ->get();

        $todayMaterialDone = DB::table('daily_material_reports as h')
                        ->leftJoin('daily_material_report_details as d', 'd.daily_report_id', '=', 'h.id')
                        ->select(DB::raw('COALESCE(SUM(d.qty), 0) as total_qty'))
                        ->where('date', date('Y-m-d'))
                        ->get();

        $cur_route = Route::current()->uri();
        $data = Auth::guard('web')->user();
        return view('admin-page.dashboard', [
            'title' => 'Dashboard',
            'cur_page' => $cur_route,
            'auth_user' => $data,
            'todayJob' => $todayProject[0]->total_qty_j,
            'todayMaterial' => $todayProject[0]->total_qty_m,
            'todayJobDone' => $todayJobDone[0]->total_qty,
            'todayMaterialDone' => $todayMaterialDone[0]->total_qty,
            'projectData' => $projectData,
        ]);
    }
}
