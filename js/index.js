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

                let appId = dati.appId;

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

                // Descrizione
                $("#gameDescription").text(dati.gameDescription);

                // Trend
                // Forse è meglio con dei grafici
                let str = "";
                for(let index = 0; index < dati.gameTrend.length; index++){
                    str += '<p class="text-muted">' + dati.gameTrend[index] + '</p>';
                }
                str += '<p class="text-muted">Metacritic: ' + dati.gameMetacritic + '%</p>';
                $("#gameTrend").html(str);

                // ScreenShots
                str = "";
                let listaImmagini = "";
                for(let index=0; index < dati.gameScreenshot.length; index++){
                    str += '<li data-target="#carouselScreenshots" data-slide-to="' + index + '"' + (index==0?'class="active"':'') + '></li>';
                    listaImmagini += '<div class="item ' + (index==0?'active':'') + '"><center><img width="100%" src="' + dati.gameScreenshot[index] + '"></center></div>';
                }
                $("#carouselIndicatorsScreenshots").html(str);
                $("#carouselInnerScreenshots").html(listaImmagini);



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
            },
            500: function(response){
                let str = "Errore durante l'esecuzione della ricerca.";
                if(response != null){
                    str += "\nErrore: " + response;
                }
                alert(str);
            }
        }
    });
}