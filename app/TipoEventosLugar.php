<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEventosLugar extends Model
{
    protected $table = 'tipoeventoslugares';
    protected $primaryKey = 'idtpeventolugar';
    public $timestamps = false;
    
}
