<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class alat extends Model
{    use HasFactory;

    protected $table = 'alat'; // Pastikan ini sesuai dengan nama tabel di database
    protected $primaryKey = 'id_mesin'; // Jika primary key bukan 'id', ubah sesuai tabel

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'alat_id',
        'id_mesin',
        'ip_addres'
    ];

    // Jika tidak ada timestamps (created_at, updated_at), tambahkan:
    public $timestamps = false;
}
