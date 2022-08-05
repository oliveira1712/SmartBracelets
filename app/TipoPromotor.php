<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPromotor extends Model
{
    protected $table = 'tipopromotores';
    protected $primaryKey = 'idtppromotor';
    public $timestamps = false;
    protected $fillable = [
        'idtppromotor', 'tipopromotor', 'descricao'
    ];
}
