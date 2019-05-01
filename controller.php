<?php
    include "simple_html_dom.php";

    if(isset($_GET["game"])){
        if($_GET["game"]==""){
            echo "No game searched.";
        }else{
            $game = $_GET["game"];

            echo "<h2>Source Steam... </h2>";
            require "wrappers/wrapper_steam.php";
            echo "<h2>Source Steamcharts... </h2>";
            include "wrappers/wrapper_steamcharts.php";
        }       
    }else{
        echo "Error in the GET request.";
    }
?>