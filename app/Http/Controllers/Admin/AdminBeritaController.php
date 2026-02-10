<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminBeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::orderByDesc('tanggal_terbit')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        // kirim objek kosong ke form
        $berita = new Berita();
        return view('admin.berita.create', compact('berita'));
    }

  public function store(Request $request)
{
    $data = $this->validateData($request);

    $data['slug'] = Str::slug($data['judul']);
    $data['is_published'] = $request->boolean('is_published', false);

    // HAPUS nilai gambar dari validate kalau ada (biar gak false/0)
    unset($data['gambar']);

    // ambil path dari file upload langsung (ini yang benar)
    if ($request->file('gambar')) {
        $data['gambar'] = $request->file('gambar')->store('berita', 'public');
    } else {
        $data['gambar'] = null;
    }

    Berita::create($data);

    return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
}


    public function edit(Berita $beritum)
    {
        // parameter resource bernama $beritum (default Laravel)
        $berita = $beritum;

        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $beritum)
{
    $berita = $beritum;
    $data   = $this->validateData($request, $berita->id);

    $data['slug'] = Str::slug($data['judul']);
    $data['is_published'] = $request->boolean('is_published', false);

    // ✅ penting: jangan update gambar dari hasil validate (bisa false/0)
    unset($data['gambar']);


    // ✅ ganti gambar jika upload baru
    if ($request->file('gambar')) {
        if ($berita->gambar && $berita->gambar !== '0' && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $data['gambar'] = $request->file('gambar')->store('berita', 'public');
    }



    $berita->update($data);

    return redirect()
        ->route('admin.berita.index')
        ->with('success', 'Berita berhasil diperbarui.');
}


    public function destroy(Berita $beritum)
    {
        $berita = $beritum;

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Validasi data create & update
     */
    protected function validateData(Request $request, $ignoreId = null): array
    {
        // kalau mau unique judul/slug bisa ditambah di sini
        return $request->validate([
            'judul'          => ['required', 'string', 'max:255'],
            'ringkasan'      => ['nullable', 'string'],
            'konten'         => ['required', 'string'],
            'tanggal_terbit' => ['nullable', 'date'],
            'gambar'         => ['nullable', 'image', 'max:10048'],
            'is_published'   => ['nullable', 'boolean'],
        ]);
    }
}
