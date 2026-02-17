<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Update atau Create Konten secara Dinamis (Inline Editor)
     */
    public function update(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable' // value bisa berupa string atau file
        ]);

        $key = $request->input('key');
        $value = $request->input('value');
        $page = $request->input('page', 'general'); // Default ke 'general' jika kosong

        // 1. Logika jika yang dikirim adalah FILE (Image/Video)
        if ($request->hasFile('value')) {
            $file = $request->file('value');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Simpan ke public/uploads/content
            $file->move(public_path('uploads/content'), $fileName);
            $value = '/uploads/content/' . $fileName;

            // Opsi: Hapus file lama jika ada (untuk menghemat storage)
            $oldContent = Content::where('key', $key)->first();
            if ($oldContent && str_contains($oldContent->value, '/uploads/')) {
                $oldPath = public_path($oldContent->value);
                if (file_exists($oldPath)) @unlink($oldPath);
            }
        }

        // 2. Update atau Create di Database
        Content::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value ?? '', 
                'page' => $page,
                'section' => 'curator_edit' 
            ]
        );

        return back()->with('success', 'Content updated successfully!');
    }

    /**
     * Manajemen User (CRUD)
     */
    public function userIndex()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'New admin added');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Admin updated successfully.');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}