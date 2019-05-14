<!DOCTYPE html>
<?php
    $cookie_name = "lastagecheckage";
    $cookie_value = "1-0-2000";
    $cookie_domain = "store.steampowered.com";
    $cookie_secure = 1;
    $cookie_httponly = 1;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/", $cookie_domain, $cookie_secure, $cookie_httponly);
    
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Import JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- import Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- Fonts and icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <!-- CSS della pagina -->
    <link rel="stylesheet" href="./index.css">
    <title>LEG</title>
</head>

<body>
    <!-- Barra di ricerca -->
    <div class="row" style="margin-top:1%">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="search-form">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="search" id="nomeGioco" placeholder="Cerca gioco"
                        onkeypress="handle(event)">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <!-- Barra logo -->
    <div class="row">
        <div class="col-md-12">
            <h1>LEG</h1>
        </div>
    </div>
    <div class="row" id="ricercheRecenti">
        <div class="col-md-12">
            <h3>Ricerche recenti:</h3>
            <div class="row">
                <div class="col-md-1"></div>
                <!-- TODO: Usare offset invece della colonna vuota -->
                <div class="col-md-10">
                    <table>
                        <thead></thead>
                        <tbody id="tbodyRicercheRecenti">
                            <p>Nessuna ricerca recente</p>
                        </tbody>
                    </table>
                </div>
                <!-- TODO: Usare offset invece della colonna vuota -->
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    <!-- Tutto il resto -->
    <div class="row"><div class="col-md-12" id="labelNomeGioco"></div></div>
    <div class="row">
        <!-- Locandina -->
        <div class="col-md-3" id="copertina"></div>
        <div class="col-md-9" id="info"></div>
    </div>
    <!-- Test -->
    <div class="row">
        <div class="col-md-12">
            <div id="resultDiv"></div>
        </div>
    </div>

    <!-- Modal per il caricamento -->
    <div class="modal"></div>

    <script>
        $body = $("body");

        $(document).on({
            ajaxStart: function () {
                $body.addClass("loading");
            },
            ajaxStop: function () {
                $body.removeClass("loading");
            }
        });

        function handle(e) {
            if (e.keyCode === 13) {
                e.preventDefault(); // Ensure it is only this code that rusn
                $("#ricercheRecenti").hide(500);
                cerca();
            }
        }

        function cerca() {
            $.ajax({
                url: "./controller.php?game=" + $("#nomeGioco").val(),
                success: function (response) {
                    let dati = JSON.parse(response.split("JSON")[1]);
                    console.log(dati);

                    // TODO: Modificare quando verranno tolte le altre echo
                    $("#resultDiv").html(response.split("JSON")[0]); 

                    $("#labelNomeGioco").html("<h1>" + dati.gameName + "</h1>");

                    $("#copertina").html('<img src="' + dati.gameImage + '"></img>');

                    let contenuto = "";
                    contenuto += "<p>";
                    contenuto += '<b>Description:</b> ' + dati.gameDescription + '<br>';
                    contenuto += '<b>Genre:</b> ';
                    for(let index = 0; index < dati.gameGenere.length; index++){
                        contenuto += dati.gameGenere[index];
                        if(index+1 != dati.gameGenere.length)
                            contenuto += ', ';
                    }
                    contenuto += '<br>';
                    contenuto += '<b>Developer:</b> ' + dati.gameDeveloper + '<br>';
                    contenuto += '<b>Publisher:</b> ';
                    for(let index = 0; index < dati.gamePublisher.length; index++){
                        contenuto += dati.gamePublisher[index];
                        if(index+1 != dati.gamePublisher.length)
                            contenuto += ', ';
                    }
                    contenuto += '<br>';
                    contenuto += '<b>Release date:</b> ' + dati.gameRelease + '<br>';
                    contenuto += '</p>';
                    $("#info").html(contenuto);
                }
            });
        }
    </script>
</body>

</html>