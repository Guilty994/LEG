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
        cerca();
    }
}

function cerca() {
    if ($("#nomeGioco").val().length == 0) return;
    $("#ricercheRecenti").hide(500);
    $.ajax({
        url: "./controller.php?game=" + $("#nomeGioco").val() + "&source=steam", // &source=steam aggiunto per testing poi si vede come fare
        success: function (response) {
            let dati = JSON.parse(response.split("JSON")[1]);
            console.log(dati);

            // TODO: Modificare quando verranno tolte le altre echo
            $("#resultDiv").html(response.split("JSON")[0]);

            if (dati.gameName == "") {
                //$("#labelNomeGioco").html("<h1>Nessun gioco trovato</h1>");
                $("#labelNomeGioco").text("Nessun gioco trovato");
                return;
            }

            // Dati presi da Steam

            //$("#labelNomeGioco").html("<h1>" + dati.gameName + "</h1>");
            $("#labelNomeGioco").text(dati.gameName);

            //$("#copertina").html('<img class="img-responsive" src="' + dati.gameImage + '"></img>');
            $("#copertina").attr("src", dati.gameImage);

            let contenuto = "";
            contenuto += "<p>";
            contenuto += '<b>Description:</b> ' + dati.gameDescription + '<br>';
            contenuto += '<b>Genre:</b> ';
            for (let index = 0; index < dati.gameGenere.length; index++) {
                contenuto += dati.gameGenere[index];
                if (index + 1 != dati.gameGenere.length)
                    contenuto += ', ';
            }
            contenuto += '<br>';
            contenuto += '<b>Developer:</b> ' + dati.gameDeveloper + '<br>';
            contenuto += '<b>Publisher:</b> ';
            for (let index = 0; index < dati.gamePublisher.length; index++) {
                contenuto += dati.gamePublisher[index];
                if (index + 1 != dati.gamePublisher.length)
                    contenuto += ', ';
            }
            contenuto += '<br>';
            contenuto += '<b>Release date:</b> ' + dati.gameRelease + '<br>';

            contenuto += '</p>';
            $("#info").html(contenuto);
            // Fine dati Steam


            $("#risultatiRicerca").show(500);
        }
    });
}