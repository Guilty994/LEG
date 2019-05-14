<?php
    include "simple_html_dom.php";

    if(isset($_GET["game"])){
        if($_GET["game"]==""){
            echo "<script>console.log( 'No game was searched.' );</script>";// bisogna gestire il fatto che non viene generato alcun json
        }else{
            $toReturn = array(); // Array dove mettere le cose
            $game = $_GET["game"];

            // echo "<h2>Source Steam... </h2>";
            require "wrappers/wrapper_steam.php";
            echo "<script>console.log( 'wrapper_steam OK' );</script>";
            if(isset($steam_game_name)){
                if(isset($steam_appId)){
                    // echo "<h2>Source Steamcharts... </h2>";
                    include "wrappers/wrapper_steamcharts.php";
                    echo "<script>console.log( 'wrapper_steamcharts OK' );</script>";
                }else{
                    // no steam_appId
                    echo "<script>console.log( 'wrapper_steamcharts NOT OK' );</script>";
                    echo "<script>console.log( 'steam_appId not set' );</script>";
                    
                }
                // echo "<h2>Kinguin price..</h2>";
                // include "wrappers/wrapper_kinguin.php";
                // echo "<h2> Greenman Gaming price..</h2>";
                // include "wrappers/wrapper_greenman.php";
                // echo "<h2> G2A price..</h2>";
                // include "wrappers/wrapper_g2a.php";
            }else{
                // no steam_game_name
                echo "<script>console.log( 'wrappers NOT OK' );</script>";
                echo "<script>console.log( 'steam_game_name not set' );</script>";
            }
            
            echo "JSON"; // Da rimuovere quando verranno rimosse le altre echo
            echo json_encode($toReturn);
			
        }       
    }else{
        echo "Error in the GET request.";
    }
?>