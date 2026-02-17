<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Admin atau Preview Halaman
     */
    public function index()
    {
        $contents = Setting::pluck('value', 'key');
        return view('admin.dashboard', compact('contents'));
    }

    /**
     * Menyimpan atau mengupdate konten (Teks, Gambar, & Video Lokal)
     */
    public function update(Request $request)
    {
        // 1. Ambil semua input (teks) dan file
        $inputs = $request->except('_token', 'page');
        
        // 2. Loop melalui semua input yang dikirim
        foreach ($inputs as $key => $value) {
            
            $finalValue = $value;

            // 3. Logika jika input adalah File (Gambar atau Video)
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                
                // Ambil extension untuk validasi internal jika diperlukan
                $extension = $file->getClientOriginalExtension();
                
                // Simpan file ke folder 'public/uploads'
                // time() digunakan agar nama file unik dan tidak tertukar
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $fileName, 'public');
                
                // Set value yang akan disimpan ke database sebagai path URL
                $finalValue = '/storage/' . $path;

                // Opsional: Hapus file lama jika ingin menghemat ruang server
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value) {
                    $oldPath = str_replace('/storage/', '', $oldSetting->value);
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // 4. Simpan ke Database
            // Jika value kosong (misal input file tidak diisi), jangan update jika sudah ada data
            if ($finalValue !== null) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $finalValue]
                );
            }
        }

        return back()->with('success', 'Konten berhasil diperbarui!');
    }
}