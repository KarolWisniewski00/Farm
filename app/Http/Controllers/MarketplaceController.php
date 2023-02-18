<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marketplace;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class MarketplaceController extends Controller
{
    function marketplace_add(Request $request)
    {
        $sell = ['wheat' => $request->sell_wheat, 'tomato' => $request->sell_tomato, 'carrot' => $request->sell_carrot, 'corn' => $request->sell_corn, 'milk' => $request->sell_milk, 'egg' => $request->sell_egg, 'coin' => $request->sell_coin,];
        $for = ['wheat' => $request->for_wheat, 'tomato' => $request->for_tomato, 'carrot' => $request->for_carrot, 'corn' => $request->for_corn, 'milk' => $request->for_milk, 'egg' => $request->for_egg, 'coin' => $request->for_coin,];
        $sell = json_encode($sell);
        $for = json_encode($for);
        $user = User::where('id', '=', Session::get('login_id'))->first();
        $dict_seeding_count = json_decode($user['dict_seeding_count']);

        if (intval($request->sell_coin) > $user['coins']) {
            return redirect('marketplace')->with('fail', 'No enought coins!');
        }
        if (intval($request->sell_wheat) > intval($dict_seeding_count->wheat)) {
            return redirect('marketplace')->with('fail', 'No enought wheat!');
        }
        if (intval($request->sell_tomato) > intval($dict_seeding_count->tomato)) {
            return redirect('marketplace')->with('fail', 'No enought tomato!');
        }
        if (intval($request->sell_carrot) > intval($dict_seeding_count->carrot)) {
            return redirect('marketplace')->with('fail', 'No enought carrot!');
        }
        if (intval($request->sell_corn) > intval($dict_seeding_count->corn)) {
            return redirect('marketplace')->with('fail', 'No enought corn!');
        }
        if (intval($request->sell_milk) > intval($dict_seeding_count->milk)) {
            return redirect('marketplace')->with('fail', 'No enought milk!');
        }
        if (intval($request->sell_egg) > intval($dict_seeding_count->egg)) {
            return redirect('marketplace')->with('fail', 'No enought egg!');
        }
        if (intval($request->sell_coin) == 0 && intval($request->sell_wheat) == 0 && intval($request->sell_tomato) == 0 && intval($request->sell_carrot) == 0 && intval($request->sell_corn) == 0 && intval($request->sell_milk) == 0 && intval($request->sell_egg) == 0) {
            return redirect('marketplace')->with('fail', 'No enought products!');
        }
        if (intval($request->for_coin) == 0 && intval($request->for_wheat) == 0 && intval($request->for_tomato) == 0 && intval($request->for_carrot) == 0 && intval($request->for_corn) == 0 && intval($request->for_milk) == 0 && intval($request->for_egg) == 0) {
            return redirect('marketplace')->with('fail', 'No enought products!');
        }

        $marketplace = new Marketplace();
        $marketplace->user_id = Session::get('login_id');
        $marketplace->sell = $sell;
        $marketplace->for = $for;
        $res = $marketplace->save();

        if (intval($request->sell_coin) > 0) {
            User::where('id', '=', Session::get('login_id'))->update(['coins' => $user['coins'] - intval($request->sell_coin)]);
        }
        if (intval($request->sell_wheat) > 0) {
            $dict_seeding_count->wheat = $dict_seeding_count->wheat - intval($request->sell_wheat);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($request->sell_tomato) > 0) {
            $dict_seeding_count->tomato = $dict_seeding_count->tomato - intval($request->sell_tomato);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($request->sell_carrot) > 0) {
            $dict_seeding_count->carrot = $dict_seeding_count->carrot - intval($request->sell_carrot);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($request->sell_corn) > 0) {
            $dict_seeding_count->corn = $dict_seeding_count->corn - intval($request->sell_corn);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($request->sell_milk) > 0) {
            $dict_seeding_count->milk = $dict_seeding_count->milk - intval($request->sell_milk);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($request->sell_egg) > 0) {
            $dict_seeding_count->egg = $dict_seeding_count->egg - intval($request->sell_egg);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }



        if ($res) {
            return redirect('marketplace')->with('success', 'You have successfully added!'); //if all ok return message
        } else {
            return redirect('marketplace')->with('fail', 'Some error!');                          //else also return message
        }
    }
    public function marketplace_cancel($id)
    {
        $marketplace = Marketplace::where('id', '=', $id)->first();
        $sell = json_decode($marketplace->sell);
        $user = User::where('id', '=', Session::get('login_id'))->first();
        $dict_seeding_count = json_decode($user['dict_seeding_count']);

        if (intval($sell->coin) > 0) {
            User::where('id', '=', Session::get('login_id'))->update(['coins' => $user['coins'] + intval($sell->coin)]);
        }
        if (intval($sell->wheat) > 0) {
            $dict_seeding_count->wheat = $dict_seeding_count->wheat + intval($sell->wheat);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->tomato) > 0) {
            $dict_seeding_count->tomato = $dict_seeding_count->tomato + intval($sell->tomato);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->carrot) > 0) {
            $dict_seeding_count->carrot = $dict_seeding_count->carrot + intval($sell->carrot);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->corn) > 0) {
            $dict_seeding_count->corn = $dict_seeding_count->corn + intval($sell->corn);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->milk) > 0) {
            $dict_seeding_count->milk = $dict_seeding_count->milk + intval($sell->milk);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->egg) > 0) {
            $dict_seeding_count->egg = $dict_seeding_count->egg + intval($sell->egg);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        Marketplace::where('id', '=', $id)->delete();
        return redirect('marketplace')->with('success', 'You have successfully canceled!');
    }
    public function marketplace_accept($id)
    {
        $marketplace = Marketplace::where('id', '=', $id)->first();
        $for = json_decode($marketplace->for);
        $sell = json_decode($marketplace->sell);
        $user = User::where('id', '=', Session::get('login_id'))->first();
        $dict_seeding_count = json_decode($user['dict_seeding_count']);

        if (intval($sell->coin) > 0) {
            User::where('id', '=', Session::get('login_id'))->update(['coins' => $user['coins'] + intval($sell->coin)]);
        }
        if (intval($sell->wheat) > 0) {
            $dict_seeding_count->wheat = $dict_seeding_count->wheat + intval($sell->wheat);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->tomato) > 0) {
            $dict_seeding_count->tomato = $dict_seeding_count->tomato + intval($sell->tomato);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->carrot) > 0) {
            $dict_seeding_count->carrot = $dict_seeding_count->carrot + intval($sell->carrot);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->corn) > 0) {
            $dict_seeding_count->corn = $dict_seeding_count->corn + intval($sell->corn);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->milk) > 0) {
            $dict_seeding_count->milk = $dict_seeding_count->milk + intval($sell->milk);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        if (intval($sell->egg) > 0) {
            $dict_seeding_count->egg = $dict_seeding_count->egg + intval($sell->egg);
            User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
        }
        //---
        if (intval($for->coin) > 0) {
            if ($user['coins'] >= intval($for->coin)) {
                User::where('id', '=', Session::get('login_id'))->update(['coins' => $user['coins'] - intval($for->coin)]);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
            }
        }
        if (intval($for->wheat) > 0) {
            if ($dict_seeding_count->wheat >= intval($for->wheat)) {
                $dict_seeding_count->wheat = $dict_seeding_count->wheat - intval($for->wheat);
                User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
            }
        }
        if (intval($for->tomato) > 0) {
            if ($dict_seeding_count->tomato >= intval($for->tomato)) {
                $dict_seeding_count->tomato = $dict_seeding_count->tomato - intval($for->tomato);
                User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
            }
        }
        if (intval($for->carrot) > 0) {
            if ($dict_seeding_count->carrot >= intval($for->carrot)) {
                $dict_seeding_count->carrot = $dict_seeding_count->carrot - intval($for->carrot);
                User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
            }
        }
        if (intval($for->corn) > 0) {
            if ($dict_seeding_count->corn >= intval($for->corn)) {
                $dict_seeding_count->corn = $dict_seeding_count->corn - intval($for->corn);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
                User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
            }
        }
        if (intval($for->milk) > 0) {
            if ($dict_seeding_count->milk >= intval($for->milk)) {
                $dict_seeding_count->milk = $dict_seeding_count->milk - intval($for->milk);
                User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
            }
        }
        if (intval($for->egg) > 0) {
            if ($dict_seeding_count->egg >= intval($for->egg)) {
                $dict_seeding_count->egg = $dict_seeding_count->egg - intval($for->egg);
                User::where('id', '=', Session::get('login_id'))->update(['dict_seeding_count' => json_encode($dict_seeding_count)]);
                User::where('id', '=', $marketplace->user_id)->update(['coins' => $user['coins'] - intval($for->coin)]);
            }
        }
        Marketplace::where('id', '=', $id)->delete();
        return redirect('marketplace')->with('success', 'You have successfully accepted!');
    }
}
