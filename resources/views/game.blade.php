<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Farm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body id="bg" class="min-vh-100 min-vw-100 d-flex justify-content-center align-items-center">
    <!--TOP NAV-->
    <nav class="navbar fixed-top navbar-dark p-0" id="navtop">
        <!--MAIN-->
        <div class="container-fluid w-100 bg-dark">
            <div class="d-flex justify-content-between w-100">
                <div class="navbar-brand d-flex justify-content-between align-items-center m-0">
                    <buttom class="btn btn-outline-light p-2 m-2" id="seeding"><img src="images/seeding.png"
                            class="img-fluid max-height-64" alt="seeding"></buttom>
                    <buttom class="btn btn-outline-light p-2 m-2" id="mission"><img src="images/target.png"
                            class="img-fluid max-height-64" alt="target"></buttom>
                    <buttom class="btn btn-outline-light p-2 m-2" id="change-type" onclick="changeGameMode()"><img
                            src="images/exchange.png" class="img-fluid max-height-64" alt="change-type-icon"></buttom>
                    <buttom class="btn btn-outline-light p-2 m-2" id="setting"><img
                            src="images/settings-icon.png" class="img-fluid max-height-64" alt="settings"></buttom>
                </div>
                <div class="navbar-brand d-flex justify-content-center align-items-center m-0">
                    <img src="images/coin-icon.png" alt="coin-icon" width="64" height="64">
                    <span id="coins" class="mx-2"></span>
                </div>
            </div>
        </div>
    </nav>
    <!--WINDOW SEEDING-->
    <div class="position-absolute w-auto mx-3 p-3 bg-dark bg-opacity-50 text-bg-dark overflow-auto d-flex flex-column align-items-center px-5 shadow window"
        id="window-seeding">
        <div class="w-100 text-center my-3">
            <h2>Seeding</h2>
        </div>
        <div class="container">
            <div class="row" id="seedings">
                <!--Generate by JS-->
            </div>
        </div>
    </div>
    <!--WINDOW MISSION-->
    <div class="position-absolute w-auto mx-3 p-3 bg-dark bg-opacity-50 text-bg-dark overflow-auto d-flex flex-column align-items-center px-5 shadow window"
        id="window-mission">
        <div class="w-100 text-center my-3">
            <h2>Missions</h2>
        </div>
        <div class="list-group mb-5" id="missions">
            <!--Generate by JS-->
        </div>
    </div>
    <!--WINDOW SETTINGS-->
    <div class="position-absolute w-auto mx-3 p-3 bg-dark bg-opacity-50 text-bg-dark overflow-auto d-flex flex-column align-items-center px-5 shadow window"
        id="window-settings">
        <div class="w-100 text-center my-3">
            <h2>Settings</h2>
        </div>
        <div class="container">
            <div class="row" id="seedings">
                <div class="col d-flex justify-content-center align-items-center">
                    <buttom class="btn btn-outline-light p-2 m-2" id="save-icon"
                        onclick="save()">
                        <img src="images/save-icon.png" class="img-fluid max-height-64"
                            alt="save-icon">
                        <div>Save</div>
                    </buttom>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                    <a href="{{url('account')}}" class="btn btn-outline-light p-2 m-2" id="user-icon">
                        <img src="images/user-icon.png" class="img-fluid max-height-64"
                            alt="user-icon">
                        <div>Account</div>
                    </a>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                    <a href="{{url('logout')}}" class="btn btn-outline-light p-2 m-2" id="logout-icon">
                        <img src="images/logout-icon.png" class="img-fluid max-height-64"
                            alt="logout-icon">
                        <div>Logout</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--BOTTOM NAV-->
    <nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark" id="navbot">
        <div class="container-fluid">
            <div class="d-flex justify-content-between w-100">
                <buttom class="btn btn-outline-light p-2 m-2" id="shovel" style="display: block;" onclick="save()"><img
                        src="images/shovel.png" class="img-fluid max-height-64" alt="shovel" style="display: block;">
                </buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="plant" style="display: block;" onclick="save()"><img
                        src="images/plant.png" alt="plant" class="img-fluid max-height-64"></buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="watering-can" style="display: block;" onclick="save()"><img
                        src="images/watering-can.png" alt="watering-can" class="img-fluid max-height-64"></buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="scythe" style="display: block;" onclick="save()"><img
                        src="images/scythe.png" alt="scythe" class="img-fluid max-height-64"></buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="grass" style="display: none;" onclick="save()"><img
                        src="images/grass-icon.png" alt="grass" class="img-fluid max-height-64"></buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="tree" style="display: none;" onclick="save()"><img
                        src="images/tree-icon.png" alt="tree" class="img-fluid max-height-64"></buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="rock" style="display: none;" onclick="save()"><img
                        src="images/rock-icon.png" alt="rock" class="img-fluid max-height-64"></buttom>
                <buttom class="btn btn-outline-light p-2 m-2" id="water" style="display: none;" onclick="save()"><img
                        src="images/water-icon.png" alt="water" class="img-fluid max-height-64"></buttom>
            </div>
        </div>
    </nav>
    <!--Lib-->
    <script src="library/jquery-3.6.3.min.js"></script>
    <script src="library/phaser.min.js"></script>
    <script src="library/phaser-plugin-isometric.min.js"></script>
    <script src="library/phaser-touch-control.js"></script>
    
    <!--Game-->
    <!--
        In some code editor that code below its with red underline like an error
        It's okey, it's also importart to comunication between backend and frontend
    -->
    <script>
        //PASS THE VARIABLE FROM BACKEND TO FRONTEND
        var map = {!! json_encode($map) !!};
        var coins = {!! json_encode($coins) !!};
        var missions = {!! json_encode($missions) !!};
        var dictSeedingCount = {!! json_encode($dict_seeding_count) !!};
    </script>
    <script src="js/game.js"></script>
    <script src="js/interface.js"></script>
</body>

</html>
<!--
    https://www.flaticon.com/search?word=carrot
    https://www.flaticon.com/search?word=watering%20can
    https://www.flaticon.com/search?word=scythe
    https://www.flaticon.com/search?word=coin
    https://www.flaticon.com/search?word=plant
    https://www.flaticon.com/search?word=planting
    https://www.flaticon.com/search?word=mission
    https://www.flaticon.com/search?word=wheat
    https://www.flaticon.com/search?word=tomato
    https://www.flaticon.com/search?word=change
    https://www.flaticon.com/search?word=buy
    https://www.flaticon.com/search?word=account
    https://www.flaticon.com/search?word=logout
    https://www.flaticon.com/search?word=save
    https://www.flaticon.com/search?word=settings
-->