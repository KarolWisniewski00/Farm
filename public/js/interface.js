//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//LAYOUT
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//VARIABLES
var divSeedingWindow = document.getElementById('window-seeding');
var divSeeding = document.getElementById('seedings');
var divAnimal = document.getElementById('animals');
var divSeedingButtom = document.getElementById('seeding');
divSeedingWindow.style.visibility = "hidden";

var divMissionWindow = document.getElementById('window-mission');
var divMission = document.getElementById('missions');
var divMissionButtom = document.getElementById('mission');
divMissionWindow.style.visibility = "hidden";

var divSettingWindow = document.getElementById('window-settings');
var divSetting = document.getElementById('settings');
var divSettingButtom = document.getElementById('setting');
divSettingWindow.style.visibility = "hidden";

var divChatWindow = document.getElementById('window-chat');
var divChat = document.getElementById('chat');
var divChatButtom = document.getElementById('chats');
divChatWindow.style.visibility = "hidden";

//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//WINDOW SEEDING SHOW - HIDE LOGIC
//this is a function to show - hide the window on click the button
document.getElementById("seeding").addEventListener("click", function () {
    if (divSeedingWindow.style.visibility === "hidden") {
        divSeedingWindow.style.visibility = "visible";
        divSeeding.innerHTML = '';
        divAnimal.innerHTML = '';
        for (let key in dictSeedingCount) {
            if (dictSeedingCount[key] > 0) {
                singleButton = `
                <div class="col d-flex justify-content-center align-items-center">
                    <buttom class="btn btn-outline-light p-2 m-2" id="${key}-icon"
                        onclick="kindSeedingSet(dictKind.${key}, '${key}-icon')">
                        <div>${key}</div><img src="images/${key}-icon.png" class="img-fluid max-height-64"
                            alt="${key}-icon">
                        <div id="${key}-seeding-count">${dictSeedingCount[key]}</div>
                    </buttom>
                </div>
                `;
                divSeeding.innerHTML += singleButton;
            };
        };
        if (cowActive) {
            cowButton = `
            <div class="list-group-item list-group-item-action bg-transparent border-1 rounded-0 border-white text-white d-flex flex-column justify-content-between">
                <div class="d-flex flex-column text-center w-100">
                    <div><h3>Feed Cow</h3><img src="images/cow-icon.png" class="img-fluid max-height-64"
                    alt="cow-icon"></div>
                </div>
                <div class="d-flex flex-row">
                    <div class="d-flex flex-column w-100 text-center">
                        <h5 class="mb-1">Collect:</h5>
                        <div class="w-100">
                            <buttom class="btn btn-outline-light p-2 m-2">
                                <div>Wheat</div><img src="images/wheat-icon.png" class="img-fluid max-height-64"
                                    alt="wheat-icon">
                                <div>x<span>10</span></div>
                            </buttom>
                        </div>
                    </div>
                    <div class="d-flex flex-column w-100 text-center">
                        <h5 class="mb-1">Award:</h5>
                        <div class="w-100">
                            <buttom class="btn btn-outline-light p-2 m-2">
                                <div>Milk</div><img src="images/milk-icon.png" class="img-fluid max-height-64"
                                    alt="milk-icon">
                                <div>x<span>1</span></div>
                            </buttom>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column text-center w-100">
                    <div><button class="btn btn-light" onClick="feedCow()">Do it!</button></div>
                </div>
            </div>
            `;
            divAnimal.innerHTML += cowButton;
        };
        if (chickenActive) {
            chickenButton = `
            <div class="list-group-item list-group-item-action bg-transparent border-1 rounded-0 border-white text-white d-flex flex-column justify-content-between">
                <div class="d-flex flex-column text-center w-100">
                    <div><h3>Feed Chicken</h3><img src="images/chicken-icon.png" class="img-fluid max-height-64"
                    alt="chicken-icon"></div>
                </div>
                <div class="d-flex flex-row">
                    <div class="d-flex flex-column w-100 text-center">
                        <h5 class="mb-1">Collect:</h5>
                        <div class="w-100">
                            <buttom class="btn btn-outline-light p-2 m-2">
                                <div>Corn</div><img src="images/corn-icon.png" class="img-fluid max-height-64"
                                    alt="corn-icon">
                                <div>x<span>10</span></div>
                            </buttom>
                        </div>
                    </div>
                    <div class="d-flex flex-column w-100 text-center">
                        <h5 class="mb-1">Award:</h5>
                        <div class="w-100">
                            <buttom class="btn btn-outline-light p-2 m-2">
                                <div>Egg</div><img src="images/egg-icon.png" class="img-fluid max-height-64"
                                    alt="egg-icon">
                                <div>x<span>1</span></div>
                            </buttom>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column text-center w-100">
                    <div><button class="btn btn-light" onClick="feedChicken()">Do it!</button></div>
                </div>
            </div>
            `;
            divAnimal.innerHTML += chickenButton;
        };
    } else {
        divSeedingWindow.style.visibility = "hidden";
    };
});
//this is a function to show -hide the window on click the screen
document.addEventListener("click", function (event) {
    if (event.target != divSeedingButtom && event.target.parentNode != divSeedingButtom) {
        divSeedingWindow.style.visibility = "hidden";
    }
});

