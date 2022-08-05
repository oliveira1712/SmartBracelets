<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tipouser extends Model
{
    protected $primaryKey = 'idTipoUser';
    protected $fillable = [
        'idTipoUser', 'Nome', 'Descricao'
    ];
}
