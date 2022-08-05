<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecoEvento extends Model
{
    protected $table = 'precoeventos';
    protected $primaryKey = 'eventoid';
    public $timestamps = false;
    protected $fillable = [
        'eventoid', 'preco'
    ];
}
