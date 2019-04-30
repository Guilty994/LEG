<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <input type="text" placeholder="Nome del gioco" id="nomeGioco"><button onclick="cerca()">Cerca</button>
    <div id="resultDiv"></div>
    <script>
        function cerca(){
            $.ajax({
            url:"./controller.php?game=" + $("#nomeGioco").val(),
            success: function(response){
                $("#resultDiv").html(response);
            }
        });
        }
    </script>
</body>
</html>