//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//WINDOW MISSION - HIDE LOGIC
//this is a function to show - hide the window on click the button
document.getElementById("mission").addEventListener("click", function () {
    if (divMissionWindow.style.visibility === "hidden") {
        divMissionWindow.style.visibility = "visible";
        divMission.innerHTML = '';
        var counter = 0;
        missions.forEach(function (mission) {
            var collect = '';
            var award = '';
            mission.collect.forEach(function (coll) {
                collect += `
                    <buttom class="btn btn-outline-light p-2 m-2">
                        <div>${coll.item}</div><img src="images/${coll.item}-icon.png" class="img-fluid max-height-64"
                            alt="${coll.item}-icon">
                        <div>x<span>${coll.count}</span></div>
                    </buttom>
                    `;
            });
            mission.award.forEach(function (awa) {
                award += `
                    <buttom class="btn btn-outline-light p-2 m-2">
                        <div>${awa.item}</div><img src="images/${awa.item}-icon.png" class="img-fluid max-height-64"
                            alt="${awa.item}-icon">
                        <div>x<span>${awa.count}</span></div>
                    </buttom>
                    `;
            });
            singleMission = `
                    <div class="list-group-item list-group-item-action bg-transparent border-1 rounded-0 border-white text-white d-flex flex-column justify-content-between">
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-column w-100 text-center">
                                <h5 class="mb-1">Collect:</h5>
                                <div class="w-100">
                                    ${collect}
                                </div>
                            </div>
                            <div class="d-flex flex-column w-100 text-center">
                                <h5 class="mb-1">Award:</h5>
                                <div class="w-100">
                                    ${award}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column text-center w-100">
                            <div><button class="btn btn-light" onClick="missionChcek(${counter})">Do it!</button></div>
                        </div>
                    </div>
                    `;
            counter++;
            divMission.innerHTML += singleMission;
        });
    } else {
        divMissionWindow.style.visibility = "hidden";
    }
});
//this is a function to show -hide the window on click the screen
document.addEventListener("click", function (event) {
    if (event.target != divMissionButtom && event.target.parentNode != divMissionButtom) {
        divMissionWindow.style.visibility = "hidden";
    }
});

