<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eventos extends Model
{
    protected $table = 'Eventos';
    protected $primaryKey = 'IDEvento';
    public $timestamps = false;
    protected $fillable = [
        'idevento', 'evento', 'local', 'latitude', 'longitude', 'datainicio', 'horainicio', 'datafim', 'horafim', 'lotacao', 'preco', 'foto', 'fotocartaz', 'zonaid', 'tpeventoid', 'classificacaoid', 'estadoeventoid', 'tpeventolugarid', 'linkcompra' 
    ];
}
