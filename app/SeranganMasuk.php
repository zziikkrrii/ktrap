<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AttackerLogin;

class SeranganMasuk extends Model
{
    //
    protected $table = 'sessions';

    protected $fillable = [
        'notif' , 'updated_at','level'
    ];
}
