<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    function get()
    {
        $chat = Chat::orderBy('created_at', 'desc')->limit(5)->get();
        $count = count($chat);
        for ($i = 0; $i < $count / 2; $i++) {
            $temp = $chat[$i];
            $chat[$i] = $chat[$count - $i - 1];
            $chat[$count - $i - 1] = $temp;
        }
        return $chat;
    }
    function post(Request $request)
    {
        $request->validate([                                                            //validation
            'chat' => 'required|max:255',
        ]);
        $id = Session::get('login_id');
        $user = new Chat();
        $user->user_id = $id;
        $user->content = $request->chat;
        $res = $user->save();

        if ($res) {
            return redirect('/game')->with('chat', $this->get());
        }
    }
}
