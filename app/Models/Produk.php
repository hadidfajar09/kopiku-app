<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk', 'nama_toko_id', 'harga', 'stok', 'deskripsi_produk', 'thumbnail', 'multiple_img'
    ];

    static function getProduk()
    {
        $return = DB::table('produks')
            ->join('tokos', 'produks.nama_toko_id', '=', 'tokos.id');

        return $return;
    }
}
