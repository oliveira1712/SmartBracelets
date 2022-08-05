<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\UserInfo;


class UsersInfoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usersinfo = UserInfo::
                        orderBy('userid','ASC')
                        ->join('users','id','=','userid')
                        ->paginate(10);

        $users = User::orderBy('id','ASC')->get();

        return view('CRUD.usersinfo', [
            'usersinfo' => $usersinfo,           
            'users' => $users,           
        ]);
    }

    function users_info_paginacao(Request $request)
    {
        if($request->ajax())
        {
            $usersinfo = UserInfo::
                        orderBy('userid','ASC')
                        ->join('users','id','=','userid')
                        ->paginate(10);

            $users = User::orderBy('id','ASC')->get();
            return view('CRUD.tableusersinfo', [
                'usersinfo' => $usersinfo,           
                'users' => $users,           
            ])->render();
        }
    }
}
