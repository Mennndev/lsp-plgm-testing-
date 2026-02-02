<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;

class AsesiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        // query dasar + relasi user
        $query = Pendaftaran::with('user');

        // FILTER PENCARIAN
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('skema', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // FILTER STATUS -> pakai kolom `setuju`
        //  - 'pending'  => setuju = 0
        //  - 'disetujui'=> setuju = 1
        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('setuju', 0);
            } elseif ($request->status === 'disetujui') {
                $query->where('setuju', 1);
            }
        }

        // DATA LIST + STATISTIK
        $asesiList        = $query->orderByDesc('created_at')->paginate(10);
        $totalAsesi       = Pendaftaran::count();
        $totalPending     = Pendaftaran::where('setuju', 0)->count();
        $totalDisetujui   = Pendaftaran::where('setuju', 1)->count();

        return view('admin.asesi.index', compact(
            'asesiList',
            'totalAsesi',
            'totalPending',
            'totalDisetujui'
        ));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
