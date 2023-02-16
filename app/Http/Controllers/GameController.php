<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    /*GAME*/
    public function game()
    {
        $user =  User::where('id' ,'=', Session::get('login_id'))->first();     //get data about the user
        $map = json_decode($user['map_data']);                                  //decode map - change string to json
        $coins = $user['coins'];                                                //save help variable
        $missions = $user['missions'];                                          //save help variable
        $dict_seeding_count = $user['dict_seeding_count'];                      //save help variable
        $character = $user['character'];                                        //save help variable
        
        $currentDate = date('Y-m-d\TH:i:s.v\Z');                                //get current date

        /*CHECK THE PLANT - if it's ready then change the map*/
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

        if ($map != null){                                                  //if all good return view
            return view('game',[
                'map'=>$map,
                'coins'=>json_decode($coins),
                'missions'=>json_decode($missions),
                'dict_seeding_count'=>json_decode($dict_seeding_count),
                'character'=>$character,
            ]);
        }else{                                                              //else retunr error - the game screen will not be loaded
            return 'some error';
        }
        
    }

    /*GAME UPDATE/SAVE*/
    public function game_update(Request $request){
        User::where('id' ,'=', Session::get('login_id'))->update(['map_data' => $request->map]);
        User::where('id' ,'=', Session::get('login_id'))->update(['coins' => $request->coins]);
        User::where('id' ,'=', Session::get('login_id'))->update(['missions' => $request->missions]);
        User::where('id' ,'=', Session::get('login_id'))->update(['dict_seeding_count' => $request->count]);
        return ['ok'=>'ok'];
    }
}
