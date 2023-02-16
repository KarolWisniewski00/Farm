//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//CONFIG GAME
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
var navTopHeight = document.getElementById("navtop").offsetHeight;          //Get height navbar top
var navBotHeight = document.getElementById("navbot").offsetHeight;          //Get height navbar bottom
var width = window.innerWidth * 0.85;                                       //Set up width of canvas
var height = (window.innerHeight * 0.9) - navTopHeight - navBotHeight;      //Set up heigh of canvas
if (height > 720) { height = 720 };                                         //Add center at screen +/- md nad more

var game = new Phaser.Game({                                                //Config game engine - Library
    width: width,
    height: height,
    type: Phaser.AUTO,
    parent: 'farm',
    transparent: true,
    antialias: false,
});

var BasicGame = function (game) { };
BasicGame.Boot = function (game) { };

//CONST THAT WILL BE NOT CHANGE IN PROGRESS
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
const dictPlatform = {
    grass: 0,
    noGrass: 1,
    wateringNoGrass: 2,
    water: 3,
};
const dictPlatformSecond = {
    null: 0,
    tree: 1,
    rock: 2,
    wheat: 3,
    shoot: 4,
    tomato: 5,
    transparent: 6,
    carrot: 7,
};
const dictKind = {
    null: 0,
    wheat: 1,
    tomato: 2,
    carrot: 4,
};
const dictColor = {
    normal: '#a7aebe',
    blue: '#0096FF',
    green: '#00ff00',
    yellow: '#ffff00',
    brown: '#CD7F32',
    red: '#ff0000',
    white: '#ffffff',
    orange: '#FFA500',
};
const dictSeedingTime = {
    tomato: 2,
    wheat: 1,
    carrot: 5,
};
const dictCharacter = {
    default: 0,
    male: 1,
    female: 2,
}
const size = 35.8;
const speed = 200;
const digCost = 10;
const plantCost = 5;
const wateringCost = 5;
const cropsRevenue = 30;
const characterStartX = 10;
const characterStartY = 10;
const infoY = 16;
const infoX = 2;
const walls = 100;
const editorCost = 100;

//VARIABLES THAT WILL BE CHANGE IN PROGRESS
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
var platformInfo = null;
var platformSecondInfo = null;
var lastX = null;
var lastY = null;
var gameMode = false;
var kindSeeding = dictKind.null;

