<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportResult extends Model
{
    protected $table = 'report_history_result';
    public $timestamps = true;


    protected $fillable = [
        'id_mesin','average_temperature','average_humidity',
        'lowest_temperature',
        'highest_temperature',
        'lowest_humidity',
        'highest_humidity',
        'waktu','created_at',
        'updated_at'
    ];


}
