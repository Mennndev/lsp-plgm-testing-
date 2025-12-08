<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    // Untuk menampilkan 3 artikel terbaru di halaman home
     public function latest()
    {
        return Berita::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();
    }

    // Untuk halaman list semua artikel
    public function index()
    {
        $beritas = Berita::where('is_published', true)
            ->latest()
            ->paginate(9);

        return view('berita.index', compact('beritas'));
    }

    // Untuk halaman detail artikel
    public function show($slug)
    {
        $beritas = Berita::where('slug', $slug)->firstOrFail();
        $beritas->increment('views');

        return view('artikel.show', compact('beritas'));
    }
}
