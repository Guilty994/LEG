var global_name;
var global_appId;


function handle(e) {
    if (e.keyCode === 13) {
        e.preventDefault(); // Ensure it is only this code that rusn
        cerca();
    }
}

function cerca() {
    if ($("#nomeGioco").val().length == 0) return;
    $("#ricercheRecenti").hide(500);
    $.ajax({
        url: "./controller.php?game=" + $("#nomeGioco").val() + "&source=steam", // &source=steam aggiunto per testing poi si vede come fare
        statusCode: {
            200: function (response) {
                let dati = JSON.parse(response);
                //let dati = JSON.parse(response.split("JSON")[1]);
                console.log(dati);

                global_appId = dati.appId;

                // Dati presi da Steam

                // Nome gioco
                $("#labelNomeGioco").text(dati.gameName);
                global_name = dati.gameName;

                getFromYoutube(global_name);
                getFromSteamCharts(global_appId);
                getFromTwitch(global_name);
                getFromGreenman(global_name);
                getFromG2A(global_name);
                getFromKinguin(global_name);
                stampaDatiSteam(dati);

                return;
            },
            404: function () {
                alert("Impossibile trovate il gioco desiderato.");
                return;
            },
            400: function () {
                alert("Parametri inviati non corretti.");
                return;
            },
            500: function (response) {
                let str = "Errore durante l'esecuzione della ricerca.";
                if (response != null) {
                    str += "\nErrore: " + response;
                }
                alert(str);
            }
        }
    });
}

function stampaDatiSteam(dati) {
    // Immagine di copertina
    $("#copertina").attr("src", dati.gameImage);

    // Genere
    $("#labelGenere").text(dati.gameGenere.join(', '));

    // Sviluppatori
    $("#labelSviluppatori").text(dati.gameDeveloper);

    // Publicatori
    $("#labelPublicatori").text(dati.gamePublisher.join(', '));

    // Data rilascio
    $("#labelReleaseDate").text(dati.gameRelease);

    // Descrizione
    $("#gameDescription").text(dati.gameDescription);

    // Trend
    // Forse è meglio con dei grafici
    let str = "";
    for (let index = 0; index < dati.gameTrend.length; index++) {
        str += '<p class="text-muted">' + dati.gameTrend[index] + '</p>';
    }

    if(dati.gameMetacritic.length > 0)
        str += '<p class="text-muted">Metacritic: ' + dati.gameMetacritic + '%</p>';
    $("#gameTrend").html(str);

    if (dati.gameTrend.length == 0 && dati.gameMetacritic.length == 0)
        $("#cardTrend").hide(0);

    // ScreenShots

    /*<div id="carouselScreenshots" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators" id="carouselIndicatorsScreenshots"></ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" id="carouselInnerScreenshots" style="text-align: center"></div>

                  <!-- Left and right controls -->
                   <a class="left carousel-control" href="#carouselScreenshots" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carouselScreenshots" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>*/
    str = '<div id="carouselScreenshots" class="carousel slide" data-ride="carousel">';
    str += '<ol class="carousel-indicators" id="carouselIndicatorsScreenshots">';
    let listaImmagini = "";
    for (let index = 0; index < dati.gameScreenshot.length; index++) {
        str += '<li data-target="#carouselScreenshots" data-slide-to="' + index + '"' + (index == 0 ? 'class="active"' : '') + '></li>';
        //listaImmagini += '<div class="item ' + (index == 0 ? 'active' : '') + '"><center><img width="100%" src="' + dati.gameScreenshot[index] + '"></center></div>';
    }
    str+= '</ol><div class="carousel-inner" id="carouselInnerScreenshots" style="text-align: center">';
    for (let index = 0; index < dati.gameScreenshot.length; index++) {
        str += '<div class="item ' + (index == 0 ? 'active' : '') + '"><center><img width="100%" src="' + dati.gameScreenshot[index] + '"></center></div>';
    }
    str += '</div>';
    str += '<a class="left carousel-control" href="#carouselScreenshots" data-slide="prev">';
    str += '<span class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a>';
    str += '<a class="right carousel-control" href="#carouselScreenshots" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next</span></a>';
    /*$("#carouselIndicatorsScreenshots").html("");
    $("#carouselIndicatorsScreenshots").html(str);
    $("#carouselInnerScreenshots").html("");
    $("#carouselInnerScreenshots").html(listaImmagini);*/
    $("#rowSlideshow").html(str);
    // Fine dati Steam
    $("#risultatiRicerca").show(500);
}

