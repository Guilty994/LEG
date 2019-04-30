<?php
    include "simple_html_dom.php";

    if(isset($_GET["game"])){
        if($_GET["game"]==""){
            echo "No game searched.";
        }else{
            $game = $_GET["game"];

            echo "Source Steam... <br>";
            require "wrappers/wrapper_steam.php";
            echo "Source Steamcharts... <br>";
            include "wrappers/wrapper_steamcharts.php";
        }       
    }else{
        echo "Error in the GET request.";
    }
?>