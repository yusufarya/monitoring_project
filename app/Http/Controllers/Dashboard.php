<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Registrant;
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

        $cur_route = Route::current()->uri();
        $data = Auth::guard('web')->user();
        return view('admin-page.dashboard', [
            'title' => 'Dashboard',
            'cur_page' => $cur_route,
            'auth_user' => $data,
            'pendaftarBaru' => DB::table('users')->count(),
            'pesertaApprove' => DB::table('users')->where('is_active', '=', 'Y')->count(),
            'pesertaLulus' => DB::table('users')->where('is_active', '=', 'Y')->count(),
            'pesertaTidakLulus' => DB::table('users')->where('is_active', '=', 'N')->count(),
            'registrant_group' => [],
            'countRegistrant' => $countRegistrant,
        ]);
    }
}
