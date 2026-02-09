<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAsesorRequest;
use App\Http\Requests\UpdateAsesorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'asesor')->with('asesorProfile');
        
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
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Create user
            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'no_hp' => $data['no_hp'],
                'role' => 'asesor',
                'status_aktif' => $request->has('status_aktif') ? true : false,
            ]);
            
            // Create asesor profile
            $user->asesorProfile()->create([
                'alamat' => $data['alamat'] ?? null,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.asesor.index')
                             ->with('success', 'Asesor berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $asesor = User::where('role', 'asesor')->with('asesorProfile')->findOrFail($id);
        return view('admin.asesor.show', compact('asesor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asesor = User::where('role', 'asesor')->with('asesorProfile')->findOrFail($id);
        return view('admin.asesor.edit', compact('asesor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAsesorRequest $request, string $id)
    {
        $asesor = User::where('role', 'asesor')->findOrFail($id);
        
        $data = $request->validated();
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Update user
            $asesor->update([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
                'status_aktif' => $request->has('status_aktif') ? true : false,
            ]);
            
            // Update password if provided
            if (!empty($data['password'])) {
                $asesor->update(['password' => Hash::make($data['password'])]);
            }
            
            // Update or create asesor profile
            $asesor->asesorProfile()->updateOrCreate(
                ['user_id' => $asesor->id],
                ['alamat' => $data['alamat'] ?? null]
            );
            
            DB::commit();
            
            return redirect()->route('admin.asesor.index')
                             ->with('success', 'Data asesor berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
