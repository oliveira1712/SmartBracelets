<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotor extends Model
{
    protected $table = 'promotores';
    protected $primaryKey = 'idpromotor';
    public $timestamps = false;
    protected $fillable = [
        'idpromotor', 'promotor', 'descricao', 'tipopromotorid'
    ];
}
