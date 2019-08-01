var global_name;
var global_appId;
var recenti = localStorage.recenti;

if (recenti == undefined) {
    $("#recenti").html('<p class="text-muted">You haven\'t searched yet</p>');
} else {
    recenti = JSON.parse(recenti);
    caricaRecenti(recenti);
}

function stampaRecenti() {
    for (r in recenti) {
        console.log(recenti[r]);
    }
}

function caricaRecenti(recenti) {
    str = '<div class="col-md-12">';
    for (r in recenti) {
        if (recenti[r] == undefined) continue;
        let gioco = recenti[r];
        str += '<div class="col-md-4" onclick="recupera(' + r + ')">';
        str += '<img class="img-responsive" src="' + gioco.datiSteam.gameImage + '" alt="Immagine di copertina"><br><h3 class="profile-username text-center">' + gioco.datiSteam.gameName + '</h3>';
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
                getFromG2play(global_name);
                stampaDatiSteam(dati);

                if (recenti == undefined) {
                    recenti = new Array();
                }
                let g = {};
                g.appId = global_appId;
                g.datiSteam = dati;

                if (recenti.length != 0) {
                    for (i in recenti) {
                        if (recenti[i].appId == global_appId) {
                            recenti[i] = g;
                            localStorage.setItem("recenti", JSON.stringify(recenti));
                            return;
                        }
                    }
                }
                recenti.push(g);
                localStorage.setItem("recenti", JSON.stringify(recenti));
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

function stampaDatiYoutube(dati) {
    let y0, y1;
    y0 = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + dati["videoGameplay"][0].split("?v=")[1] + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    y1 = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + dati["videoGameplay"][1].split("?v=")[1] + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    $("#gameplayYoutube0").html(y0);
    $("#gameplayYoutube1").html(y1);
}

function recupera(index) {

    $("#ricercheRecenti").hide(500);

    let gioco = recenti[index];
    global_appId = gioco.appId;
    global_name = gioco.datiSteam.gameName;

    // Visualizzo le informazioni che già ho
    stampaDatiSteam(gioco.datiSteam);

    // Recupero le altre informazioni
    getFromSteamCharts(global_appId);
    getFromTwitch(global_name);
    getFromYoutube(global_name);
    getFromGreenman(global_name);
    getFromG2A(global_name);
    getFromKinguin(global_name);
    getFromG2play(global_name);

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

function stampaDatiSteam(dati) {

    //console.log(dati);

    // Nome gioco
    $("#labelNomeGioco").text(dati.gameName);

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
    let percentuale;

    // Nascondo tutti i charts in moodo da attivarli solo se ci sono le informazioni
    $("#divChartPositiveReviews").hide(0);
    $("#divChartPositiveReviewsLastMonth").hide(0);
    for (let index = 0; index < dati.gameTrend.length; index++) {
        percentuale = dati.gameTrend[index].split('- ')[1].split('%')[0];
        if(dati.gameTrend[index].includes('30 days')){
            creaChartPositiveReviewsLastMonth(percentuale);
        }else if(dati.gameTrend[index].includes('for this game')){
            creaChartPositiveReviews(percentuale);
        }else{
            str += '<p class="text-muted">' + dati.gameTrend[index] + '</p>';
        }
    }

    $("#divChartMetacritic").hide(0);
    if (dati.gameMetacritic.length > 0){
        creaChartMetacritic(dati.gameMetacritic);
    }
        
        //str += '<p class="text-muted">Metacritic: ' + dati.gameMetacritic + '%</p>';
    $("#gameTrend").html(str);

    if (dati.gameTrend.length == 0 && dati.gameMetacritic.length == 0) {
        $("#cardTrend").hide(0);
    }

    // ScreenShots
    str = creaSlideshow(dati.gameScreenshot);
    $("#rowSlideshow").html(str);

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
                stampaDatiYoutube(response);
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
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                //let price;
                /*if (response.greenManPrice.includes('EUR'))
                    price = response.greenManPrice.replace('EUR', '');
                else */
                //price = response.greenManPrice;
                str += creaDivPrezzo("greenman", response.greenManGameURL, response.greenManPrice);
                //str += '<div class="col-md-4" style="text-align:center"><a href="' + response.greenManGameURL + '"><img style="width:100%;padding-top:25%" src="./logoGreenManGaming.png"></img><br><p class="text-muted">' + price + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Greenman");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da Greenman per il gioco selezionato.");
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
                str += creaDivPrezzo("g2a", response.G2AGameURL, response.G2AGamePrice.replace('EUR', ''));
                //str += '<div class="col-md-4" style="text-align:center"><a href="' + response.G2AGameURL + '"><img style="width:100%;padding-top:30%" src="./logoG2A.jpg"></img><br><p class="text-muted">' + response.G2AGamePrice.replace('EUR', '') + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per G2A");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da G2A per il gioco selezionato.");
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
                str += creaDivPrezzo("kinguin", response.kinguinGameURL, response.kinguinGamePrice);
                //str += '<div class="col-md-4" style="text-align:center"><a href="' + response.kinguinGameURL + '"><img style="width:100%" src="./logoKinguin.jpg"></img><br><p class="text-muted">' + response.kinguinGamePrice + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Kinguin");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da Kinguin per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore Kinguin.");
            }
        }
    });
}

