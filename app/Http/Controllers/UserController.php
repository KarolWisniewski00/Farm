<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
        /*LOGOWANIE FUNKCJONALNOŚĆ*/
        public function login_user(Request $request){   //Request - przyjęcie danych z formularza
            $request->validate([                        //walidacja
                'email_login' => 'required|email',                  //sprawdzenie czy login został podany
                'password_login' => 'required|min:8'          //sprawdzenie czy hasło zostało podane oraz czy posiada minimalną liczbę znaków
            ]);
    
            $user = User::where('email', '=',$request->email_login)->first();             //jeśli wszystko się zgadza znajdź dane w bazie
    
            if($user){                                                              //jeśli użytkownik istnieje
                if(Hash::check($request->password_login, $user->password)){               //sprawdź czy hasła pasują
                    $request->session()->put('login_id',$user->id);                 //ustaw zmienną sesyjną
                    if ($user->admin==true){                                        //jeśli użytkownik jest adminem
                        $request->session()->put('admin',$user->admin);             //ustaw dodatkową zmienną sesyjną
                    }
                    return redirect('/game');                                       //jeśli wszystko ok to zwróć widok
                }else{
                    return back()->with('fail', 'Hasła nie pasują do siebie!');     //jeśli hasła do siebie nie pasują zwróć komunikat
                }
            }else{
                return back()->with('fail', 'Nie ma takiego użytkownika!');         //jeśli nie ma użytkownika zwróć komunikat
            }
        }
    
        /*REJESTRACJA FUNKCJONALOŚĆ*/
        public function register_user(Request $request){    //Request - przyjęcie danych z formularza
            $request->validate([                            //walidacja
                'name' => 'required',                       //sprawdzenie czy imię jest podane
                'surname' => 'required',                    //sprawdzenie czy nazwisko jest podane
                'email' => 'required|email|unique:users',   //sprawdzenie czy email jest podany, czy format to email oraz czy jest unikalny
                'password' => 'required|min:8'              //sprawdzenie czy hasło jest podane oraz czy posiada minimalna liczbe znaków
            ]);
    
            $user = new User();                                 //utwórz nowy obiekt korzystając z klasy User (model)
            $user->name = $request->name;                       //zapisz imię
            $user->surname = $request->surname;                 //zapisz nazwisko
            $user->email = $request->email;                     //zapisz email
            $user->password = Hash::make($request->password);   //zapisz zaszyfrowane hasło korzystając z wbudowanej (w Laravel) metody make z klasy Hash
            $user->admin = false;                               //zapisz brak admina
            $user->map_data = json_encode($this->map_default);
            $user->coins = $this->coins_default;
            $user->missions = json_encode($this->missions_default);
            $user->dict_seeding_count = json_encode($this->dict_seeding_count_default);
            $res = $user->save();                               //ZAPISZ REKORD W BAZIE DANYCH
    
            if ($res) {
                return redirect('/')->with('success', 'Zarejestrowałeś się z powodzeniem!');    //jeśli wszystko jest ok wróć z komunikatem
            } else {
                return back()->with('fail', 'Coś poszło nie tak!');                                 //jeśli coś poszło nie tak wróć z komunikatem
            }
        }
    
        /*WYLOGOWANIE FUNKCJONALNOŚĆ*/
        public function logout(){
            if (Session::has('login_id')){  //sprawdź czy zmienna sesyjna jest ustawiona
                Session::pull('login_id');  //jeśli tak to usuń zmienną sesyjną
                Session::pull('admin');
                return redirect('/');       //zwróć ścieżkę
            }
        }
}
