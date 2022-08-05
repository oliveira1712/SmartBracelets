<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCrud extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'email', 'tipoUserID', 'avatar', 'password', 'created_at', 'updated_at'
    ];
}
