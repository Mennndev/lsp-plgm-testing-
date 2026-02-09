<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramPelatihan;

class Skemacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // ambil semua program yang dipublish
    $programs = ProgramPelatihan::where('is_published', 1)->get();

    return view('skema.index', compact('programs'));
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
   public function show(ProgramPelatihan $program)
{
    // load relasi unit & profesi
    $program->load([
        'units' => function ($q) {
            $q->orderBy('no_urut');
        },
        'profesiTerkait',
    ]);

    return view('skema.show', [
        'program' => $program,
    ]);
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
