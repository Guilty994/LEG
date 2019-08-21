var global_name;
var global_appId;
var recenti = localStorage.recenti;
var top3;
var risultatiTags;
var risultatiNome;

if (recenti == undefined) {
    $("#recenti").html('<p class="text-muted">You haven\'t searched yet</p>');
} else {
    recenti = JSON.parse(recenti);
    caricaRecenti(recenti);
}

function checkRecenti() {
    if (recenti == undefined) {
        $("#recenti").html('<p class="text-muted">You haven\'t searched yet</p>');
    } else {
        caricaRecenti(recenti);
    }
}

function home() {
    $("#ricercheRecenti").show(500);
    $("#risultatiRicerca").hide(500);
    checkRecenti();
}

// Solo DEBUG
function stampaRecenti() {
    for (r in recenti) {
        console.log(recenti[r]);
    }
}

function cercaByTop3(index) {
    $("#modalTop3").modal('hide');
    cerca(top3[index].name);
}

// Top 3
function top5() {
    console.log("top5 click");
    top3 = new Array();
    $.ajax({
        url: "./controller.php?source=topf",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                response = response.topGames;

                for (index in response) {
                    if (top3.length >= 3) break;
                    $.ajax({
                        url: "./controller.php?source=checksteam&twitchGame=" + response[index],
                        statusCode: {
                            200: function (response) {
                                response = JSON.parse(response);
                                top3.push(response.topFive[0]);
                            }
                        }
                    });
                }

                $(document).on({
                    ajaxStop: function () {
                        // Popolo il modal
                        let str = '';

                        for (index in top3) {
                            if(index >= 3) break;
                            str += '<div class="row mustHilightOnHover" style="padding-bottom:2%;padding-top:2%" onclick="cercaByTop3(' + index + ')">';
                            str += '<div class="col-md-4"><img class="img-responsive" src="' + top3[index].icon + '"/></div>';
                            str += '<div class="col-md-8"><label>' + top3[index].name + '</label></div>';
                            str += '</div>';
                        }
                        $("#contenutoModalTop3").html(str);
                        $("#modalTop3").modal('show');
                        $(document).off();
                        $(document).on({
                            ajaxStart: function () {
                                $body.addClass("loading");
                            },
                            ajaxStop: function () {
                                $body.removeClass("loading");
                            }
                        });
                    }
                });
            },
            400: function () {
                console.info("Impossibile caricare top 5");
            },
            500: function () {
                toastr.error("Impossibile caricare i top 5. Errore del server");
            }
        }
    });
}

function caricaRecenti(recenti) {
    str = '<div class="col-md-12">';
    for (r in recenti) {
        if (recenti[r] == undefined) continue;
        let gioco = recenti[r];
        str += '<div class="col-md-4" onclick="recupera(' + r + ')" style="padding:1%">';
        str += '<img class="img-responsive" src="' + gioco.datiSteam.gameImage + '" alt="Immagine di copertina">';
        //str += '<p class="text-center">' + gioco.datiSteam.gameName + '</p>';
        if(gioco.datiSteam.gameName.length > 24){
            str += '<h6 class="text-center">' + gioco.datiSteam.gameName + '</h6>';
        }else{
            str += '<h5 class="text-center">' + gioco.datiSteam.gameName + '</h5>';
        }
        str += '</div>';
    }
    str += '</div>';
    $("#recenti").html(str);
}

// Per la ricerca premendo invio
function handle(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        cercaNome();
    }
}

function resetCampi() {
    $("#cardTrend").hide(0);
    $("#cardPrezzi").html("");
    $("#cardPrezziPrincipale").hide(0);
}

function cercaByName(index){
    $("#modalTags").modal('hide');
    cerca(risultatiNome[index].name);
}

function cercaNome(){
    risultatiNome = new Array();
    nome = $("#nomeGioco").val();
    if(nome == undefined || nome.length == 0) return;
    $.ajax({
        url: "./controller.php?game=" + nome + "&source=searchbyname",
        statusCode: {
            200: function (response) {
                console.log(response);
                response = JSON.parse(response);

                let str = "";
                response = response.search.result;
                for (index in response) {
                    risultatiNome.push(response[index]);
                    str += '<div class="row mustHilightOnHover" style="padding-bottom:2%;padding-top:2%" onclick="cercaByName(' + index + ')">';
                    str += '<div class="col-md-4"><img class="img-responsive" src="' + response[index].icon + '"/></div>';
                    str += '<div class="col-md-8"><label>' + response[index].name + '</label></div>';
                    str += '</div>';
                }
                $("#contenutoModalTags").html(str);
                $("#modalTags").modal('show');

            },
            404: function(){
                toastr.warning("No games found");
            }
        }
    });
}

