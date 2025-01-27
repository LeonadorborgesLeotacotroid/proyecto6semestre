<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'cliente',
        'email',
        'documento',
        'telefono',
        'direccion',
        'fecha_nac',
        'estado'
    ];

    public $timestamps = false;
}
