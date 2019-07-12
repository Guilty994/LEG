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
        statusCode: {
            200: function (response) {
                console.log(response);
                return;
                let dati = JSON.parse(response.split("JSON")[1]);
                console.log(dati);

                // TODO: Modificare quando verranno tolte le altre echo
                $("#resultDiv").html(response.split("JSON")[0]);

                if (dati.gameName == "") {
                    alert("Nessun gioco trovato");
                    //$("#labelNomeGioco").html("<h1>Nessun gioco trovato</h1>");
                    //$("#labelNomeGioco").text("Nessun gioco trovato");
                    return;
                }

                $("#risultatiRicerca").show(500);

                // Dati presi da Steam

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

                // Fine dati Steam


                $("#risultatiRicerca").show(500);
                return;
            },
            404: function(){
                alert("Impossibile trovate il gioco desiderato.");
                return;
            },
            400: function(){
                alert("Parametri inviati non corretti.");
                return;
            }
        }
    });
}