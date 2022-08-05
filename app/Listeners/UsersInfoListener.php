<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\UserInfo;
use DB;
use Browser;
use Auth;
use Carbon\Carbon;
use Cache;
use Request;
use Jenssegers\Agent\Agent;

class UsersInfoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $agent = new Agent();

        $checkifuserinfoexists = DB::table('usersinfo')
                            ->where('userid',Auth::user()->id)
                            ->get();


        date_default_timezone_set('Europe/Lisbon');       
        
        
        
        if(count($checkifuserinfoexists)>0){
            $form_data = array(
                'userid'        =>  Auth::user()->id,
                'browser'         =>  $agent->browser(),
                'plataforma'         =>  $agent->platform(),
                'ip'             =>  Request::ip(),
                'current_sign_in_at'             =>  Carbon::now()
                
            );   

            UserInfo::whereuserid(Auth::user()->id)->update($form_data);
        }else{
            $form_data = array(
                'userid'        =>  Auth::user()->id,
                'browser'         =>  $agent->browser(),
                'plataforma'         =>  $agent->platform(),
                'ip'             =>  Request::ip(),
                'current_sign_in_at'             =>  Carbon::now()
            );   
            
            UserInfo::create($form_data);
        }

    

       
    }
}
