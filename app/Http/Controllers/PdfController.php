<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use App\Models\M_Project;
use App\Models\M_TJob;
use App\Models\M_TMaterial;
use App\Models\M_DailyJobReport;
use App\Models\M_DailyJobDetailReport;
use App\Models\M_DailyMaterialReport;
use App\Models\M_DailyMaterialDetailReport;

class PdfController extends Controller
{
    public function generateProjectPdf($id)
    {

        $header = M_Project::find($id);

        $detail_j = M_TJob::where('project_id', $header->id)->get();
        $detail_m = M_TMaterial::where('project_id', $header->id)->get();

        $data = [
            'title' => 'Form Data Proyek',
            'header' => $header,
            'detail_j' => $detail_j,
            'detail_m' => $detail_m
        ];

        $pdf = Pdf::loadView('pdf/detail-template', $data);

        // Download the PDF
        // return $pdf->download('proyek_spk'.$header->spk_number.'.pdf');

        // Alternatively, return as a preview in the browser
        return $pdf->stream('proyek_spk'.$header->spk_number.'.pdf');
    }

    public function generateDailyJobPdf($id)
    {

        $header = M_DailyJobReport::find($id);

        $detail_j = M_DailyJobDetailReport::where('daily_report_id', $header->id)->get();

        $data = [
            'title' => 'Laporan Harian Pekerjaan',
            'header' => $header,
            'detail_j' => $detail_j,
            'detail_m' => []
        ];

        $pdf = Pdf::loadView('pdf/daily-job-template', $data);

        // Download the PDF
        // return $pdf->download('proyek_spk'.$header->spk_number.'.pdf');

        // Alternatively, return as a preview in the browser
        return $pdf->stream('laporan_pekerjaan_harian_spk'.$header->spk_number.'.pdf');
    }

    public function generateDailyMaterialPdf($id)
    {

        $header = M_DailyMaterialReport::find($id);

        $detail_m = M_DailyMaterialDetailReport::where('daily_report_id', $header->id)->get();

        $data = [
            'title' => 'Laporan Harian Material',
            'header' => $header,
            'detail_j' => [],
            'detail_m' => $detail_m
        ];

        $pdf = Pdf::loadView('pdf/daily-material-template', $data);

        // Download the PDF
        // return $pdf->download('proyek_spk'.$header->spk_number.'.pdf');

        // Alternatively, return as a preview in the browser
        return $pdf->stream('laporan_material_harian_spk'.$header->spk_number.'.pdf');
    }

    public function generateRecaptPdf($spk_number)
    {

        $header = M_DailyMaterialReport::find($id);

        $detail_m = M_DailyMaterialDetailReport::where('daily_report_id', $header->id)->get();

        $data = [
            'title' => 'Laporan Harian Material',
            'header' => $header,
            'detail_j' => [],
            'detail_m' => $detail_m
        ];

        $pdf = Pdf::loadView('pdf/daily-material-template', $data);

        // Download the PDF
        // return $pdf->download('proyek_spk'.$header->spk_number.'.pdf');

        // Alternatively, return as a preview in the browser
        return $pdf->stream('laporan_material_harian_spk'.$header->spk_number.'.pdf');
    }
}
