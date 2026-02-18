<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendInvestment(Request $request) 
    {
        // 1. Validasi Input
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'email'    => 'required|email',
            'interest' => 'required'
        ]);

        // 2. Logika Pengiriman Email
        // Pastikan konfigurasi .env (MAIL_USERNAME, dll) sudah benar
        Mail::send([], [], function ($message) use ($data) {
            $message->to('company@gmail.com') // GANTI dengan email perusahaan Anda
                    ->subject('New Investment Inquiry: ' . $data['name'])
                    ->html("
                        <div style='font-family: sans-serif; line-height: 1.6; color: #333;'>
                            <h2 style='color: #d4af37;'>New Investment Dossier Request</h2>
                            <hr style='border: 0; border-top: 1px solid #eee;'>
                            <p><strong>Full Name:</strong> {$data['name']}</p>
                            <p><strong>Phone Number:</strong> {$data['phone']}</p>
                            <p><strong>Email Address:</strong> {$data['email']}</p>
                            <p><strong>Interest Type:</strong> {$data['interest']}</p>
                            <hr style='border: 0; border-top: 1px solid #eee;'>
                            <p style='font-size: 10px; color: #999;'>Sent from Subfossil Oak Investment Portal</p>
                        </div>
                    ");
        });

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Thank you. Your request has been sent.');
    }
}
