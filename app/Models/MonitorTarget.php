<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitorTarget extends Model
{
    //

    protected $fillable = [
    'name',
    'host',
    'is_online',
    'latency',
];

}
