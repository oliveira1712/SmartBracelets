<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pulseira extends Model
{
    protected $table = 'pulseiras';
    protected $primaryKey = 'idpulseira';
    public $timestamps = false;
    protected $fillable = [
        'idpulseira', 'nrseriepulseira', 'plafond', 'estadopulseiraid', 'descricao'
    ];
}
