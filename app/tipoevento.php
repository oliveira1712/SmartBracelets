<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipoevento extends Model
{
    protected $table = 'tipoeventos';
    public $timestamps = false;
    protected $primaryKey = 'idtpevento';
}
