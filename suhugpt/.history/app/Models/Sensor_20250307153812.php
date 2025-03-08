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

    public function configuration()
    {
        return $this->belongsTo(Configuration::class, 'id_mesin', 'id_mesin');
    }


    protected static function boot()
{
    parent::boot();

    static::created(function ($sensor) {
        event(new SensorDataUpdate($sensor));
    });

    static::updated(function ($sensor) {
        event(new SensorDataUpdate($sensor));
    });
}

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($sensorData) {
    //         // \Log::info('Event SensorDataUpdate dipicu', ['data' => $sensorData]);
    //         event(new SensorDataUpdate($sensorData));
    //     });
    // }
}