function getFromG2play(steam_name) {
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=g2play",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                str = $("#cardPrezzi").html();
                str += creaDivPrezzo("g2play", response.g2playGameURL, response.g2playGamePrice);
                //str += '<div class="col-md-4" style="text-align:center"><a href="' + response.g2playGameURL + '"><img style="width:100%;padding-top:20%" src="./logoG2play.png"></img><br><p class="text-muted">' + response.g2playGamePrice + '</p></a></div>';
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per G2play");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da G2play per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore G2play.");
            }
        }
    });
}

function creaDivPrezzo(nome, url, prezzo) {
    return '<div class="col-md-4" style="text-align:center"><a href="' + url + '"><img style="width:100%;padding-top:20%" src="./logo' + nome + '.png"></img><br><p class="text-muted">' + prezzo + '</p></a></div>';
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function getSystemRequirement(steam_name) {
    if (steam_name == undefined) steam_name = global_name;
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=sysreq",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                console.log(response);
                // Dovrei stampare con la tabella
            },
            400: function () {
                toastr.error("Parametri errati per G2play");
            },
            404: function () {
                toastr.error("Impossibile recuperari dati da G2play per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore G2play.");
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

function creaChartMetacritic(positive) {
    $("#divChartMetacritic").show(500);
    var ctx = document.getElementById('chartMetacritic').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['score','remains'],
            datasets: [{
                label: '',
                data: [positive, 100-positive],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 255, 132, 1)'
                ],
                borderColor: [
                    'rgba(255, 255, 132, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            /*scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }*/
        }
    });
}

function creaChartPositiveReviews(positive) {
    $("#divChartPositiveReviews").show(500);
    var ctx = document.getElementById('chartPositiveReviews').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['positive reviews','negative reviews'],
            datasets: [{
                label: '',
                data: [positive, 100-positive],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 255, 132, 1)'
                ],
                borderColor: [
                    'rgba(255, 255, 132, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            /*scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }*/
        }
    });
}

function creaChartPositiveReviewsLastMonth(positive) {
    $("#divChartPositiveReviewsLastMonth").show(500);
    var ctx = document.getElementById('chartPositiveReviewsLastMonth').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['positive reviews','negative reviews'],
            datasets: [{
                label: '',
                data: [positive, 100-positive],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 255, 132, 1)'
                ],
                borderColor: [
                    'rgba(255, 255, 132, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            /*scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }*/
        }
    });
}

function  creaChartSteamCharts(positive) {
    $("#divChartPositiveReviewsLastMonth").show(500);
    var ctx = document.getElementById('chartSteamCharts').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}