function getFromSteamCharts(steam_appid) {
    $.ajax({
        url: "./controller.php?steam_appid=" + steam_appid + "&source=steamcharts",
        statusCode: {
            200: function (response) {
                console.log(response);
            },
            400: function () {
                alert("Parametri errati per steam charts");
            },
            404: function () {
                alert("Impossibile recuperari dati da steam charts per il gioco selezionato.");
            },
            500: function () {
                console.log("Errore SteamCharts.");
            }
        }
    });
}

function getFromTwitch(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=twitch",
        statusCode: {
            200: function (response) {
                console.log(response);
                response = JSON.parse(response);
                $("#cardTrend").show(0);
                $("#twitchViewers").text('Twitch viewers: ' + response.twitchViewers);
            },
            400: function () {
                alert("Parametri errati per Twitch");
            },
            404: function () {
                alert("Impossibile recuperari dati da Twitch per il gioco selezionato.");
            },
            500: function () {
                console.log("Errore Twitch.");
            }
        }
    });
}

function getFromYoutube(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=youtube",
        statusCode: {
            200: function (response) {
                console.log(response);
                response = JSON.parse(response);
                console.log();
                $("#gameplayYoutube0").html('<iframe width="560" height="315" src="https://www.youtube.com/embed/' + response["videoGameplay"][0].split("?v=")[1] + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                $("#gameplayYoutube1").html('<iframe width="560" height="315" src="https://www.youtube.com/embed/' + response["videoGameplay"][1].split("?v=")[1] + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                /*$("#gameplayYoutube0").html('<iframe width="100%" src="http://www.youtube.com/embed/' + response["videoGameplay"][0].split("?v=")[1] + '" frameborder=0></iframe>');
                $("#gameplayYoutube1").html('<iframe width="100%" src="http://www.youtube.com/embed/' + response["videoGameplay"][1].split("?v=")[1] + '" frameborder=0></iframe>');*/
            },
            400: function () {
                alert("Parametri errati per Youtube");
            },
            404: function () {
                alert("Impossibile recuperari dati da Youtube per il gioco selezionato.");
            },
            500: function () {
                console.log("Errore Youtube.");
            }
        }
    });
}

function getFromGreenman(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=greenman",
        statusCode: {
            200: function (response) {
                console.log(response);
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                str += '<div class="col-md-4" style="text-align:center"><a href="' + response.greenManGameURL + '"><img style="width:100%;padding-top:25%" src="./logoGreenManGaming.png"></img><br><p class="text-muted">' + response.greenManPrice.replace('EUR','') + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                alert("Parametri errati per Greenman");
            },
            404: function () {
                alert("Impossibile recuperari dati da Greenman per il gioco selezionato.");
            },
            500: function () {
                console.log("Errore Greenman.");
            }
        }
    });
}

function getFromG2A(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=g2a",
        statusCode: {
            200: function (response) {
                console.log(response);
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                str += '<div class="col-md-4" style="text-align:center"><a href="' + response.G2AGameURL + '"><img style="width:100%;padding-top:30%" src="./logoG2A.jpg"></img><br><p class="text-muted">' + response.G2AGamePrice.replace('EUR','') + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                alert("Parametri errati per Greenman");
            },
            404: function () {
                alert("Impossibile recuperari dati da Greenman per il gioco selezionato.");
            },
            500: function () {
                console.log("Errore G2A.");
            }
        }
    });
}

function getFromKinguin(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=kinguin",
        statusCode: {
            200: function (response) {
                console.log(response);
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                str += '<div class="col-md-4" style="text-align:center"><a href="' + response.kinguinGameURL + '"><img style="width:100%" src="./logoKinguin.jpg"></img><br><p class="text-muted">' + response.kinguinGamePrice + '</p></a></div>';
                $("#cardPrezzi").html(str);
                console.info(str);
            },
            400: function () {
                alert("Parametri errati per Greenman");
            },
            404: function () {
                alert("Impossibile recuperari dati da Greenman per il gioco selezionato.");
            },
            500: function () {
                console.log("Errore Kinguin.");
            }
        }
    });
}