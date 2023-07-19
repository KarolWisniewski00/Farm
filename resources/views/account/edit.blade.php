@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            @if (isset($admin))
            <form class="form text-center w-100 bg-white rounded p-5" action="{{route('edit-admin')}}" method="POST">
            @else
            <form class="form text-center w-100 bg-white rounded p-5" action="{{route('account-edit-user')}}" method="POST">
            @endif
                <input type="hidden" value="{{$user->id}}" name="id">
                <!--TOKEN-->
                @csrf
                <h1 class="h3 mb-3 fw-normal">Edit account</h1>

                <div class="form-floating my-3">
                    <input type="email" class="form-control" id="floating_email" value="{{$user->email}}" name="email">
                    <label for="floating_email">Email</label>
                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                </div>

                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_nickname" value="{{$user->nickname}}" name="nickname">
                    <label for="floating_nickname">Nickname</label>
                    <span class="text-danger">@error('nickname') {{$message}} @enderror</span>
                </div>
                @if (isset($admin))
                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_name" name="name"value="{{$user->name}}">
                    <label for="floating_name">Name</label>
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>
                <div class="form-floating my-3">
                    <input type="text" class="form-control" id="floating_surname" name="surname"value="{{$user->surname}}">
                    <label for="floating_surname">Surname</label>
                    <span class="text-danger">@error('surname') {{$message}} @enderror</span>
                </div>
                @else
                <div class="form-floating my-3">
                    <input type="password" class="form-control" id="floating_password" name="password">
                    <label for="floating_password">New password - if you wanna don't change keep it empty</label>
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>
                @endif
                <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection