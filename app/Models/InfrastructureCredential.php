<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfrastructureCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'host',
        'username',
        'password',
        'description',
    ];

    // Encriptar antes de guardar
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }

    // Desencriptar cuando se lea
    public function getPasswordAttribute($value)
    {
        return decrypt($value);
    }
}
