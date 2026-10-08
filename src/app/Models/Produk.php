<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    // nama kolom yg boleh diisi lewat mass assignment
    protected $fillable = [
        'nama',
        'kode',
        'harga',
        'stok',
        'deskripsi',
        'catatan',
        'aktif',
    ];
}
