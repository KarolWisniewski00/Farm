<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Session;

class FriendshipsController extends Controller
{
    function friend_add(Request $request)
    {
        $friend = User::where('nickname', '=', $request->nickname)->first();
        $user = User::where('id', '=', Session::get('login_id'))->first();

        //if user dont exist
        if ($friend == null) {
            return redirect('friends')->with('fail', "That user don't exist");

            //if user exist
        } else {
            // check if there is already a friendship with this user
            $existingFriendship = Friendship::where(function ($query) use ($user, $friend) {
                $query->where('user_id', '=', $user->id)
                    ->where('friend_id', '=', $friend->id);
            })->orWhere(function ($query) use ($user, $friend) {
                $query->where('user_id', '=', $friend->id)
                    ->where('friend_id', '=', $user->id);
            })->first();

            // if a friendship already exists, don't add a new invitation
            if ($existingFriendship !== null) {
                return redirect('friends')->with('fail', 'You have already sent an invitation to this user.');
            }
            $friendship = new Friendship();
            $friendship->user_id = $user->id;
            $friendship->friend_id = $friend->id;
            $friendship->status = false;
            $res = $friendship->save();
            if ($res) {
                return redirect('friends')->with('success', "Send invitation!");
            } else {
                return redirect('friends')->with('fail', "Some error!");
            }
        }
    }

    public function friend_update(Request $request){
        $status = $request->input('status');
        $friend = $request->input('friend');
        
        if ($status == 'accept') {
            Friendship::where('friend_id', Session::get('login_id'))->where('user_id', $friend)->update(['status' => true]);
            return redirect('friends')->with('success', "Accepted!");
        } elseif ($status == 'reject') {
            Friendship::where('friend_id', '=', Session::get('login_id'))->where('user_id', '=', $friend)->delete();
            return redirect('friends')->with('success', "Rejected!");
        }
    }
}
