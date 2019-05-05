<!DOCTYPE html>
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
    <!-- Tutto il resto -->
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
                cerca();
            }
        }

        function cerca() {
            $.ajax({
                url: "./controller.php?game=" + $("#nomeGioco").val(),
                success: function (response) {
                    $("#resultDiv").html(response);
                }
            });
        }
    </script>
</body>

</html>