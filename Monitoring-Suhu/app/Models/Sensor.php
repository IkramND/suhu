<?php

namespace App\Models;

use App\Events\SensorDataUpdate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'data_sensor'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['id_mesin', 'suhu', 'kelembaban', 'waktu']; // Tambahkan id_mesin!

    // protected static function booted()
    // {
    //     static::created(function ($sensor){
    //         $existing = Alat::where('id_mesin',$sensor->id_mesin)->first();
    //         if(!$existing){
    //             Alat::created([
    //                 'id_mesin' => $sensor->id_mesin,
    //                 'ip_address' => $sensor->ip_address,
    //                 'lokasi' => $sensor->lokasi
    //             ]);
    //         }
    //     });
    // }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class, 'id_mesin', 'id_mesin');
    }

    public function alat()
{
    return $this->belongsTo(Alat::class, 'id_mesin', 'id_mesin');
}

}
