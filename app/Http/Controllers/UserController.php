<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /*LOGIN*/
    public function login_user(Request $request){                                       //Request - take data from form
        $request->validate([                                                            //validation
            'email_login' => 'required|email',
            'password_login' => 'required|min:8'
        ]);

        $user = User::where('email', '=',$request->email_login)->first();               //if all good, find in database

        if($user){                                                                      //if user exist
            if(Hash::check($request->password_login, $user->password)){                 //chcek password
                $request->session()->put('login_id',$user->id);                         //set session variable
                if ($user->admin==true){                                                //if user is admin
                    $request->session()->put('admin',$user->admin);                     //set extra variable session
                }
                return redirect('/game');                                               //if all ok return view
            }else{
                return redirect('/')->with('fail', 'Hasła nie pasują do siebie!');      //if passwords aren't match
            }
        }else{
            return redirect('/')->with('fail', 'Nie ma takiego użytkownika!');          //if user doesn't exist
        }
    }

    /*REGISTER*/
    public function register_user(Request $request){                                    //Request - take data from form
        $request->validate([                                                            //validation
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = new User();                                                             //create new object from class User (model)
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);                               //hash the password
        $user->admin = false;
        $user->map_data = json_encode($this->map_default);
        $user->coins = $this->coins_default;
        $user->missions = json_encode($this->missions_default);
        $user->dict_seeding_count = json_encode($this->dict_seeding_count_default);
        $res = $user->save();                                                           //save record in database

        if ($res) {
            return redirect('/')->with('success', 'Zarejestrowałeś się z powodzeniem!');//if all ok return message
        } else {
            return redirect('/')->with('fail', 'Coś poszło nie tak!');                  //else also return message
        }
    }

    /*LOGOUT*/
    public function logout(){
        if (Session::has('login_id')){  //chcek if variable session exist
            Session::pull('login_id');  //if yes - delete
            Session::pull('admin');
            return redirect('/');       //return main route
        }
    }
}
