<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Browser;
use Auth;

class UserInfo extends Model
{
    protected $table = 'usersinfo';
    protected $primaryKey = 'userid';
    public $timestamps = false;
    protected $fillable = [
        'userid', 'browser', 'plataforma', 'ip', 'current_sign_in_at', 'last_sign_in_at'
    ];

    protected $dates = [
        'current_sign_in_at', 'last_sign_in_at'
    ];

    //Check if User is online
    public function isOnline($userid){
        return Cache::has('user-is-online-' .  $userid /* $this->id */);
    }
    
}
