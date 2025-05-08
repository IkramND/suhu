<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'role','created_at','updated_at'
    ];

    public function user(){
        return $this->hasMany(User::class);
    }
}
