<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PengajuanAsesor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $asesorId = auth()->id();

    $pengajuanList = PengajuanAsesor::with('pengajuan.user', 'pengajuan.program')
        ->where('asesor_id', $asesorId)
        ->get();

    return view('asesor.dashboard', compact('pengajuanList'));
}
}
