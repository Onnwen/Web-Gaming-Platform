function login() {
    $.post("https://garamante.it/API/login.php", {
        username: $("#username").val(),
        password: $("#password").val()
    }, "json")
        .fail(function () {
            alert("È stato riscontrato un errore inaspettato.");
        })
        .done(function (data) {
            if (data.exist) {
                sessionStorage.setItem('id', data.id)
                window.location.href = 'profile.html'
            } else {
                alert("Credenziali errate.");
            }
        });
}

function register() {
    $.post("https://garamante.it/API/register.php", {
        username: $("#username").val(),
        password: $("#password").val()
    }, "json")
        .fail(function () {
            alert("È stato riscontrato un errore inaspettato di cui non è possibile stabilire la causa.");
        })
        .done(function (data) {
            if (!data.created) {
                switch (data["status_id"]) {
                    case 0:
                        alert("L'account esiste già, verrai reindirizzato sulla pagina di login.");
                        window.location.href='login.html'
                        break;
                    case 3:
                        alert("Inserire uno username lungo almeno 4 caratteri e una password di almeno 6.");
                        break;
                    default:
                        alert("E' stato riscontrato un errore inaspettato.");
                        break;
                }
            }
            else {
                alert("L'account è stato creato, verrai reindirizzato sulla pagina di login.");
                window.location.href='login.html'
            }
        });
}

function getPartyData() {
    $.post("https://garamante.it/API/getPartyData.php", {
        party_id: sessionStorage.getItem('playing_party')
    }, "json")
        .fail(function () {
            alert("È stato riscontrato un errore inaspettato.");
        })
        .done(function (data) {
            let mesi = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
            let date = data.started.split("-");
            document.getElementById('date').textContent = parseInt(date[2]) + " " + mesi[parseInt(date[1])-1] + " " + date[0];
            let ownIndex = (data.players[0].id == sessionStorage.getItem('id')) ? 1 : 0;
            let otherPlayerIndex = ownIndex ? 0 : 1;
            document.getElementById('username').textContent = data.players[ownIndex].username;
            document.getElementById('own_latitude').textContent = String(data.players[ownIndex].latitude).substring(0, 9);
            document.getElementById('own_longitude').textContent = String(data.players[ownIndex].longitude).substring(0, 9);
            document.getElementById('other_player_username').textContent = data.players[otherPlayerIndex].username;
            document.getElementById('other_player_latitude').textContent = String(data.players[otherPlayerIndex].latitude).substring(0, 9);
            document.getElementById('other_player_longitude').textContent = String(data.players[otherPlayerIndex].longitude).substring(0, 9);
            if (ownIndex == 1) {
                document.getElementById("other_player_color_start").style = "stop-color:#1845ad; stop-opacity:1";
                document.getElementById("other_player_color_end").style = "stop-color:#23a2f6;s top-opacity:1";
                document.getElementById("own_color_start").style = "stop-color:#ff512f;stop-opacity:1";
                document.getElementById("own_color_end").style = "stop-color:#f09819;stop-opacity:1";
            }
        });
}

function getAccountData() {
    $.post("https://garamante.it/API/getAccountData.php", {
        user_id: sessionStorage.getItem('id')
    }, "json")
        .fail(function () {
            alert("È stato riscontrato un errore inaspettato di cui non è possibile stabilire la causa.");
        })
        .done(function (data) {
            document.getElementById("user_username").textContent = data.username;
            document.getElementById("user_total_win").innerHTML = data.win;

            sessionStorage.setItem('username', data.username);
            sessionStorage.setItem('password', data.password);
            sessionStorage.setItem('playing_party', data.playing_party);

            if (data.playing_party != null) {
                document.getElementById("submit").innerHTML = "Esci dalla partita";
            }
        });
}

function exitParty() {
    $.post("https://garamante.it/API/exitParty.php", {
        player_id: sessionStorage.getItem('id'),
        party_id: sessionStorage.getItem('playing_party')
    }, "json")
        .fail(function () {
            alert("È stato riscontrato un errore inaspettato di cui non è possibile stabilire la causa.");
        })
        .done(function () {
            sessionStorage.setItem('playing_party', null);
            window.location.href = 'profile.html';
        });
}

function deleteAccount() {
    if (confirm("Confermi di voler cancellare definitivamente il tuo account?") == true) {
        $.post("https://garamante.it/API/deleteAccount.php", {
            username: sessionStorage.getItem('username'),
            password: sessionStorage.getItem('password')
        }, "json")
            .fail(function () {
                alert("È stato riscontrato un errore inaspettato di cui non è possibile stabilire la causa.");
            })
            .done(function () {
                sessionStorage.setItem('id', null);
                window.location.href='login.html'
            });
    }
}

function resetSessionStorage() {
    sessionStorage.setItem('id', null);
    sessionStorage.setItem('username', null);
    sessionStorage.setItem('password', null);
    sessionStorage.setItem('playing_party', null);
    window.location.href='login.html'
}

function partyCanStart() {
    $.post("https://garamante.it/API/partyCanStart.php", {
        party_id: sessionStorage.getItem('playing_party')
    }, "json")
        .fail(function () {
            alert("È stato riscontrato un errore inaspettato di cui non è possibile stabilire la causa.");
        })
        .done(function (data) {
            if (data.canStart) {
                runParty();
            }
        });
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
async function runParty() {
    document.getElementById('title').textContent = "Avvio..."
    sleep(500).then(() => {
        window.location.href = 'ongoingParty.html'
    });
}
