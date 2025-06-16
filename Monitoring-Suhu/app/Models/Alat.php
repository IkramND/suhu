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
    ];


    public function sensorData()
    {
    return $this->hasMany(Sensor::class, 'id_mesin', 'id_mesin');
    }
}