//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//WINDOW SETTINGS - HIDE LOGIC
//this is a function to show - hide the window on click the button
document.getElementById("setting").addEventListener("click", function () {
    if (divSettingWindow.style.visibility === "hidden") {
        divSettingWindow.style.visibility = "visible";
    } else {
        divSettingWindow.style.visibility = "hidden";
    };
});
//this is a function to show -hide the window on click the screen
document.addEventListener("click", function (event) {
    if (event.target != divSettingButtom && event.target.parentNode != divSettingButtom) {
        divSettingWindow.style.visibility = "hidden";
    }
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//WINDOW CHAT - HIDE LOGIC
//this is a function to show - hide the window on click the button
document.getElementById("chats").addEventListener("click", function () {
    if (divChatWindow.style.visibility === "hidden") {
        divChatWindow.style.visibility = "visible";
        divChat.innerHTML = '';
        chatList.forEach(element => {
            singleChat = `
            <div style="word-break: break-all;">[USER${element.user_id}] : ${element.content}</div>
            `;
            divChat.innerHTML += singleChat;
        });
    } else {
        divChatWindow.style.visibility = "hidden";
    }
});
document.getElementById("chats1").addEventListener("click", function () {
    if (divChatWindow.style.visibility === "hidden") {} else {
        divChatWindow.style.visibility = "hidden";
    }
});
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//BUTTON KIND SEEDING
//this is a function to switch the kind of seeding
function kindSeedingSet(newKindSeeding, id) {
    kindSeeding = newKindSeeding;
    for (var key in dictButton) {
        document.getElementById(dictButton[key]).className = 'btn btn-outline-light p-2 m-2';
    };
    document.getElementById(id).className = 'btn btn-outline-light p-2 m-2 active';
};
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//BUTTON MISSION
//This is a function to check the missions and remove if the condition is met
function missionChcek(id) {
    var have = false;
    console.log(missions)
    missions[id].collect.forEach(function (coll) {
        switch (coll.item) {                                                                                    //chcek if user have all from mission
            case 'wheat': if (dictSeedingCount.wheat >= coll.count) { have = true } else { have = false }; break;                     //then set have true
            case 'tomato': if (dictSeedingCount.tomato >= coll.count) { have = true } else { have = false }; break;                   //then set have true
            case 'carrot': if (dictSeedingCount.carrot >= coll.count) { have = true } else { have = false }; break;                   //then set have true
            case 'corn': if (dictSeedingCount.corn >= coll.count) { have = true } else { have = false }; break;                   //then set have true
            case 'coin': if (coins >= coll.count) { have = true } else { have = false }; break;                                       //then set have true
            case 'milk': if (dictSeedingCount.milk >= coll.count) { have = true } else { have = false }; break;                                       //then set have true
            case 'egg': if (dictSeedingCount.egg >= coll.count) { have = true } else { have = false }; break;                                       //then set have true
        };
    });
    if (have) {                                                                                                 //if have is true 
        missions[id].award.forEach(function (awa) {
            switch (awa.item) {
                case 'wheat': dictSeedingCount.wheat += awa.count; break;                                       //add award
                case 'tomato': dictSeedingCount.tomato += awa.count; break;                                     //add award
                case 'carrot': dictSeedingCount.carrot += awa.count; break;                                     //add award
                case 'corn': dictSeedingCount.corn += awa.count; break;                                     //add award
                case 'coin': coins += awa.count; document.getElementById("coins").innerHTML = coins; break;     //update view 
                case 'cow':
                    cowActive = true;
                    function direction() {
                        randomNumber = Math.floor(Math.random() * 4) + 1;
                        speedCowX = Math.floor(Math.random() * 60) + 30;
                        speedCowY = Math.floor(Math.random() * 60) + 30;
                    };
                    setInterval(direction, 2000);
                    cow = game.add.isoSprite(characterStartX * size, (characterStartY + 1) * size, 0, 'cow', 0, isoGroupPlatformSecond);
                    cow.anchor.set(0.5);
                    game.physics.isoArcade.enable(cow);
                    cow.body.collideWorldBounds = true;
                    break;                                                              //update cow state 
                case 'chicken':
                    chickenActive = true;
                    function direction() {
                        randomNumber = Math.floor(Math.random() * 4) + 1;
                        speedChickenX = Math.floor(Math.random() * 60) + 30;
                        speedChickenY = Math.floor(Math.random() * 60) + 30;
                    };
                    setInterval(direction, 2000);
                    chicken = game.add.isoSprite(characterStartX * size, (characterStartY + 1) * size, 0, 'chicken', 0, isoGroupPlatformSecond);
                    chicken.anchor.set(0.5);
                    game.physics.isoArcade.enable(chicken);
                    chicken.body.collideWorldBounds = true;
                    break;
            };
        });
        missions[id].collect.forEach(function (coll) {
            switch (coll.item) {
                case 'wheat': dictSeedingCount.wheat -= coll.count; break;                                      //remove collect
                case 'tomato': dictSeedingCount.tomato -= coll.count; break;                                    //remove collect
                case 'carrot': dictSeedingCount.carrot -= coll.count; break;                                    //remove collect
                case 'corn': dictSeedingCount.corn -= coll.count; break;                                    //remove collect
                case 'milk': dictSeedingCount.milk -= coll.count; break;                                    //remove collect
                case 'egg': dictSeedingCount.egg -= coll.count; break;                                    //remove collect
                case 'coin': coins -= coll.count; document.getElementById("coins").innerHTML = coins; break;    //update view 
            };
        });
        missions.splice(id, 1);
        console.log(missions)                                                                           //remove mission
    };
};
function feedCow() {
    if (cowActive && dictSeedingCount.wheat >= 10) {
        dictSeedingCount.wheat -= 10;
        dictSeedingCount.milk += 1;
    };
};
function feedChicken() {
    if (chickenActive && dictSeedingCount.wheat >= 10) {
        dictSeedingCount.corn -= 10;
        dictSeedingCount.egg += 1;
    };
};

//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//BUTTON CHANGE GAMEMODE
//This is a function to change the view of the layout 
function changeGameMode() {
    if (gameMode) {
        gameMode = false;
        document.getElementById('change-type').className = 'btn btn-outline-light p-2 m-2';
        document.getElementById('plant').style.display = 'block';
        document.getElementById('watering-can').style.display = 'block';
        document.getElementById('shovel').style.display = 'block';
        document.getElementById('scythe').style.display = 'block';
        document.getElementById('grass').style.display = 'none';
        document.getElementById('tree').style.display = 'none';
        document.getElementById('rock').style.display = 'none';
        document.getElementById('water').style.display = 'none';
    } else {
        gameMode = true;
        kindSeeding = dictKind.null;
        count = 0;
        document.getElementById('change-type').className = 'btn btn-outline-light p-2 m-2 active';
        document.getElementById('plant').style.display = 'none';
        document.getElementById('watering-can').style.display = 'none';
        document.getElementById('shovel').style.display = 'none';
        document.getElementById('scythe').style.display = 'none';
        document.getElementById('grass').style.display = 'block';
        document.getElementById('tree').style.display = 'block';
        document.getElementById('rock').style.display = 'block';
        document.getElementById('water').style.display = 'block';
    };
};

//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//This is a function to save the map of the game
function save() {
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/farm/public/game-update',                        //adress URL controller
        type: 'POST',                                           //metod HTTP
        data: {                                                 //data to send
            map: JSON.stringify(map),
            coins: coins,
            missions: JSON.stringify(missions),
            count: JSON.stringify(dictSeedingCount),
            cow: cowActive,
            chicken: chickenActive,
            _token: token,
        },
        success: function (response) {
            console.log(response);                              //success show
        },
        error: function (error) {
            console.error(error);                               //fail show
        }
    });
}
function chatGet() {
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: 'test2/farm/public/chat-get',                        //adress URL controller
        type: 'GET',                                           //metod HTTP
        data: {},
        success: function (response) {
            chatList = response;                              //success show
        },
        error: function (error) {
            console.error(error);                               //fail show
        }
    });
}