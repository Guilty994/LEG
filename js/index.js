var global_name;
var global_appId;

/*var recenti = new Array();
recenti[0] = {};
recenti[0].nome = "Sekiro";
recenti[0].copertina = "url";

$.cookie('recenti', JSON.stringify(recenti));
console.log(JSON.parse($.cookie('recenti')));*/

if ($.cookie('recenti') != undefined) {
    // Ci sono ricerce recenti
    recenti = $.cookie('recenti');
    recenti = JSON.parse(recenti);
    caricaRecenti(recenti);
} else {
    $("#recenti").html('<p class="text-muted">You haven\'t searched yet</p>');
    recenti = new Array();
}

function stampaRecenti() {
    for (r in recenti) {
        console.log(recenti[r]);
    }
}

function caricaRecenti(recenti) {
    console.log(recenti);
    str = '<div class="col-md-12">';
    for (r in recenti) {
        if (recenti[r] == undefined) continue;
        str += '<div class="col-md-4" onclick="recupera(' + r + ')">';
        str += '<img class="img-responsive" src="' + recenti[r].copertina + '" alt="Immagine di copertina"><br><h3 class="profile-username text-center">' + recenti[r].nome + '</h3>';
        str += '</div>';
    }
    str += '</div>';
    $("#recenti").html(str);
}

// Per la ricerca premendo invio
function handle(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        cerca();
    }
}

function cerca() {
    if ($("#nomeGioco").val().length == 0) return;
    $("#ricercheRecenti").hide(500);
    $.ajax({
        url: "./controller.php?game=" + $("#nomeGioco").val() + "&source=steam",
        statusCode: {
            200: function (response) {
                let dati = JSON.parse(response);

                if (dati.appId == "" || dati.gameName == "") {
                    alert("Steam non funziona");
                    toastr.error("Steam non dispone di questo gioco.");
                }

                global_appId = dati.appId;
                global_name = dati.gameName;

                $("#cardPrezzi").html("");

                getFromYoutube(global_name);
                getFromSteamCharts(global_appId);
                getFromTwitch(global_name);
                getFromGreenman(global_name);
                getFromG2A(global_name);
                getFromKinguin(global_name);
                stampaDatiSteam(dati);

                //$.cookie('recenti', JSON.stringify(recenti));
                salvaCookie();
                return;
            },
            404: function () {
                toastr.error("Impossibile trovate il gioco desiderato.");
                return;
            },
            400: function () {
                toastr.error("Parametri inviati non corretti.");
                return;
            },
            500: function (response) {
                let str = "Errore durante l'esecuzione della ricerca.";
                if (response != null) {
                    str += "\nErrore: " + response;
                }
                toastr.error(str);
            }
        }
    });
}

function recupera(appId) {

    $("#ricercheRecenti").hide(500);

    global_appId = appId;
    global_name = recenti[appId].nome;

    let gioco = recenti[appId];

    // Visualizzo le informazioni che già ho
    $("#labelNomeGioco").text(global_name);
    $("#copertina").attr("src", gioco.copertina);
    $("#labelGenere").text(gioco.genere);
    $("#labelSviluppatori").text(gioco.sviluppatori);
    $("#labelPublicatori").text(gioco.publicatori);
    $("#labelReleaseDate").text(gioco.releaseDate);
    $("#gameDescription").text(gioco.description);
    $("#gameTrend").html(gioco.gameTrend);
    if (gioco.gameTrend == undefined || gioco.gameTrend.length == 0) {
        $("#cardTrend").hide(0);
    } else {
        $("#cardTrend").show(0);
    }

    $("#rowSlideshow").html(creaSlideshow(JSON.parse(gioco.slideshow)));

    let y0, y1;
    y0 = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + gioco.YouTube0 + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    y1 = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + gioco.YouTube1 + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    $("#gameplayYoutube0").html(y0);
    $("#gameplayYoutube1").html(y1);

    getFromSteamCharts(global_appId);
    getFromTwitch(global_name);
    //getFromGreenman(global_name);
    getFromG2A(global_name);
    getFromKinguin(global_name);

    $("#risultatiRicerca").show(500);
}

function creaSlideshow(immagini) {
    str = '<div id="carouselScreenshots" class="carousel slide" data-ride="carousel">';
    str += '<ol class="carousel-indicators" id="carouselIndicatorsScreenshots">';
    for (let index = 0; index < immagini.length; index++) {
        str += '<li data-target="#carouselScreenshots" data-slide-to="' + index + '"' + (index == 0 ? 'class="active"' : '') + '></li>';
    }
    str += '</ol><div class="carousel-inner" id="carouselInnerScreenshots" style="text-align: center">';
    for (let index = 0; index < immagini.length; index++) {
        str += '<div class="item ' + (index == 0 ? 'active' : '') + '"><center><img width="100%" src="' + immagini[index] + '"></center></div>';
    }
    str += '</div>';
    str += '<a class="left carousel-control" href="#carouselScreenshots" data-slide="prev">';
    str += '<span class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a>';
    str += '<a class="right carousel-control" href="#carouselScreenshots" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next</span></a>';
    return str;
}

function sc(chiave, valore) {
    if (recenti == undefined) {
        recenti = new Array();
    }
    if (recenti[global_appId] == undefined)
        recenti[global_appId] = {};

    recenti[global_appId][chiave] = valore;
    salvaCookie();
}

