<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function game()
    {
        $user =  User::where('id' ,'=', Session::get('login_id'))->first();
        $map = json_decode($user['map_data']);
        $coins = $user['coins'];
        $missions = $user['missions'];
        $dict_seeding_count = $user['dict_seeding_count'];
        
        $currentDate = date('Y-m-d\TH:i:s.v\Z');
        foreach($map as $y){
            foreach($y as $value){
                if (!is_int($value->dateEnd)) {
                    if (strtotime($value->dateEnd) > strtotime($currentDate)) {} else {
                        switch ($value->kindGrowing) {
                            case $this->dict_kind['wheat']: $value->platformSecond = $this->dict_platform_second['wheat'];break;
                            case $this->dict_kind['tomato']: $value->platformSecond = $this->dict_platform_second['tomato']; break;
                            case $this->dict_kind['carrot']: $value->platformSecond = $this->dict_platform_second['carrot']; break;
                        };
                        $value->dateEnd = 0;
                        $value->startEnd = 0;
                        $value->platform = 1;
                        $value->kindGrowing = 0;
                    }
                }
            };
        };

        if ($map != null){
            return view('game',[
                'map'=>$map,
                'coins'=>json_decode($coins),
                'missions'=>json_decode($missions),
                'dict_seeding_count'=>json_decode($dict_seeding_count),
            ]);
        }else{
            return 'some error';
        }
        
    }
    public function game_update(Request $request){
        $map = $request->map;
        $coins = $request->coins;
        $missions = $request->missions;
        $dict_seeding_count = $request->count;
        User::where('id' ,'=', Session::get('login_id'))->update(['map_data' => $map]);
        User::where('id' ,'=', Session::get('login_id'))->update(['coins' => $coins]);
        User::where('id' ,'=', Session::get('login_id'))->update(['missions' => $missions]);
        User::where('id' ,'=', Session::get('login_id'))->update(['dict_seeding_count' => $dict_seeding_count]);

        return ['ok'=>'ok'];
    }
}