function cerca(nome) {
    if (nome == undefined) {
        if ($("#nomeGioco").val().length == 0) return;
        else
            nome = $("#nomeGioco").val();
    }
    $("#nomeGioco").val('');
    $('#selectTags').multipleSelect('uncheckAll');
    $.ajax({
        url: "./controller.php?game=" + nome + "&source=steam",
        statusCode: {
            200: function (response) {
                $("#ricercheRecenti").hide(500);
                let dati = JSON.parse(response);

                if (dati.appId == "" || dati.gameName == "") {
                    alert("Steam non funziona");
                    toastr.error("Steam non dispone di questo gioco.");
                    $("#ricercheRecenti").show(500);
                }

                global_appId = dati.appId;
                global_name = dati.gameName;

                resetCampi();

                getFromYoutube(global_name);
                getFromSteamCharts(global_appId);
                getFromTwitch(global_name);
                getFromGreenman(global_name);
                getFromG2A(global_name);
                getFromKinguin(global_name);
                getFromG2play(global_name);
                stampaDatiSteam(dati);
                getSystemRequirement(global_name)

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
                if (recenti.length > 9) {
                    recenti.splice(0, 1);
                }
                localStorage.setItem("recenti", JSON.stringify(recenti));
                return;
            },
            404: function () {
                toastr.error("Steam non possiede il gioco desiderato.");
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

    resetCampi();
    // Recupero le altre informazioni
    getFromSteamCharts(global_appId);
    getFromTwitch(global_name);
    getFromYoutube(global_name);
    getFromGreenman(global_name);
    getFromG2A(global_name);
    getFromKinguin(global_name);
    getFromG2play(global_name);
    getSystemRequirement(global_name)

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
    let str = "";
    let percentuale;

    // Nascondo tutti i charts in moodo da attivarli solo se ci sono le informazioni
    $("#divChartPositiveReviews").hide(0);
    $("#divChartPositiveReviewsLastMonth").hide(0);
    for (let index = 0; index < dati.gameTrend.length; index++) {
        percentuale = dati.gameTrend[index].split('- ')[1].split('%')[0];
        if (dati.gameTrend[index].includes('30 days')) {
            creaChartPositiveReviewsLastMonth(percentuale);
        } else if (dati.gameTrend[index].includes('for this game')) {
            creaChartPositiveReviews(percentuale);
        } else {
            str += '<p class="text-muted">' + dati.gameTrend[index] + '</p>';
        }
    }

    $("#divChartMetacritic").hide(0);
    if (dati.gameMetacritic.length > 0) {
        creaChartMetacritic(dati.gameMetacritic);
    }

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
    $("#divChartSteamCharts").hide(0);
    $.ajax({
        url: "./controller.php?steam_appid=" + steam_appid + "&source=steamcharts",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                creaChartSteamCharts(response.avg, response.peak);
            },
            400: function () {
                toastr.error("Parametri errati per steam charts");
            },
            404: function () {
                ////toastr.info("Impossibile recuperari dati da steam charts per il gioco selezionato.");
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
                ////toastr.info("Impossibile recuperari dati da Twitch per il gioco selezionato.");
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
                ////toastr.info("Impossibile recuperari dati da Youtube per il gioco selezionato.");
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
                str += creaDivPrezzo("greenman", response.greenManGameURL, response.greenManPrice);
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Greenman");
            },
            404: function () {
                //toastr.info("Impossibile recuperari dati da Greenman per il gioco selezionato.");
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
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per G2A");
            },
            404: function () {
                //toastr.info("Impossibile recuperari dati da G2A per il gioco selezionato.");
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
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per Kinguin");
            },
            404: function () {
                //toastr.info("Impossibile recuperari dati da Kinguin per il gioco selezionato.");
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
                $("#cardPrezzi").html(str);
            },
            400: function () {
                toastr.error("Parametri errati per G2play");
            },
            404: function () {
                //toastr.info("Impossibile recuperari dati da G2play per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore G2play.");
            }
        }
    });
}

function creaDivPrezzo(nome, url, prezzo) {
    $("#cardPrezziPrincipale").show(0);
    return '<div class="col-md-4" style="text-align:center; padding:1%;"><a href="' + url + '" target="_blank"><img class="img-responsive" src="./logo' + nome + '.png"></img><label style="color:black; width:100%; background-color:white">' + prezzo + '€</label></a></div>';
}

function getSystemRequirement(steam_name) {
    if (steam_name == undefined) steam_name = global_name;
    $.ajax({
        url: "./controller.php?game=" + steam_name + "&source=sysreq",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                if (response.length == 0) {
                    $("#cardSystemRequirements").hide(0);
                    return; // TODO: Non deve accadere
                }
                response = response.sysReq;

                let min = response.min;
                let rec = response.rec;

                if (min != undefined || rec != undefined) {
                    $("#cardSystemRequirements").show(0);
                }

                let str;

                // Provo a stampare entrambi
                if (rec != undefined) {
                    str = '<table class="table" style="width:100%;"><thead><th style="text-align:center"><label>Specs</label></th><th style="text-align:center">Minimum</th><th style="text-align:center"><label>Recommended</label></th></thead><tbody>';
                } else {
                    str = '<table class="table" style="width:100%;"><thead><th colspan="2" style="text-align:center"><label>Minimum Specs</label></th></thead><tbody>';
                }
                for (index in min) {
                    if (index != "CPU" && index != "RAM" && index != "GPU") continue;
                    str += "<tr style=\"text-align:center;\"><td><label>" + index + "</label></td><td><label>" + min[index] + "</label></td>";
                    if (rec != undefined)
                        str += "<td><label>" + rec[index] + "</label></td>"
                }
                str += "</tbody></table>";
                $("#cardTableSystemRequirements").html(str);
                return;
            },
            400: function () {
                toastr.error("Parametri errati per Game System Requirements");
            },
            404: function () {
                $("#cardSystemRequirements").hide(0);
            },
            500: function () {
                toastr.error("Errore Game System Requirements.");
            }
        }
    });
}

