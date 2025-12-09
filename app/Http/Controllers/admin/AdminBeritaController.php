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

        return view('admin.Berita.index', compact('beritas'));
    }

    public function create()
    {
        // kirim objek kosong ke form
        $berita = new Berita();
        return view('admin.Berita.create', compact('berita'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // slug otomatis dari judul
        $data['slug'] = Str::slug($data['judul']);

        // upload gambar kalau ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // checkbox publish
        $data['is_published'] = $request->boolean('is_published', false);

        Berita::create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $beritum)
    {
        // parameter resource bernama $beritum (default Laravel)
        $berita = $beritum;

        return view('admin.Berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $beritum)
    {
        $berita = $beritum;
        $data   = $this->validateData($request, $berita->id);

        $data['slug'] = Str::slug($data['judul']);
        $data['is_published'] = $request->boolean('is_published', false);

        // ganti gambar jika upload baru
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
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
