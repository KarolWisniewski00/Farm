@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div><a href="{{ route('game')}}" class="btn btn-primary my-3">Back to game</a></div>
        <!--ALERTY-->
        @if(Session::has('success'))
        <div>
            <div class="alert alert-success">{{Session::get('success')}}</div>
        </div>
        @endif

        @if(Session::has('fail'))
        <div>
            <div class="alert alert-danger">{{Session::get('fail')}}</div>
        </div>
        @endif
        <!--SIDE ON THE LEFT-->
        @if ($page == 0)
        <div class="col-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action active" aria-current="true">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action">Characters</a>
            </div>
        </div>
        @elseif ($page == 1)
        <div class="col-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action active" aria-current="true">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action">Characters</a>
            </div>
        </div>
        @elseif ($page == 2)
        <div class="col-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action active" aria-current="true">Characters</a>
            </div>
        </div>
        @endif
        <!--SIDE ON THE RIGHT-->
        @if ($page == 0)
        <div class="col-7">
            <ol class="list-group list-group text-break">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Name</div>
                        {{$user->name}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nickname</div>
                        {{$user->nickname}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Surname</div>
                        {{$user->surname}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Email</div>
                        {{$user->email}}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Password</div>
                        ********
                    </div>
                </li>
            </ol>
            <div class="text-center mt-3">
                <a href="{{ route('account-edit')}}" class="btn btn-outline-light p-2 m-2" id="edit-icon">
                    <img src="images/edit-icon.png" class="img-fluid max-height-64" alt="edit-icon">
                    <div>Edit account</div>
                </a>
                <a href="{{url('logout')}}" class="btn btn-outline-light p-2 m-2" id="logout-icon">
                    <img src="images/logout-icon.png" class="img-fluid max-height-64" alt="logout-icon">
                    <div>Logout</div>
                </a>
                <a href="{{url('account-delete')}}" class="btn btn-outline-danger p-2 m-2" id="delete-icon">
                    <img src="images/delete-icon.png" class="img-fluid max-height-64" alt="delete-icon">
                    <div>Delete account</div>
                </a>
            </div>
        </div>
        @elseif ($page == 1)
        @elseif ($page == 2)
        <div class="col-7 bg-white rounded">
            <div class="text-center mt-3">
                <h1>Characters</h1>
                <!--CHARACTER 0-->
                @if ($user->character == 0)
                <a href="{{url('character-0')}}" class="btn btn-outline-dark p-2 m-2 active">
                    <img src="images/character.png" class="img-fluid max-height-64" alt="character">
                    <div>Default</div>
                </a>
                @else
                <a href="{{url('character-0')}}" class="btn btn-outline-dark p-2 m-2">
                    <img src="images/character.png" class="img-fluid max-height-64" alt="character">
                    <div>Default</div>
                </a>
                @endif
                <!--CHARACTER 1-->
                @if ($user->character == 1)
                <a href="{{url('character-1')}}" class="btn btn-outline-dark p-2 m-2 active">
                    <img src="images/male.png" class="img-fluid max-height-64" alt="male">
                    <div>Male</div>
                </a>
                @else
                <a href="{{url('character-1')}}" class="btn btn-outline-dark p-2 m-2">
                    <img src="images/male.png" class="img-fluid max-height-64" alt="male">
                    <div>Male</div>
                </a>
                @endif
                <!--CHARACTER 2-->
                @if ($user->character == 2)
                <a href="{{url('character-2')}}" class="btn btn-outline-dark p-2 m-2 active">
                    <img src="images/female.png" class="img-fluid max-height-64" alt="female">
                    <div>Female</div>
                </a>
                @else
                <a href="{{url('character-2')}}" class="btn btn-outline-dark p-2 m-2">
                    <img src="images/female.png" class="img-fluid max-height-64" alt="female">
                    <div>Female</div>
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection