<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartaz extends Model
{
    protected $table = 'cartazes';
    public $timestamps = false;
    protected $fillable = [
        'ideventoc', 'idartistac', 'local', 'datainicio', 'datafim', 'horainicio', 'horafim'
    ];
}
