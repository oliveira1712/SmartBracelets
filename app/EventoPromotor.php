<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoPromotor extends Model
{
    protected $table = 'eventospromotores';
    public $timestamps = false;
    protected $fillable = [
        'eventoid', 'promotorid', 'descricao'
    ];
}
