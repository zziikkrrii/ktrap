<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPPenyerang extends Model
{
    //
    protected $table = 'sessions';

    protected $fillable = 
    [
        'id','notif','updated_at','starttime'
    ];
}