function creaChartMetacritic(positive) {
    positive = Math.round(positive);
    $("#cardTrend").show(0);
    $("#divChartMetacritic").show(500);
    var myCircle = Circles.create({
        id: 'chartMetacritic',
        radius: 50,
        value: positive,
        maxValue: 100,
        width: 15,
        text: positive + '%',
        colors: ['#D3B6C6', '#4B253A'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        valueStrokeClass: 'circles-valueStroke',
        maxValueStrokeClass: 'circles-maxValueStroke',
        styleWrapper: true,
        styleText: true
    });
}

function creaChartPositiveReviews(positive) {
    $("#cardTrend").show(0);
    $("#divChartPositiveReviews").show(500);
    var myCircle = Circles.create({
        id: 'chartPositiveReviews',
        radius: 50,
        value: positive,
        maxValue: 100,
        width: 15,
        text: positive + '%',
        colors: ['#D3B6C6', '#4B253A'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        valueStrokeClass: 'circles-valueStroke',
        maxValueStrokeClass: 'circles-maxValueStroke',
        styleWrapper: true,
        styleText: true
    });
}

function creaChartPositiveReviewsLastMonth(positive) {
    $("#cardTrend").show(0);
    $("#divChartPositiveReviewsLastMonth").show(500);
    var myCircle = Circles.create({
        id: 'chartPositiveReviewsLastMonth',
        radius: 50,
        value: positive,
        maxValue: 100,
        width: 15,
        text: positive + '%',
        colors: ['#D3B6C6', '#4B253A'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        valueStrokeClass: 'circles-valueStroke',
        maxValueStrokeClass: 'circles-maxValueStroke',
        styleWrapper: true,
        styleText: true
    });
}

function creaChartSteamCharts(avg, max) {
    if (avg == undefined || max == undefined) return;
    $("#cardTrend").show(0);
    $("#chartSteamCharts").show(500);
    p = (100 * avg) / max;
    p = Math.round(p);
    $("#divChartSteamCharts").show(0);
    var myCircle = Circles.create({
        id: 'chartSteamCharts',
        radius: 50,
        value: p,
        maxValue: 100,
        width: 15,
        text: p + '%',
        colors: ['#D3B6C6', '#4B253A'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        valueStrokeClass: 'circles-valueStroke',
        maxValueStrokeClass: 'circles-maxValueStroke',
        styleWrapper: true,
        styleText: true
    });
}

function cercaByTag(index) {
    $("#modalTags").modal('hide');
    cerca(risultatiTags[index].name);
}

function cercaTags() {
    // Recupero tutti i tag
    let tagSelezionati = $('select').multipleSelect('getSelects');
    if (tagSelezionati.length == 0) {
        // Vedo se l'utente ha sbagliato a premere
        cercaNome();
        return;
    }

    // Chiamo il controller
    $.ajax({
        url: "./controller.php?tags=" + tagSelezionati + "&source=searchbytags",
        statusCode: {
            200: function (response) {
                response = JSON.parse(response);
                console.log(response.search.result);
                if (response.search.result == undefined) {
                    toastr.warning("No games found");
                    return;
                }

                // Popolo il modal con i risultati
                let str = "";
                response = response.search.result;
                risultatiTags = response;
                for (index in response) {
                    str += '<div class="row mustHilightOnHover" style="padding-bottom:2%;padding-top:2%" onclick="cercaByTag(' + index + ')">';
                    str += '<div class="col-md-4"><img class="img-responsive" src="' + response[index].icon + '"/></div>';
                    str += '<div class="col-md-8"><label>' + response[index].name + '</label></div>';
                    str += '</div>';
                }
                $("#contenutoModalTags").html(str);
                $("#modalTags").modal('show');
            },
            400: function () {
                toastr.error("Parametri errati per la ricerca con i tag.");
            },
            404: function () {
                //toastr.info("Impossibile recuperari dati da G2play per il gioco selezionato.");
            },
            500: function () {
                toastr.error("Errore di ricerca.");
            }
        }
    });
}

// Animazione di caricamento
$body = $("body");

$(document).on({
    ajaxStart: function () {
        $body.addClass("loading");
    },
    ajaxStop: function () {
        $body.removeClass("loading");
    }
});

// Funzioni utili

$(function () {
    $("#selectTags").multipleSelect({
        placeholder: 'Search by tags',
        selectAll: false,
        multiple: false,
        filter: true,
        width: "80%"
    });
    $('#selectTags').multipleSelect('uncheckAll');
});


function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}