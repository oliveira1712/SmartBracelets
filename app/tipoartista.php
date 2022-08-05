<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoartista extends Model
{
    protected $table = 'tipoartistas';
    public $timestamps = false;
    protected $primaryKey = 'idtpartista';
    protected $fillable = [
        'idtpartista', 'tipoartista', 'descricao'
    ];
}
