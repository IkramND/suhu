<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{

    use HasFactory;


    protected $table = 'configuration';
    protected $primaryKey = 'id';


    protected $fillable = [ 'id_mesin','batas_atas_suhu','batas_bawah_suhu','batas_atas_kelembaban','batas_bawah_kelembaban' ];


    public function sensorData()
    {
        return $this->hasMany(SensorData::class, 'id_mesin', 'id_mesin');
    }




}
