<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsesorRequest;
use App\Http\Requests\UpdateAsesorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'asesor');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }
        
        $asesors = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.asesor.index', compact('asesors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.asesor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAsesorRequest $request)
    {
        $data = $request->validated();
        
        // Hash the password
        $data['password'] = Hash::make($data['password']);
        
        // Set role as asesor
        $data['role'] = 'asesor';
        
        // Handle status_aktif checkbox (defaults to true if not provided)
        $data['status_aktif'] = $request->has('status_aktif') ? true : false;
        
        User::create($data);
        
        return redirect()->route('admin.asesor.index')
                         ->with('success', 'Asesor berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);
        return view('admin.asesor.show', compact('asesor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);
        return view('admin.asesor.edit', compact('asesor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAsesorRequest $request, string $id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);
        
        $data = $request->validated();
        
        // Only update password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        // Remove password_confirmation from data
        unset($data['password_confirmation']);
        
        // Handle status_aktif checkbox
        $data['status_aktif'] = $request->has('status_aktif') ? true : false;
        
        $asesor->update($data);
        
        return redirect()->route('admin.asesor.index')
                         ->with('success', 'Data asesor berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);
        
        $asesor->delete();
        
        return redirect()->route('admin.asesor.index')
                         ->with('success', 'Asesor berhasil dihapus');
    }
}
