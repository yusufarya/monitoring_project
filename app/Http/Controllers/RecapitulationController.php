<?php

namespace App\Http\Controllers;

use App\Models\M_TJob;
use App\Models\M_Project;
use App\Models\M_TMaterial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecapitulationController extends Controller
{
    function index() {
        $filename = 'recapitulation';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('web')->user();
        $projectData = M_Project::get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Rekapitulasi Data',
            'auth_user' => $data,
            'projectData' => $projectData
        ]);
    }

    function openRecapitulation(Request $request) {
        if($request->type) {
            if($request->session()->get('type') != $request->type) {
                session()->forget('type');
            }
            $request->session()->push('type', $request->type);
        } else {
            session()->forget('type');
        }
        if($request->spk_number) {
            if($request->session()->get('spk_number') != $request->spk_number) {
                session()->forget('spk_number');
            }
            $request->session()->push('spk_number', $request->spk_number);
        } else {
            session()->forget('spk_number');
        }
        if($request->date) {
            if($request->session()->get('date') != $request->date) {
                session()->forget('date');
            }
            $request->session()->push('date', $request->date);
        } else {
            session()->forget('date');
        }
        echo json_encode('{}');
    }

    function generateJobRpt(Request $request) {
        $spk_number = '';
        $date = '';
        $type = '';
        if($request->session()->get('type')) {
            $type = (string)$request->session()->get('type')[0];
        }
        if($request->session()->get('spk_number')) {
            $spk_number = (string)$request->session()->get('spk_number')[0];
        }
        if($request->session()->get('date')) {
            $date = date('Y-m-d', strtotime($request->session()->get('date')[0]));
        }

        $projectData = M_Project::where('spk_number', $spk_number)->first();
        // Get material balance data with joins
        $balanceData = DB::table('projects as p')
            ->join('t_jobs as tm', 'tm.project_id', '=', 'p.id')
            ->join('daily_job_reports as djr', 'djr.spk_number', '=', 'p.spk_number')
            ->join('daily_job_report_details as djrd', function($join) {
                $join->on('djrd.daily_report_id', '=', 'djr.id')
                    ->on('djrd.code', '=', 'tm.code');
            })
            ->select(
                'tm.code',
                'tm.name',
                'tm.unit',
                'tm.qty as total_qty',
                'djrd.price as daily_price',
                'djrd.weight',
                DB::raw('COALESCE(SUM(djrd.qty), 0) as daily_qty'),
                // DB::raw('COALESCE(SUM(djrd.price), 0) as daily_price'),
                DB::raw('COALESCE(SUM(djrd.price*djrd.qty), 0) as daily_total_price'),
                DB::raw('CASE
                    WHEN COALESCE(SUM(tm.qty), 0) = COALESCE(SUM(djrd.qty), 0) THEN "BALANCE"
                    ELSE "RETURN"
                END as notes')
            )
            ->when(request('spk_number'), function ($q, $spk_number) {
                $q->where('p.spk_number', 'like', "%$spk_number%");
            })
            ->when(request('date'), function ($q, $date) {
                $q->where('p.date', 'like', "%$date%");
            })
            ->groupBy('tm.code')
            ->groupBy('tm.name')
            ->groupBy('tm.unit')
            ->groupBy('tm.qty')
            ->groupBy('djrd.price')
            ->get();

        if($type == 'J') {
            // return view('admin-page.report.recapt_job', [
            //     'title' => 'Rekap Data Pekerjaan',
            //     'header' => $projectData,
            //     'detail' => $balanceData,
            // ]);

            $data = [
                'title' => 'Rekap Data Pekerjaan',
                'header' => $projectData,
                'detail' => $balanceData,
            ];


            $pdf = Pdf::loadView('admin-page.report.recapt_job', $data);

            $spk_number = str_replace('/', '_', $projectData->spk_number);
            // Download the PDF

            // Download the PDF
            // return $pdf->download('rekapitulasi_pekerjaan_spk'.$spk_number.'.pdf');

            // Alternatively, return as a preview in the browser
            return $pdf->stream('rekapitulasi_pekerjaan_'.$spk_number.'.pdf');
        }
    }

    function generateMaterialRpt(Request $request) {
        $spk_number = '';
        $date = '';
        $type = '';
        if($request->session()->get('type')) {
            $type = (string)$request->session()->get('type')[0];
        }
        if($request->session()->get('spk_number')) {
            $spk_number = (string)$request->session()->get('spk_number')[0];
        }
        if($request->session()->get('date')) {
            $date = date('Y-m-d', strtotime($request->session()->get('date')[0]));
        }

        $projectData = M_Project::where('spk_number', $spk_number)->first();
        // Get material balance data with joins
        // $balanceData = DB::table('projects as p')
        //         ->join('t_materials as tm', 'tm.project_id', '=', 'p.id')
        //         ->join('material_pickups as mp', 'mp.project_id', '=', 'p.id')
        //         ->join('material_pickup_details as mpd', function($join) {
        //             $join->on('mpd.material_pickup_id', '=', 'mp.id')
        //                 ->on('mpd.code', '=', 'tm.code');
        //         })
        //         ->join('daily_material_reports as dmr', 'dmr.project_id', '=', 'p.id')
        //         ->join('daily_material_report_details as dmrd', function($join) {
        //             $join->on('dmrd.daily_report_id', '=', 'dmr.id')
        //                 ->on('dmrd.code', '=', 'tm.code');
        //         })
        //         ->where('p.spk_number', 'like', '%%')
        //         ->select(
        //             'tm.code',
        //             'dmr.date',
        //             'tm.name',
        //             'tm.unit',
        //             'tm.qty as total_qty',
        //             DB::raw('(
        //                 SELECT sum(s_mpd.qty)
        //                 FROM material_pickup_details s_mpd
        //                 WHERE s_mpd.code = tm.code
        //                 GROUP BY s_mpd.code
        //             ) as pickup_qty'),
        //             DB::raw('(
        //                 SELECT sum(s_dmrd.qty)
        //                 FROM daily_material_report_details s_dmrd
        //                 WHERE s_dmrd.code = tm.code
        //                 GROUP BY s_dmrd.code
        //             ) as daily_qty'),
        //             DB::raw('COALESCE(SUM(dmrd.qty), 0) - COALESCE(SUM(mpd.qty), 0) as status'),
        //             DB::raw('CASE WHEN COALESCE(SUM(mpd.qty), 0) = COALESCE(SUM(dmrd.qty), 0) THEN "BALANCE" ELSE "RETURN" END as notes')
        //         )
        //         ->groupBy('tm.code', 'tm.name', 'dmr.date', 'mp.date', 'tm.unit', 'tm.qty')
        //         ->get();

        // Fetch distinct dates from the database
        $dates1 = DB::table('material_pickups')
        ->select('date')
        ->distinct()
        ->orderBy('date')
        ->pluck('date');

        $dates2 = DB::table('daily_material_reports')
        ->select('date')
        ->distinct()
        ->orderBy('date')
        ->pluck('date');

        // Combine both date collections and remove duplicates
        $allDates = $dates1->merge($dates2)->unique()->sort();

        // Convert to an array if needed
        $allDatesArray = $allDates->values()->toArray();

        // Initialize dynamic columns
        $dateColumns = '';
        foreach ($allDatesArray as $date) {
        $formattedDate = date('d/m/Y', strtotime($date));
        $dateColumns .= "
            COALESCE((
                SELECT s_mpd.qty from material_pickup_details as s_mpd
                JOIN material_pickups as s_mp ON s_mpd.material_pickup_id = s_mp.id AND s_mpd.code = tm.code
                WHERE s_mp.date = '$date'
            ), 0) AS '{$formattedDate}_req',
            COALESCE((
                SELECT s_dmrd.qty from daily_material_report_details as s_dmrd
                JOIN daily_material_reports as s_dmr ON s_dmrd.daily_report_id = s_dmr.id AND s_dmrd.code = tm.code
                WHERE s_dmr.date = '$date'
            ), 0) AS '{$formattedDate}_rcv',
            ";
        }

        // Build the final query
        $query = "
        SELECT
            tm.code AS code,
            tm.name AS name,
            tm.unit AS unit,
            tm.qty AS bom,
            $dateColumns
            COALESCE(
            (
                SELECT SUM(s_dmrd.qty) from daily_material_report_details as s_dmrd
                JOIN daily_material_reports as s_dmr ON s_dmrd.daily_report_id = s_dmr.id AND s_dmrd.code = tm.code
                GROUP BY s_dmrd.code
            ) - (
                SELECT SUM(s_mpd.qty) from material_pickup_details as s_mpd
                JOIN material_pickups as s_mp ON s_mpd.material_pickup_id = s_mp.id AND s_mpd.code = tm.code
                GROUP BY s_mpd.code
            ), 0) as status,
            COALESCE((
                SELECT SUM(s_dmrd.weight) from daily_material_report_details as s_dmrd
                JOIN daily_material_reports as s_dmr ON s_dmrd.daily_report_id = s_dmr.id AND s_dmrd.code = tm.code
                GROUP BY s_dmrd.code
            ), 0) as weight,

            CASE
            WHEN
                COALESCE((
                    SELECT SUM(s_dmrd.qty) from daily_material_report_details as s_dmrd
                    JOIN daily_material_reports as s_dmr ON s_dmrd.daily_report_id = s_dmr.id AND s_dmrd.code = tm.code
                    GROUP BY s_dmrd.code
                )) <
                COALESCE((
                    SELECT SUM(s_mpd.qty) from material_pickup_details as s_mpd
                    JOIN material_pickups as s_mp ON s_mpd.material_pickup_id = s_mp.id AND s_mpd.code = tm.code
                    GROUP BY s_mpd.code
                ), 0) THEN 'RETURN'
            WHEN
                COALESCE((
                    SELECT SUM(s_dmrd.qty) from daily_material_report_details as s_dmrd
                    JOIN daily_material_reports as s_dmr ON s_dmrd.daily_report_id = s_dmr.id AND s_dmrd.code = tm.code
                    GROUP BY s_dmrd.code
                )) >
                COALESCE((
                    SELECT SUM(s_mpd.qty) from material_pickup_details as s_mpd
                    JOIN material_pickups as s_mp ON s_mpd.material_pickup_id = s_mp.id AND s_mpd.code = tm.code
                    GROUP BY s_mpd.code
                ), 0) THEN 'RECEIVE'
                ELSE 'BALANCE'
            END as notes

        FROM
            projects p
        JOIN
            t_materials tm ON tm.project_id = p.id
        LEFT JOIN
            material_pickups mp ON mp.project_id = p.id
        LEFT JOIN
            material_pickup_details mpd ON mpd.material_pickup_id = mp.id AND mpd.code = tm.code
        LEFT JOIN
            daily_material_reports dmr ON dmr.project_id = p.id
        LEFT JOIN
            daily_material_report_details dmrd ON dmrd.daily_report_id = dmr.id AND dmrd.code = tm.code
        GROUP BY
            tm.code, tm.name, tm.unit, tm.qty
        ORDER BY
            tm.code;
        ";
        // die($query);
        // Execute the query
        $balanceData = DB::select($query);

        if($type == 'M') {

            $data = [
                'title' => 'Rekap Data Material',
                'header' => $projectData,
                'detail' => $balanceData,
            ];


            $pdf = Pdf::loadView('admin-page.report.recapt_material', $data)
                        ->setPaper('a4', 'landscape');

            $spk_number = str_replace('/', '_', $projectData->spk_number);

            // Download the PDF
            // return $pdf->download('rekapitulasi_material_spk-'.$spk_number.'.pdf');

            // Alternatively, return as a preview in the browser
            return $pdf->stream('rekapitulasi_material_spk-'.$spk_number.'.pdf');
        }
    }
}
