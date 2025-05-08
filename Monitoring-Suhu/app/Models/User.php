<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password','role_id','acess'];

    protected $hidden = ['password'];

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
