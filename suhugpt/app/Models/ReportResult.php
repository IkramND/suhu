<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportResult extends Model
{
    protected $table = 'report_history_result';
    public $timestamps = true; // Pastikan timestamps aktif


    protected $fillable = [
        'id_mesin','rata_rata_suhu', 'rata_rata_kelembaban','waktu','created_at','updated_at'
    ];


}
