<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /*VIEW EDIT*/
    public function account_edit(){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();
        return view('account.edit',[
            'user'=>$user
        ]);   
    }

    /*UPDATE EDIT ACCOUNT*/
    public function account_edit_user(Request $request){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'nickname' => 'required|unique:users,nickname,'.$user->id,
            'password' => 'nullable|min:8'
        ]);

        User::where('id', '=', $user->id)->update([
            'email' => $request->email,
            'nickname' => $request->nickname,
        ]);

        if ($request->password != null){
            User::where('id', '=', $user->id)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect('account')->with('success', 'Account editing completed to an average degree!'); 
    }

    /*DELETE ACCOUNT*/
    public function account_delete(){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();

        if (Session::has('login_id')){
            Session::pull('login_id');
            Session::pull('admin');
        }
        User::where('id', '=', $user->id)->delete();
        return redirect('/')->with('success', 'Your account has been deleted!');
    }

    public function account(){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();
        $users = User::get();
        $pending = Friendship::where('friend_id', Session::get('login_id'))->where('status', false)->get();
        $accepted = Friendship::where('friend_id', Session::get('login_id'))->orWhere('user_id', Session::get('login_id'))->where('status', true)->get();


        return view('account.account',[
            'user'=>$user,
            'page'=>0,
            'pending'=>$pending,
            'users'=>$users,
            'accepted' => $accepted
        ]);   
    }

    public function friends(){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();
        $users = User::get();
        $pending = Friendship::where('friend_id', Session::get('login_id'))->where('status', false)->get();
        $accepted = Friendship::where('friend_id', Session::get('login_id'))->where('status', true)->orWhere('user_id', Session::get('login_id'))->where('status', true)->get();

        return view('account.account',[
            'user'=>$user,
            'page'=>1,
            'pending'=>$pending,
            'users'=>$users,
            'accepted' => $accepted
        ]);  
    }

    public function characters(){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();
        $users = User::get();
        $pending = Friendship::where('friend_id', Session::get('login_id'))->where('status', false)->get();
        $accepted = Friendship::where('friend_id', Session::get('login_id'))->orWhere('user_id', Session::get('login_id'))->where('status', true)->get();

        return view('account.account',[
            'user'=>$user,
            'page'=>2,
            'pending'=>$pending,
            'users'=>$users,
            'accepted' => $accepted
        ]);  
    }

    public function admin(){
        $user = User::where('id' ,'=', Session::get('login_id'))->first();
        $users = User::get();
        $pending = Friendship::where('friend_id', Session::get('login_id'))->where('status', false)->get();
        $accepted = Friendship::where('friend_id', Session::get('login_id'))->orWhere('user_id', Session::get('login_id'))->where('status', true)->get();

        return view('account.account',[
            'user'=>$user,
            'page'=>3,
            'pending'=>$pending,
            'users'=>$users,
            'accepted' => $accepted
        ]);  
    }
}
