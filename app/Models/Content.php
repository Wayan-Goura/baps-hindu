<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    // Mengizinkan kolom ini diisi secara otomatis oleh Controller
    protected $fillable = ['page', 'section', 'key', 'value'];
}