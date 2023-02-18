<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class ResetPasswordController extends Controller
{
    public function forget(){
        return view('forget');
    }

    public function forget_mail(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user=0){
            return redirect('/')->with('fail', 'Email no exist!');
        }else{
            $token = Str::random(8);
            User::where('email', $request->email)->update(['password'=> Hash::make($token)]);
            Mail::to($request->email)->send(new ExampleEmail($token));
            return redirect('/')->with('success', 'Email send');
        }

    }
}
