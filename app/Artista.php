<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $table = 'Artistas';
    protected $primaryKey = 'idartista';
    public $timestamps = false;
    protected $fillable = [
        'idartista', 'artista', 'linkartista', 'foto', 'tpartistaid'
    ];
}
