<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\M_Project;
use App\Models\M_DailyJobReport;
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

        $projectData = M_Project::orderBy('id', 'DESC')->get();

        // Extract only the 'spk_number' values from the collection
        $spkNumbers = $projectData->pluck('spk_number')->toArray();

        // Use the extracted spk_numbers in the whereIn query
        $projectDataRunning = M_DailyJobReport::whereIn('spk_number', $spkNumbers)->get();
        // Use the extracted spk_numbers in the whereIn query
        $projectDataDone = M_DailyJobReport::whereIn('spk_number', $spkNumbers)->get();

        $balancedProjects = DB::table('projects as p')
                    // Join for Jobs
                    ->leftJoin('t_jobs as tj', 'tj.project_id', '=', 'p.id')
                    ->leftJoin('daily_job_reports as djr', 'djr.spk_number', '=', 'p.spk_number')
                    ->leftJoin('daily_job_report_details as djrd', function($join) {
                        $join->on('djrd.daily_report_id', '=', 'djr.id');
                            // ->on('djrd.code', '=', 'tj.code');
                    })
                    // Join for Materials
                    ->leftJoin('t_materials as tm', 'tm.project_id', '=', 'p.id')
                    ->leftJoin('material_pickups as mp', 'mp.project_id', '=', 'p.id')
                    ->leftJoin('material_pickup_details as mpd', function($join) {
                        $join->on('mpd.material_pickup_id', '=', 'mp.id');
                            // ->on('mpd.code', '=', 'tm.code');
                    })
                    ->leftJoin('daily_material_reports as dmr', 'dmr.project_id', '=', 'p.id')
                    ->leftJoin('daily_material_report_details as dmrd', function($join) {
                        $join->on('dmrd.daily_report_id', '=', 'dmr.id');
                            // ->on('dmrd.code', '=', 'tm.code');
                    })
                    ->select(
                        'p.id as project_id',
                        'p.project_name as project_name',
                        DB::raw('COALESCE(SUM(tj.qty), 0) as total_job_qty'),
                        DB::raw('COALESCE(SUM(djrd.qty), 0) as total_job_report_qty'),
                        DB::raw('COALESCE(SUM(mpd.qty), 0) as total_material_pickup_qty'),
                        DB::raw('COALESCE(SUM(dmrd.qty), 0) as total_material_report_qty')
                    )
                    ->groupBy('p.id', 'p.project_name')
                    ->havingRaw('
                        COALESCE(SUM(mpd.qty), 0) = COALESCE(SUM(dmrd.qty), 0)
                    ')
                    ->get();
        // die($balancedProjects);
        $cur_route = Route::current()->uri();
        $data = Auth::guard('web')->user();
        return view('admin-page.dashboard', [
            'title' => 'Dashboard',
            'cur_page' => $cur_route,
            'auth_user' => $data,
            'projectData' => $projectData,
            'projectDataRunning' => $projectDataRunning,
            'balancedProjects' => $balancedProjects,
        ]);
    }
}
