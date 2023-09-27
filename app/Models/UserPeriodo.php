<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPeriodo extends Model
{
    use HasFactory;

    protected $table = 'users_periodos';

    protected $fillable = [
        'user_id',
        'periodo_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function periodo(){
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
}
