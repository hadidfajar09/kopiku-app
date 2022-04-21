<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko', 'alamat', 'deskripsi', 'image',
    ];
}
