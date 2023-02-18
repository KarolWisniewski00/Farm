@extends('layouts.main')
@section('content')

<div class="container">
    <div class="row">
        <!--LOGIN-->
        <div class="col-12 my-5">
            <form class="form text-center w-100 bg-white p-5 rounded" action="{{route('forget-mail')}}" method="POST">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Forget password</h1>

                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="floating_email_login" value="{{old('email_login')}}" name="email" required>
                    <label for="floating_email_login">Email</label>
                    <span class="text-danger">@error('email_login') {{$message}} @enderror</span>
                </div>

                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Reset password</button>
            </form>
        </div>
    </div>
</div>
@endsection