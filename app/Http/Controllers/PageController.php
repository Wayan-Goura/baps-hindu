<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug = 'home')
    {
        // Mencari konten berdasarkan halaman (home, collections, events, atau about)
        // Kita simpan dalam array agar mudah dipanggil di Blade
        $contents = Content::where('page', $slug)->pluck('value', 'key');

        // Pastikan nama file blade kamu sesuai (home.blade.php, collections.blade.php, dll)
        if (view()->exists($slug)) {
            return view($slug, compact('contents'));
        }

        abort(404);
    }
}