var platformSecondInfoColor = dictColor.normal;
var platformInfoColor = dictColor.normal;
var kindSeedingInfoColor = dictColor.normal;
var kindGrowingInfoColor = dictColor.normal;
var timeLeftColor = dictColor.normal;
var isoGroup, cursorPos, cursor, timeLeft, count;
BasicGame.Boot.prototype =
{
    //INSIDE CREATE FUNCTIONS
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //This is a function to add the object in the map that player can move on
    gameAdd: function (yy, xx, kind, group, asx, asy, wet = false) {    //Add block - player move on
        obj = game.add.isoSprite(yy, xx, 0, kind, 0, group);            //add sprite
        obj.anchor.set(asx, asy);                                       //set anchor
        if (wet == true) {                                              //in case WateringNoGrass
            obj.tint = 0x86bfda;                                        //change color
        }
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //This is a function to add the object in the map that player can not move on
    gameAddWall: function (yy, xx, kind, group, asx, asy) {             //Add block - player move off
        obj = game.add.isoSprite(yy, xx, 0, kind, 0, group);            //add sprite
        obj.anchor.set(asx, asy);                                       //set anchor
        game.physics.isoArcade.enable(obj);                             //turn on physics
        obj.body.collideWorldBounds = true;                             //turn on collide
        obj.body.immovable = true;                                      //turn off move
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //This is a function that spawn platform - ground
    spawnTilesPlatform: function () {
        //LOOP TABLE
        for (var i = 0; i < map[0].length * map.length; i++) {
            var yy = Math.floor(i / map[0].length) * size;
            var xx = (i % map[0].length) * size;

            //LOGIC
            switch (map[parseInt(xx / size)][parseInt(yy / size)].platform) {
                case dictPlatform.grass: this.gameAdd(yy, xx, 'grass', isoGroupPlatform, 0.5, 0); break;
                case dictPlatform.noGrass: this.gameAdd(yy, xx, 'nograss', isoGroupPlatform, 0.5, 0); break;
                case dictPlatform.wateringNoGrass: this.gameAdd(yy, xx, 'nograss', isoGroupPlatform, 0.5, 0, true); break;
                case dictPlatform.water: this.gameAdd(yy, xx, 'water', isoGroupPlatform, 0.5, 0, true); break;
            };
        };
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //This is a function that spawn platform second - walls and plants
    spawnTilesPlatformSecond: function () {
        //LOOP TABLE
        for (var i = 0; i < map[0].length * map.length; i++) {
            var yy = Math.floor(i / map[0].length) * size;
            var xx = (i % map[0].length) * size;

            //LOGIC
            switch (map[parseInt(xx / size)][parseInt(yy / size)].platformSecond) {
                case dictPlatformSecond.tree: this.gameAddWall(yy, xx, 'tree', isoGroupPlatformSecond, 0.5); break;
                case dictPlatformSecond.rock: this.gameAddWall(yy, xx, 'rock', isoGroupPlatformSecond, 0.5); break;
                case dictPlatformSecond.transparent: this.gameAddWall(yy, xx, 'transparent', isoGroupPlatformSecond, 0.5); break;
                case dictPlatformSecond.wheat: this.gameAdd(yy, xx, 'wheat', isoGroupPlatformSecond, 0.5); break;
                case dictPlatformSecond.shoot: this.gameAdd(yy, xx, 'shoot', isoGroupPlatformSecond, 0.5); break;
                case dictPlatformSecond.tomato: this.gameAdd(yy, xx, 'tomato', isoGroupPlatformSecond, 0.5); break;
                case dictPlatformSecond.carrot: this.gameAdd(yy, xx, 'carrot', isoGroupPlatformSecond, 0.5); break;
            };
        };
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //PRELOAD
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //This is a function to load all assets and confing the game
    preload: function () {
        //LOAD IMAGES
        game.load.image('grass', 'images/grass.png');
        game.load.image('nograss', 'images/nograss.png');
        switch (characterKind) {
            case dictCharacter.default: game.load.image('character', 'images/character.png'); break;
            case dictCharacter.male: game.load.image('character', 'images/male.png'); break;
            case dictCharacter.female: game.load.image('character', 'images/female.png'); break;
        };
        game.load.image('tree', 'images/tree.png');
        game.load.image('wheat', 'images/wheat.png');
        game.load.image('tomato', 'images/tomato.png');
        game.load.image('shoot', 'images/shoot.png');
        game.load.image('rock', 'images/rock.png');
        game.load.image('water', 'images/water.png');
        game.load.image('transparent', 'images/transparent.png');
        game.load.image('carrot', 'images/carrot.png');
        game.load.image('compass', 'images/compass_rose.png');
        game.load.image('touch_segment', 'images/touch_segment.png');
        game.load.image('touch', 'images/touch.png');

        //SET UP GAME       
        game.time.advancedTiming = true;                                    //set up timing
        game.plugins.add(new Phaser.Plugin.Isometric(game));                //add plugin
        game.world.setBounds(0, 0, 1496, 1024);                             //add bounds word - need to camera
        game.physics.startSystem(Phaser.Plugin.Isometric.ISOARCADE);        //add plugin physics
        game.iso.anchor.setTo(0.5, 0.0);                                    //set anchor
        game.touchControl = game.plugins.add(Phaser.Plugin.TouchControl);   //add plugin
        game.touchControl.inputEnable();                                    //turn on plugin

        //LAYOUT SET UP COINS
        document.getElementById("coins").innerHTML = coins;
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //CREATE
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    create: function () {
        //This is a function to create the map and other functions in the game

        //GRAVITY
        game.physics.isoArcade.gravity.setTo(0, 0, -1000);

        //SPAWN
        isoGroupPlatform = game.add.group();                //create group
        this.spawnTilesPlatform();                          //spawn
        isoGroupPlatformSecond = game.add.group();          //create group
        this.spawnTilesPlatformSecond();                    //spawn

        //SET UP THE VIRTUAL JOYSTICK
        game.touchControl.imageGroup[0].loadTexture('compass');
        game.touchControl.imageGroup[1].loadTexture('touch_segment');
        game.touchControl.imageGroup[2].loadTexture('touch_segment');
        game.touchControl.imageGroup[3].loadTexture('touch');
        game.touchControl.imageGroup.forEach(function (e) {
            e.anchor.set(0.5);
            e.visible = false;
            e.fixedToCamera = true;
        });

        //CHARACTER
        player = game.add.isoSprite(size * characterStartX, size * characterStartY, 0, 'character', 0, isoGroupPlatformSecond); //add sprite
        player.anchor.set(0.5);                                                                                                 //set anchor
        game.physics.isoArcade.enable(player);                                                                                  //turn on physics
        player.body.collideWorldBounds = true;                                                                                  //turn on collide

        //ADD KEY TO MOVE
        this.cursors = game.input.keyboard.createCursorKeys();  //add keyboard
        this.game.input.keyboard.addKeyCapture([                //add keys
            Phaser.Keyboard.LEFT,
            Phaser.Keyboard.RIGHT,
            Phaser.Keyboard.UP,
            Phaser.Keyboard.DOWN,
        ]);

        //CAMERA MOVE
        game.camera.follow(player);

    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    //UPDATE
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    update: function () {
        //INSIDE FUNCTIONS
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //This is a function to find the tile on the map and pass the function in to "todo()" to make a action on click
        function actionOnClick(todo) {
            var counter = 0;                                                                                                        //helper variable to find coords
            isoGroupPlatform.forEach(function (tile) {                                                                              //loop for each element at platform
                var inBounds = tile.isoBounds.containsXY(player.body.position.x + (size / 2), player.body.position.y + (size / 2)); //check player in bounds
                if (!tile.selected && inBounds) {                                                                                   //if player in bounds is true and tile is false
                    tile.selected = true;                                                                                           //change state
                    y = counter % map.length                                                                                        //get coord y                                                                   
                    x = Math.floor(counter / (map.length))                                                                          //get coord x
                    todo(y, x, tile);                                                                                               //fuction to do - takes from argument
                }
                else if (tile.selected && !inBounds) {                                                                              //if player in bounds is false and tile is true
                    tile.selected = false;                                                                                          //change state
                };
                counter++;                                                                                                          //add to counter
            });
        };
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //This is a function to change the view and state of the map
        function digInside(y, x, tile, to, toDict, watering = false) {
            if (coins >= digCost) {                                     //check how many coins has player
                tile.loadTexture(to);                                   //change texture
                map[y][x].platform = toDict;                            //update map
                coins -= digCost;                                       //add coins
                document.getElementById("coins").innerHTML = coins;     //update coins
                if (watering) {                                         //in case watering
                    tile.tint = 0xffffff;                               //return color
                };
            }
        };
        //This is a function that declares changes
        function dig(y, x, tile) {
            if (map[y][x].platformSecond == dictPlatformSecond.null) {  //protection
                switch (map[y][x].platform) {
                    //CHANGE FROM GRASS TO NOGRASS
                    case dictPlatform.grass: digInside(y, x, tile, 'nograss', dictPlatform.noGrass); break;
                    //CHANGE FROM NOGRASS TO GRASS
                    case dictPlatform.noGrass: digInside(y, x, tile, 'grass', dictPlatform.grass); break;
                    //CHANGE FROM WATERINGNOGRASS TO GRASS
                    case dictPlatform.wateringNoGrass: digInside(y, x, tile, 'grass', dictPlatform.grass, true); break;
                };
            };
        };
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //This is a function to change the view and state of the map
        function plantIndide(y, x, tile, to, costGameMode = false) {
            //UPDATE KIND
            switch (kindSeeding) {
                case dictKind.tomato: count = dictSeedingCount.tomato; break;
                case dictKind.wheat: count = dictSeedingCount.wheat; break;
                case dictKind.carrot: count = dictSeedingCount.carrot; break;
            }

            //LOGIC
            if (coins >= plantCost && kindSeeding != dictKind.null && count > 0) {                      //check how many coins has player and protection before no tooken kind
                shoot = game.add.isoSprite(x * size, y * size, 0, 'shoot', 0, isoGroupPlatformSecond);  //add sprite
                shoot.anchor.set(0.5);                                                                  //set anchor

                let dateCurrent = new Date();                                                           //get current date
                let minutes;                                                                            //variable help
                switch (kindSeeding) {
                    case dictKind.tomato: minutes = Math.floor(dateCurrent / (60 * 1000) % 60) + dictSeedingTime.tomato; break;
                    case dictKind.wheat: minutes = Math.floor(dateCurrent / (60 * 1000) % 60) + dictSeedingTime.wheat; break;
                    case dictKind.carrot: minutes = Math.floor(dateCurrent / (60 * 1000) % 60) + dictSeedingTime.carrot; break;
                }
                dateCurrent.setMinutes(minutes);                                                        //update minutes

                //update map
                map[y][x].platformSecond = to;
                map[y][x].kindGrowing = kindSeeding;
                map[y][x].dateStart = dateCurrent;
                map[y][x].dateEnd = dateCurrent;

                //update other
                coins -= plantCost;
                count--;
                switch (kindSeeding) {
                    case dictKind.tomato: dictSeedingCount.tomato = count; break;
                    case dictKind.wheat: dictSeedingCount.wheat = count; break;
                    case dictKind.carrot: dictSeedingCount.carrot = count; break;
                }

                //update in layout
                document.getElementById("coins").innerHTML = coins;
            };

            if (costGameMode && coins >= editorCost) {
                switch (to) {
                    case dictPlatformSecond.tree: obj = game.add.isoSprite(x * size, y * size, 0, 'tree', 0, isoGroupPlatformSecond); break;
                    case dictPlatformSecond.rock: obj = game.add.isoSprite(x * size, y * size, 0, 'rock', 0, isoGroupPlatformSecond); break;
                    case dictPlatformSecond.transparent:
                        obj = game.add.isoSprite(x * size, y * size, 0, 'transparent', 0, isoGroupPlatformSecond);//add new sprite
                        tile.loadTexture('water');                              //load new texture
                        map[y][x].platform = dictPlatform.water;                //update map
                        tile.tint = 0x86bfda;                                   //add dark color
                        break;
                };
                obj.anchor.set(0.5);
                game.physics.isoArcade.enable(obj);                             //turn on physics
                obj.body.collideWorldBounds = true;                             //turn on collide
                obj.body.immovable = true;                                      //turn off move
                coins -= editorCost;                                            //update
                document.getElementById("coins").innerHTML = coins;             //update view
                map[y][x].platformSecond = to;                                  //update map
            };
        };

        //This is a function that declares changes
        function plant(y, x, tile) {
            if (map[y][x].platformSecond == dictPlatformSecond.null) {//protection
                switch (map[y][x].platform) {
                    case dictPlatform.noGrass: plantIndide(y, x, tile, dictPlatformSecond.shoot); break;
                    case dictPlatform.wateringNoGrass: plantIndide(y, x, tile, dictPlatformSecond.shoot); break;
                };
            };
        };
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //This is a function to change the view and state of the map
        function wateringInside(y, x, tile, toDict) {
            if (coins >= wateringCost) {                                //check how many coins has player
                tile.tint = 0x86bfda;                                   //change color
                map[y][x].platform = toDict;                            //update map
                coins -= wateringCost;                                  //add coins
                document.getElementById("coins").innerHTML = coins;     //update coins
            };
        };
        //This is a function that declares changes
        function watering(y, x, tile) {
            if ((map[y][x].platformSecond == dictPlatformSecond.null) || (map[y][x].platformSecond == dictPlatformSecond.shoot)) {
                switch (map[y][x].platform) {
                    case dictPlatform.noGrass: wateringInside(y, x, tile, dictPlatform.wateringNoGrass); break;
                };
            };
        };
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //This is a function to change the view and state of the map
        function cropsInside(y, x, tile, key, costGameMode = false) {

            //this is a logic to switch the function between crop plant and crop the objects of the map (like a wall)
            if (costGameMode && coins >= editorCost) {                                  //if game editor turn on and the coins is enough
                coins -= editorCost;                                                    //update coins
                document.getElementById("coins").innerHTML = coins;                     //update view
                change = true;                                                          //set up the variable
            } else if (costGameMode) {                                                  //if game editor turn on and the coins is not enough
                change = false;                                                         //set up the variable
            } else {                                                                    //if the editor is turn off
                change = true;                                                          //set up the variable
            };

            var counter = 0;                                                            //helper variable
            var index = 0;                                                              //index of the object from isoGroupSecond
            var diffX = 1000000;                                                        //helper variable
            var diffY = 1000000;                                                        //helper variable

            //find the most near element fast but no precision
            isoGroupPlatformSecond.forEach(function (tileSecond) {                      //loop for each element
                if (tileSecond.key == key) {                                            //do it for key(kind) of object
                    var currDiffX = Math.abs(tile.position.x - tileSecond.position.x);  //take difference x
                    var currDiffY = Math.abs(tile.position.y - tileSecond.position.y);  //take difference y
                    if (currDiffX < diffX || currDiffY < diffY) {                       //take the lower one
                        diffX = currDiffX;                                              //update helper variable
                        diffY = currDiffY;                                              //update helper variable
                        index = counter;                                                //update index
                    };
                };
                counter++;                                                              //add to counter
            });
            if (change) {
                tile.loadTexture('grass');                                              //change texture

                //update map
                switch (map[y][x].platformSecond) {
                    case dictPlatformSecond.tomato: dictSeedingCount.tomato += 2; break;
                    case dictPlatformSecond.wheat: dictSeedingCount.wheat += 2; break;
                    case dictPlatformSecond.carrot: dictSeedingCount.carrot += 2; break;
                    case dictPlatformSecond.transparent: tile.tint = 0xffffff; break;
                };
                map[y][x].platformSecond = dictPlatformSecond.null;
                map[y][x].platform = dictPlatform.grass;

                isoGroupPlatformSecond.children[index].destroy();//destroy element from gameplay
            };

        };
        //This is a function that declares changes
        function crops(y, x, tile) {
            switch (map[y][x].platformSecond) {
                case dictPlatformSecond.wheat: cropsInside(y, x, tile, 'wheat'); break;
                case dictPlatformSecond.tomato: cropsInside(y, x, tile, 'tomato'); break;
                case dictPlatformSecond.carrot: cropsInside(y, x, tile, 'carrot'); break;
            };
        };
        //This is a function that declares changes
        function grassGM(y, x, tile) {
            switch (map[y][x].platformSecond) {
                case dictPlatformSecond.tree: cropsInside(y, x, tile, 'tree', true); break;
                case dictPlatformSecond.rock: cropsInside(y, x, tile, 'rock', true); break;
                case dictPlatformSecond.transparent: cropsInside(y, x, tile, 'transparent', true); break;
            };
        };
        //This is a function that declares changes
        function treeGM(y, x, tile) {
            if (map[y][x].platformSecond == dictPlatformSecond.null) {//protection
                switch (map[y][x].platform) {
                    case dictPlatform.grass: plantIndide(y, x, tile, dictPlatformSecond.tree, true); break;
                };
            };
        };
        //This is a function that declares changes
        function rockGM(y, x, tile) {
            if (map[y][x].platformSecond == dictPlatformSecond.null) {//protection
                switch (map[y][x].platform) {
                    case dictPlatform.grass: plantIndide(y, x, tile, dictPlatformSecond.rock, true); break;
                };
            };
        };
        //This is a function that declares changes
        function waterGM(y, x, tile) {
            if (map[y][x].platformSecond == dictPlatformSecond.null) {//protection
                switch (map[y][x].platform) {
                    case dictPlatform.grass: plantIndide(y, x, tile, dictPlatformSecond.transparent, true); break;
                };
            };
        };
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //MOVE UPDATE PLAYER

        //Virtual joystick
        player.body.velocity.y = -game.touchControl.speed.y;
        player.body.velocity.x = -game.touchControl.speed.x;
        //keyboard
        if (player.body.velocity.y == 0 || player.body.velocity.x == 0) {
            player.body.velocity.y = (this.cursors.up.isDown ? -speed : (this.cursors.down.isDown ? speed : 0));            //move top down
            player.body.velocity.x = (this.cursors.left.isDown ? -speed : (this.cursors.right.isDown ? speed : 0));         //move left right
        }

        //ACTION ON CLICK THE BUTTONS ON THE LAYOUT
        if (!gameMode) {
            document.getElementById("shovel").addEventListener("click", function () { actionOnClick(dig); });               //ON CLICK SHOVEL
            document.getElementById("plant").addEventListener("click", function () { actionOnClick(plant); });              //ON CLICK PLANT
            document.getElementById("watering-can").addEventListener("click", function () { actionOnClick(watering); });    //ON CLICK WATERING-CAN
            document.getElementById("scythe").addEventListener("click", function () { actionOnClick(crops); });             //ON CLICK SCYTHE
        } else {
            document.getElementById("grass").addEventListener("click", function () { actionOnClick(grassGM); });            //ON CLICK GRASS
            document.getElementById("tree").addEventListener("click", function () { actionOnClick(treeGM); });              //ON CLICK TREE
            document.getElementById("rock").addEventListener("click", function () { actionOnClick(rockGM); });              //ON CLICK ROCK
            document.getElementById("water").addEventListener("click", function () { actionOnClick(waterGM); });            //ON CLICK WATER
        };
        //CHECK PLANTS
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        //This is a fragment that is change the plants

        let dateCurrent = new Date();//get curent date

        //LOOP TABLE
        for (var i = 0; i < map[0].length * map.length; i++) {
            var y = Math.floor(i / map[0].length);
            var x = (i % map[0].length);

            //seclect the element to change - if the date end is older or same that current date
            if ((dateCurrent - map[y][x].dateEnd > 0 && map[y][x].platformSecond.key == 'shoot') || (map[y][x].dateEnd.toString() == dateCurrent.toString())) {
                tile = isoGroupPlatform.children[(x * map[0].length) + y]                   //get the element to change
                tile.tint = 0xffffff;                                                       //add white color
                tile.loadTexture('nograss');                                                //load new texture

                var counter = 0;                                                            //helper variable
                var index = 0;                                                              //index of the object from isoGroupSecond
                var diffX = 1000000;                                                        //helper variable
                var diffY = 1000000;                                                        //helper variable
                isoGroupPlatformSecond.forEach(function (tileSecond) {                      //loop for each element at 
                    if (tileSecond.key == 'shoot') {                                        //do it for key(kind) of object
                        var currDiffX = Math.abs(tile.position.x - tileSecond.position.x);  //take difference x
                        var currDiffY = Math.abs(tile.position.y - tileSecond.position.y);  //take difference y
                        if (currDiffX < diffX || currDiffY < diffY) {                       //take the lower one
                            diffX = currDiffX;                                              //update helper variable
                            diffY = currDiffY;                                              //update helper variable
                            index = counter;                                                //update index
                        };
                    };
                    counter++;                                                              //add to counter
                });

                //UPDATE MAP
                map[y][x].platform = dictPlatform.noGrass;
                switch (map[y][x].kindGrowing) {
                    case dictKind.wheat: map[y][x].platformSecond = dictPlatformSecond.wheat; isoGroupPlatformSecond.children[index].loadTexture('wheat'); break;
                    case dictKind.tomato: map[y][x].platformSecond = dictPlatformSecond.tomato; isoGroupPlatformSecond.children[index].loadTexture('tomato'); break;
                    case dictKind.carrot: map[y][x].platformSecond = dictPlatformSecond.carrot; isoGroupPlatformSecond.children[index].loadTexture('carrot'); break;
                };
                map[y][x].kindGrowing = dictKind.null;
                map[y][x].dateStart = 0;
                map[y][x].dateEnd = 0;
            };
        };

        //ADD COLLLIDE AND TOPOLOGIC VIEW
        if (!gameMode) {
            game.physics.isoArcade.collide(isoGroupPlatform);
            game.physics.isoArcade.collide(isoGroupPlatformSecond);

        };

        //ADD GOOD TOPOLOGIC VIEW
        game.iso.topologicalSort(isoGroupPlatformSecond);
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
    render: function () {
        //This is a function to render the info in the left top corner

        xx = (player.body.position.x / size);   //prepare coords
        yy = (player.body.position.y / size);   //prepare coords

        //LOGIC TO PRINT INFO
        switch (map[Math.floor(yy)][Math.floor(xx)].platformSecond) {
            case dictPlatformSecond.null: platformSecondInfo = 'Air'; platformSecondInfoColor = dictColor.normal; break;
            case dictPlatformSecond.wheat: platformSecondInfo = 'Wheat'; platformSecondInfoColor = dictColor.green; break;
            case dictPlatformSecond.tomato: platformSecondInfo = 'Tomato'; platformSecondInfoColor = dictColor.green; break;
            case dictPlatformSecond.carrot: platformSecondInfo = 'Carrot'; platformSecondInfoColor = dictColor.green; break;
            case dictPlatformSecond.shoot: platformSecondInfo = 'Shoot'; platformSecondInfoColor = dictColor.yellow;

                //UPDATE TIME LEFT
                let dateCurrent = new Date();                               //get current date 
                let dateEnd = map[Math.floor(yy)][Math.floor(xx)].dateEnd;  //get date end
                dateEnd = new Date(dateEnd);
                timeLeft = dateEnd - dateCurrent;
                let minutes = Math.floor(timeLeft / (60 * 1000) % 60);      //get minutes to the end
                let seconds = Math.floor(timeLeft / 1000 % 60);             //get seconds to the end
                timeLeft = `${minutes}:${seconds}`;                         //prepare string
                timeLeftColor = dictColor.white;                            //set up color
                break;
        };
        switch (map[Math.floor(yy)][Math.floor(xx)].platform) {
            case dictPlatform.grass: platformInfo = 'Grass'; platformInfoColor = dictColor.normal; break;
            case dictPlatform.noGrass: platformInfo = 'No Grass'; platformInfoColor = dictColor.brown; break;
            case dictPlatform.wateringNoGrass: platformInfo = 'Watering No Grass'; platformInfoColor = dictColor.blue; break;
        };
        switch (map[Math.floor(yy)][Math.floor(xx)].kindGrowing) {
            case dictKind.null: kindGrowingInfo = null; kindGrowingInfoColor = dictColor.normal; break;
            case dictKind.wheat: kindGrowingInfo = 'wheat'; kindGrowingInfoColor = dictColor.yellow; break;
            case dictKind.tomato: kindGrowingInfo = 'tomato'; kindGrowingInfoColor = dictColor.red; break;
            case dictKind.carrot: kindGrowingInfo = 'carrot'; kindGrowingInfoColor = dictColor.red; break;
        };
        switch (kindSeeding) {
            case dictKind.null: kindSeedingInfo = 'no selected!'; kindSeedingInfoColor = dictColor.red; break;
            case dictKind.wheat: kindSeedingInfo = 'wheat'; kindSeedingInfoColor = dictColor.yellow; break;
            case dictKind.tomato: kindSeedingInfo = 'tomato'; kindSeedingInfoColor = dictColor.red; break;
            case dictKind.carrot: kindSeedingInfo = 'carrot'; kindSeedingInfoColor = dictColor.red; break;
        };

        //INFO PRINT
        //----------------------------------------------------------------------------------------------------------------------------------------------------------------
        game.debug.text('FPS: ' + game.time.fps || '--', infoX, infoY, dictColor.normal);
        switch (gameMode) {
            case true:
                game.debug.text('Game mode editor', infoX, infoY * 2, dictColor.white);
                break;
            case false:
                game.debug.text('Platform: ' + platformInfo, infoX, infoY * 2, platformInfoColor);
                game.debug.text('Player: ' + platformSecondInfo, infoX, infoY * 3, platformSecondInfoColor);
                if (kindGrowingInfo != null) {
                    game.debug.text('Kind growing: ' + kindGrowingInfo, infoX, infoY * 4, kindGrowingInfoColor);
                    game.debug.text('Time left: ' + timeLeft, infoX, infoY * 5, timeLeftColor);
                } else {
                    game.debug.text('Kind seeding: ' + kindSeedingInfo, infoX, infoY * 4, kindSeedingInfoColor);
                };
                break;
        };
    },
    //----------------------------------------------------------------------------------------------------------------------------------------------------------------
};
game.state.add('Boot', BasicGame.Boot);
game.state.start('Boot');