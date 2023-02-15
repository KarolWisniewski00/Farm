//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//LAYOUT
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//VARIABLES
var divSeedingWindow = document.getElementById('window-seeding');
var divSeeding = document.getElementById('seedings');
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

//WINDOW SEEDING
document.getElementById("seeding").addEventListener("click", function () {
    if (divSeedingWindow.style.visibility === "hidden") {
        divSeedingWindow.style.visibility = "visible";
        divSeeding.innerHTML = '';
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
    } else {
        divSeedingWindow.style.visibility = "hidden";
    };
});

document.addEventListener("click", function (event) {
    if (event.target != divSeedingButtom && event.target.parentNode != divSeedingButtom) {
        divSeedingWindow.style.visibility = "hidden";
    }
});

//WINDOW MISSION
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
            divMission.innerHTML += singleMission;
            counter++;
        });
    } else {
        divMissionWindow.style.visibility = "hidden";
    }
});

document.addEventListener("click", function (event) {
    if (event.target != divMissionButtom && event.target.parentNode != divMissionButtom) {
        divMissionWindow.style.visibility = "hidden";
    }
});

//WINDOW SETTINGS
document.getElementById("setting").addEventListener("click", function () {
    if (divSettingWindow.style.visibility === "hidden") {
        divSettingWindow.style.visibility = "visible";
    } else {
        divSettingWindow.style.visibility = "hidden";
    };
});

document.addEventListener("click", function (event) {
    if (event.target != divSettingButtom && event.target.parentNode != divSettingButtom) {
        divSettingWindow.style.visibility = "hidden";
    }
});

//BUTTON KIND SEEDING
function kindSeedingSet(newKindSeeding, id) {
    kindSeeding = newKindSeeding;
    for (var key in dictButton) {
        document.getElementById(dictButton[key]).className = 'btn btn-outline-light p-2 m-2';
    };
    document.getElementById(id).className = 'btn btn-outline-light p-2 m-2 active';
};

//BUTTON MISSION
function missionChcek(id) {
    var have = false;
    missions[id].collect.forEach(function (coll) {
        switch (coll.item) {
            case 'wheat': if (dictSeedingCount.wheat >= coll.count) { have = true }; break;
            case 'tomato': if (dictSeedingCount.tomato >= coll.count) { have = true }; break;
            case 'carrot': if (dictSeedingCount.carrot >= coll.count) { have = true }; break;
            case 'coin': if (coins >= coll.count) { have = true }; break;
        };
    });
    if (have) {
        missions[id].award.forEach(function (awa) {
            switch (awa.item) {
                case 'wheat': dictSeedingCount.wheat += awa.count; break;
                case 'tomato': dictSeedingCount.tomato += awa.count; break;
                case 'carrot': dictSeedingCount.carrot += awa.count; break;
                case 'coin': coins += awa.count; document.getElementById("coins").innerHTML = coins; break;
            };
        });
        missions[id].collect.forEach(function (coll) {
            switch (coll.item) {
                case 'wheat': dictSeedingCount.wheat -= coll.count; break;
                case 'tomato': dictSeedingCount.tomato -= coll.count; break;
                case 'carrot': dictSeedingCount.carrot -= coll.count; break;
                case 'coin': coins -= coll.count; document.getElementById("coins").innerHTML = coins; break;
            };
        });
        missions.splice(id, id + 1);
        console.log(missions)
    };
};
//BUTTON CHANGE GAMEMODE
function changeGameMode(){
    if (gameMode){
        gameMode=false
        document.getElementById('change-type').className = 'btn btn-outline-light p-2 m-2';
        document.getElementById('plant').style.display = 'block';
        document.getElementById('watering-can').style.display = 'block';
        document.getElementById('shovel').style.display = 'block';
        document.getElementById('scythe').style.display = 'block';
        document.getElementById('grass').style.display = 'none';
        document.getElementById('tree').style.display = 'none';
        document.getElementById('rock').style.display = 'none';
        document.getElementById('water').style.display = 'none';
    }else{
        gameMode=true
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
function save(){
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/farm/public/game-update', // adres URL kontrolera
        type: 'POST', // metoda HTTP, w tym przypadku POST
        data: { // dane do wysłania
            map: JSON.stringify(map),
            coins: coins,
            missions: JSON.stringify(missions),
            count: JSON.stringify(dictSeedingCount),
            _token: token,
        },
        success: function (response) {
            console.log(response); // reakcja po sukcesie, np. wyświetlenie odpowiedzi w konsoli
        },
        error: function (error) {
            console.error(error); // reakcja na błąd, np. wyświetlenie komunikatu o błędzie w konsoli
        }
    });
}