function salvaCookie() {
    //document.cookie = "username=Mannaggia" + recenti;
    if (recenti == undefined || recenti.length == 0) return;
    //document.cookie = "recenti=" + JSON.stringify(recenti);
    //console.log(document.cookie);

    /*let tmpRecenti = {};
    for (r in recenti) {
        tmpRecenti[r] = recenti[r];
    }*/

    let k = JSON.stringify(recenti);
    console.log("Salvo nei cookie: " + k);
    $.cookie('recenti', k);

    //$.cookie('recenti', JSON.stringify(recenti));
    //console.log(JSON.parse($.cookie("recenti")));
    k = $.cookie('recenti');
    console.log("Ho letto dai cookie: " + k);
    k = JSON.parse(k);
    console.log(k);
}

function stampaDatiSteam(dati) {

    //console.log(dati);

    // Nome gioco
    $("#labelNomeGioco").text(dati.gameName);
    sc("nome", dati.gameName);

    // Immagine di copertina
    $("#copertina").attr("src", dati.gameImage);
    sc("copertina", dati.gameImage);

    // Genere
    $("#labelGenere").text(dati.gameGenere.join(', '));
    sc("genere", dati.gameGenere.join(', '));

    // Sviluppatori
    $("#labelSviluppatori").text(dati.gameDeveloper);
    sc("sviluppatori", dati.gameDeveloper);

    // Publicatori
    $("#labelPublicatori").text(dati.gamePublisher.join(', '));
    sc("publicatori", dati.gamePublisher.join(', '));

    // Data rilascio
    $("#labelReleaseDate").text(dati.gameRelease);
    sc("releaseDate", dati.gameRelease);

    // Descrizione
    $("#gameDescription").text(dati.gameDescription);
    sc("description", dati.gameDescription);

    // Trend
    // Forse è meglio con dei grafici
    let str = "";
    for (let index = 0; index < dati.gameTrend.length; index++) {
        str += '<p class="text-muted">' + dati.gameTrend[index] + '</p>';
    }

    if (dati.gameMetacritic.length > 0)
        str += '<p class="text-muted">Metacritic: ' + dati.gameMetacritic + '%</p>';
    $("#gameTrend").html(str);
    sc("gameTrend", JSON.stringify(dati.gameMetacritic));

    if (dati.gameTrend.length == 0 && dati.gameMetacritic.length == 0) {
        $("#cardTrend").hide(0);
        sc("gameTrend", "");
    }

    // ScreenShots
    str = creaSlideshow(dati.gameScreenshot);
    $("#rowSlideshow").html(str);
    sc("slideshow", JSON.stringify(dati.gameScreenshot));

    // Fine dati Steam
    $("#risultatiRicerca").show(500);
}

function getFromSteamCharts(steam_appid) {
    $.ajax({
        url: "./controller.php?steam_appid=" + steam_appid + "&source=steamcharts",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                $("#steamCharts").text("AVG 30 days players: " + response.avg + ". The peak is:" + response.peak);
            },
            400: function () {
                toastr.error("Parametri errati per steam charts");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da steam charts per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore SteamCharts.");
            }
        }
    });
}

function getFromTwitch(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=twitch",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                $("#cardTrend").show(0);
                $("#twitchViewers").text('Twitch viewers: ' + response.twitchViewers);
            },
            400: function () {
                toastr.error("Parametri errati per Twitch");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da Twitch per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore Twitch.");
            }
        }
    });
}

function getFromYoutube(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=youtube",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                let y0, y1;
                y0 = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + response["videoGameplay"][0].split("?v=")[1] + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                y1 = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + response["videoGameplay"][1].split("?v=")[1] + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                $("#gameplayYoutube0").html(y0);
                $("#gameplayYoutube1").html(y1);
                //sc("YouTube", response["videoGameplay"]);
                sc("YouTube0", response["videoGameplay"][0].split("?v=")[1]);
                sc("YouTube1", response["videoGameplay"][1].split("?v=")[1]);
                //sc("dataYoutube", JSON.stringify(new Date()));
            },
            400: function () {
                toastr.error("Parametri errati per Youtube");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da Youtube per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore Youtube.");
            }
        }
    });
}

function getFromGreenman(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=greenman",
        statusCode: {
            200: function (response) {
                return;
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                let price;
                /*if (response.greenManPrice.includes('EUR'))
                    price = response.greenManPrice.replace('EUR', '');
                else */
                price = response.greenManPrice;
                str += '<div class="col-md-4" style="text-align:center"><a href="' + response.greenManGameURL + '"><img style="width:100%;padding-top:25%" src="./logoGreenManGaming.png"></img><br><p class="text-muted">' + price + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Greenman");
            },
            404: function () {
                altoastr.errorert("Impossibile recuperari dati da Greenman per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore Greenman.");
            }
        }
    });
}

function getFromG2A(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=g2a",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                str += '<div class="col-md-4" style="text-align:center"><a href="' + response.G2AGameURL + '"><img style="width:100%;padding-top:30%" src="./logoG2A.jpg"></img><br><p class="text-muted">' + response.G2AGamePrice.replace('EUR', '') + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Greenman");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da Greenman per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore G2A.");
            }
        }
    });
}

function getFromKinguin(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=kinguin",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                str += '<div class="col-md-4" style="text-align:center"><a href="' + response.kinguinGameURL + '"><img style="width:100%" src="./logoKinguin.jpg"></img><br><p class="text-muted">' + response.kinguinGamePrice + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Greenman");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da Greenman per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore Kinguin.");
            }
        }
    });
}

$body = $("body");

$(document).on({
    ajaxStart: function () {
        $body.addClass("loading");
    },
    ajaxStop: function () {
        $body.removeClass("loading");
    }
});

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}