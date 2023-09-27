<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $table = 'users';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'documento',
        'usuario',
        'password',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function periodos(){
        return $this->hasMany(UserPeriodo::class, 'user_id');
    }

    public function metas(){
        return $this->hasMany(MetaDeProducto::class, 'user_id');
    }

    ////Auto encriptado
    public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

    public function username()
    {
        return 'usuario';
    }
}
