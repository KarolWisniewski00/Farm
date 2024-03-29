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
        <div class="col-12 col-md-2 mb-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action active" aria-current="true">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action">Characters</a>
                @if(Session::has('admin'))<a href="{{ route('admin')}}" class="list-group-item list-group-item-action">Admin</a>@endif
                <a href="{{ route('marketplace')}}" class="list-group-item list-group-item-action" aria-current="true">Marketplace</a>
            </div>
        </div>
        @elseif ($page == 1)
        <div class="col-12 col-md-2 mb-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action active" aria-current="true">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action">Characters</a>
                @if(Session::has('admin'))<a href="{{ route('admin')}}" class="list-group-item list-group-item-action">Admin</a>@endif
                <a href="{{ route('marketplace')}}" class="list-group-item list-group-item-action" aria-current="true">Marketplace</a>
            </div>
        </div>
        @elseif ($page == 2)
        <div class="col-12 col-md-2 mb-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action active" aria-current="true">Characters</a>
                @if(Session::has('admin'))<a href="{{ route('admin')}}" class="list-group-item list-group-item-action">Admin</a>@endif
                <a href="{{ route('marketplace')}}" class="list-group-item list-group-item-action" aria-current="true">Marketplace</a>
            </div>
        </div>
        @elseif ($page == 3)
        <div class="col-12 col-md-2 mb-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action" aria-current="true">Characters</a>
                @if(Session::has('admin'))<a href="{{ route('admin')}}" class="list-group-item list-group-item-action active">Admin</a>@endif
                <a href="{{ route('marketplace')}}" class="list-group-item list-group-item-action" aria-current="true">Marketplace</a>
            </div>
        </div>
        @elseif ($page == 4)
        <div class="col-12 col-md-2 mb-5">
            <div class="list-group text-break">
                <a href="{{ route('account')}}" class="list-group-item list-group-item-action">Account</a>
                <a href="{{ route('friends')}}" class="list-group-item list-group-item-action">Friends</a>
                <a href="{{ route('characters')}}" class="list-group-item list-group-item-action" aria-current="true">Characters</a>
                @if(Session::has('admin'))<a href="{{ route('admin')}}" class="list-group-item list-group-item-action">Admin</a>@endif
                <a href="{{ route('marketplace')}}" class="list-group-item list-group-item-action active" aria-current="true">Marketplace</a>
            </div>
        </div>
        @endif
        <!--SIDE ON THE RIGHT-->
        @if ($page == 0)
        <div class="col-12 col-md-10">
            <ol class="list-group list-group text-break">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Name</div>
                        {{$user->name}}
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
                        <div class="fw-bold">Nickname</div>
                        {{$user->nickname}}
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
        <div class="col-12 col-md-10">
            <div class="bg-white rounded p-3">
                <h1>Invitation:</h1>
                <form class="form-floating" method="POST" action="{{route('friend-add')}}">
                    @csrf
                    <input type="text" class="form-control" id="floatingInput" placeholder="Nickname" name="nickname">
                    <label for="floatingInput">Nickname</label>
                    <button class="btn btn-primary my-2" type="submit">Add</button>
                </form>
                <hr>
                <h1>Pending:</h1>
                <ol class="list-group list-group text-break mb-3">
                    @foreach($pending as $p)
                    <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                        <div class="fw-bold mx-1">{{$users[$p->user_id-1]->nickname}}</div>
                        <form method="POST" action="{{ route('friend-update') }}">
                            @csrf
                            <input type="hidden" name="friend" value="{{$p->user_id}}">
                            <button type="submit" name="status" value="accept" class="btn btn-primary">Accept</button>
                            <button type="submit" name="status" value="reject" class="btn btn-danger">Reject</button>
                        </form>
                    </li>
                    @endforeach
                </ol>
                <hr>
                <h1>Friends:</h1>
                <ol class="list-group list-group text-break mb-3">
                    @foreach($accepted as $a)
                    <li class="list-group-item d-flex flex-row justify-content-between align-items-center">
                        @if($a->user_id == Session::get('login_id'))
                        @foreach ($users as $user)
                        @if ($user->id == $a->friend_id)
                        <div class="fw-bold mx-1">{{$user->nickname}}</div>
                        @endif
                        @endforeach
                        <form method="POST" action="{{ route('friend-update') }}">
                            @csrf
                            <input type="hidden" name="user" value="{{$a->user_id}}">
                            <input type="hidden" name="friend" value="{{$a->friend_id}}">
                            <a href="game-{{$a->friend_id}}" class="btn btn-primary">View farm</a>
                            <button type="submit" name="status" value="delete" class="btn btn-danger">Delete</button>
                        </form>
                        @else

                        @foreach ($users as $user)
                        @if ($user->id == $a->user_id)
                        <div class="fw-bold mx-1">{{$user->nickname}}</div>
                        @endif
                        @endforeach
                        <form method="POST" action="{{ route('friend-update') }}">
                            @csrf
                            <input type="hidden" name="user" value="{{$a->user_id}}">
                            <input type="hidden" name="friend" value="{{$a->friend_id}}">
                            <a href="game-{{$a->user_id}}" class="btn btn-primary">View farm</a>
                            <button type="submit" name="status" value="delete" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
        @elseif ($page == 2)
        <div class="col-12 col-md-10">
            <div class="text-center bg-white rounded">
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
        @elseif ($page == 3)
        <div class="col-12 col-md-10">
            <div class="text-center bg-white rounded">
                <h1>Users</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="word-break: break-all;">Name</th>
                            <th scope="col" style="word-break: break-all;">Surname</th>
                            <th scope="col" style="word-break: break-all;">Email</th>
                            <th scope="col" style="word-break: break-all;">Nickname</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="word-break: break-all;">{{$user->name}}</td>
                            <td style="word-break: break-all;">{{$user->surname}}</td>
                            <td style="word-break: break-all;">{{$user->email}}</td>
                            <td style="word-break: break-all;">{{$user->nickname}}</td>
                            <td><a href="edit-{{$user->id}}" class="btn btn-primary">Edit</a></td>
                            <td><a href="delete-{{$user->id}}" class="btn btn-danger">Delete</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @elseif ($page == 4)
        <div class="col-12 col-md-10">
            <div class="text-center bg-white rounded">
                <h1>Add new</h1>
                <form method="POST" action="{{route('marketplace-add')}}">
                    @csrf
                    <ol class="list-group list-group text-break mb-3">
                        <div class="list-group-item list-group-item-action bg-transparent border-1 rounded-0 border-white text-white d-flex flex-column justify-content-between">
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-column w-100 text-center text-black">
                                    <h5 class="mb-1">Sell:</h5>
                                    <div class="w-100">
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>wheat</div><img src="images/wheat-icon.png" class="img-fluid max-height-64" alt="wheat-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_wheat">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>tomato</div><img src="images/tomato-icon.png" class="img-fluid max-height-64" alt="tomato-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_tomato">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>carrot</div><img src="images/carrot-icon.png" class="img-fluid max-height-64" alt="carrot-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_carrot">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>corn</div><img src="images/corn-icon.png" class="img-fluid max-height-64" alt="corn-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_corn">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>milk</div><img src="images/milk-icon.png" class="img-fluid max-height-64" alt="milk-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_milk">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>egg</div><img src="images/egg-icon.png" class="img-fluid max-height-64" alt="egg-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_egg">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>coin</div><img src="images/coin-icon.png" class="img-fluid max-height-64" alt="coin-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="sell_coin">
                                                </div>
                                            </div>
                                        </buttom>
                                    </div>
                                </div>
                                <div class="d-flex flex-column w-100 text-center text-black">
                                    <h5 class="mb-1">For:</h5>
                                    <div class="w-100">
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>wheat</div><img src="images/wheat-icon.png" class="img-fluid max-height-64" alt="wheat-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_wheat">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>tomato</div><img src="images/tomato-icon.png" class="img-fluid max-height-64" alt="tomato-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_tomato">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>carrot</div><img src="images/carrot-icon.png" class="img-fluid max-height-64" alt="carrot-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_carrot">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>corn</div><img src="images/corn-icon.png" class="img-fluid max-height-64" alt="corn-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_corn">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>milk</div><img src="images/milk-icon.png" class="img-fluid max-height-64" alt="milk-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_milk">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>egg</div><img src="images/egg-icon.png" class="img-fluid max-height-64" alt="egg-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_egg">
                                                </div>
                                            </div>
                                        </buttom>
                                        <buttom class="btn btn-outline-light p-2 m-2 text-black">
                                            <div>coin</div><img src="images/coin-icon.png" class="img-fluid max-height-64" alt="coin-icon">
                                            <div>
                                                <div class="form-group">
                                                    <label for="example-number-input">Choose a number</label>
                                                    <input class="form-control" type="number" id="example-number-input" name="for_coin">
                                                </div>
                                            </div>
                                        </buttom>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column text-center w-100">
                                <div><button class="btn btn-primary" type="submit">Put up for sale!</button></div>
                            </div>
                        </div>
                    </ol>
                </form>
                <hr>
                <h1>Marketplace</h1>
                <ol class="list-group list-group text-break pb-3">
                    <div class="list-group-item list-group-item-action bg-transparent border-1 rounded-0 border-white text-white d-flex flex-column justify-content-between">
                        @foreach($marketplace as $m)
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-column w-100 text-center text-black">
                                <h5 class="mb-1">Sell:</h5>
                                <div class="w-100">
                                    @foreach($m['sell'] as $key => $value)
                                    @if($value>0)
                                    <buttom class="btn btn-outline-dark p-2 m-2">
                                        <div></div><img src="images/{{$key}}-icon.png" class="img-fluid max-height-64" alt="{{$key}}-icon">
                                        <div>x{{$value}}</div>
                                    </buttom>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="d-flex flex-column w-100 text-center text-black">
                                <h5 class="mb-1">For:</h5>
                                <div class="w-100">
                                    @foreach($m['for'] as $key => $value)
                                    @if($value>0)
                                    <buttom class="btn btn-outline-dark p-2 m-2">
                                        <div></div><img src="images/{{$key}}-icon.png" class="img-fluid max-height-64" alt="{{$key}}-icon">
                                        <div>x{{$value}}</div>
                                    </buttom>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if($m['user_id']==Session::get('login_id'))
                        <div class="d-flex flex-column text-center w-100">
                            <div><a href="marketplace-cancel-{{$m['id']}}" class="btn btn-danger" type="submit">Cancel!</a></div>
                        </div>
                        @else
                        <div class="d-flex flex-column text-center w-100 my-2">
                            <div><a href="marketplace-accept-{{$m['id']}}" class="btn btn-primary" type="submit">Accept!</a></div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </ol>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection