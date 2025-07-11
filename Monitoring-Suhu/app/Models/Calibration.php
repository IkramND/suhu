<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
   protected $table = 'calibration';

   protected $fillable = ['id_mesin','temperature_calibration','humidity_calibration'];
}
