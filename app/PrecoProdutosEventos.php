<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DataTables;
use Validator;
use DB;

class PrecoProdutosEventos extends Model
{
    protected $table = 'produto_preco_evento';
    public $timestamps = false;
    protected $fillable = [
        'produtoid', 'eventoid', 'preco'
    ];
}
