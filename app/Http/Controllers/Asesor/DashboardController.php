<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PengajuanAsesorAssessment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function index()
    {
        $asesorId = Auth::id();

        $pengajuanList = PengajuanAsesorAssessment::with('pengajuan.user', 'pengajuan.program')
            ->where('asesor_id', $asesorId)
            ->get();

        return view('asesor.dashboard', compact('pengajuanList'));
    }
}
