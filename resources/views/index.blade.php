@extends('layouts.main')
@section('content')

<div class="container">
    <div class="row">
        <!--ALERTY-->
        @if(Session::has('success'))
        <div><div class="alert alert-succes">{{Session::get('success')}}</div></div>
        @endif

        @if(Session::has('fail'))
        <div><div class="alert alert-danger">{{Session::get('fail')}}</div></div>
        @endif
        <div class="col-6">
            <form class="form text-center w-100 bg-white bg-white p-5 rounded" action="{{route('register-user')}}" method="POST">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Rejestracja</h1>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_name" value="{{old('name')}}" name="name" required>
                    <label for="floating_name">Imię</label>
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_surname" value="{{old('surname')}}" name="surname" required>
                    <label for="floating_surname">Nazwisko</label>
                    <span class="text-danger">@error('surname') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="floating_email" value="{{old('email')}}" name="email" required>
                    <label for="floating_email">Email</label>
                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="floating_password" name="password" required>
                    <label for="floating_password">Hasło</label>
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Zarejestruj</button>
            </form>
        </div>
        <div class="col-6">
            <form class="form text-center w-100 bg-white p-5 rounded" action="{{route('login-user')}}" method="POST">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Logowanie</h1>

                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="floating_email_login" value="{{old('email_login')}}" name="email_login" required>
                    <label for="floating_email_login">Email</label>
                    <span class="text-danger">@error('email_login') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="floating_password_login" name="password_login" required>
                    <label for="floating_password_login">Hasło</label>
                    <span class="text-danger">@error('password_login') {{$message}} @enderror</span>
                </div>

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Zaloguj</button>
            </form>
        </div>
    </div>
</div>
@endsection