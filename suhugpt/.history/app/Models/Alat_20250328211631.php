<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{    use HasFactory;

    protected $table = 'alat';
    protected $primaryKey = 'id';

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'id_mesin',
        'ip_address',
        'lokasi',
        // 'ip_addres'
    ];

    // Jika tidak ada timestamps (created_at, updated_at), tambahkan:
    // public $timestamps = false;
}
