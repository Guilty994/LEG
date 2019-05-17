<?php
    include "simple_html_dom.php";

    if(isset($_GET["game"]) && isset($_GET["source"])){
        if($_GET["game"]==""){
            echo "<script>console.log( 'No game was searched.' );</script>";// bisogna gestire il fatto che non viene generato alcun json
        }if($_GET["source"]==""){
            echo "<script>console.log( 'No source was selected.' );</script>";
        }else{
            $toReturn = array();// Array dove mettere le cose
            $game = $_GET["game"];

            // switch basato sulle source da interrogare
            switch($_GET['source']){
                case "steam":
                // Steam
                require "wrappers/wrapper_steam.php";
                echo "<script>console.log( 'wrapper_steam EXECUTED' );</script>";
                if(isset($steam_game_name)){
                    if(isset($steam_appId)){

                        // Steamcharts
                        include "wrappers/wrapper_steamcharts.php";
                        echo "<script>console.log( 'wrapper_steamcharts EXECUTED' );</script>";
                    }else{

                        // no steam_appId
                        echo "<script>console.log( 'wrapper_steamcharts ERROR' );</script>";
                        echo "<script>console.log( 'steam_appId not set' );</script>";    
                    }

                    // Twitch
                    include "wrappers/wrapper_twitch.php";
                    echo "<script>console.log( 'wrapper_twtich EXECUTED' );</script>";

                    // Youtube
                    include "wrappers/wrapper_youtube.php";
                    echo "<script>console.log( 'wrapper_youtube EXECUTED' );</script>";
					
					//Kinguin
					include "wrappers/wrapper_kinguin.php";
					echo "<script>console.log( 'wrapper_kinguin EXECUTED' );</script>";
					
					//GreenMan Gaming
					include "wrappers/wrapper_greenman.php";
					echo "<script>console.log( 'wrapper_greenmangaming EXECUTED' );</script>";
					
					//G2A
					include "wrappers/wrapper_g2a.php";
					echo "<script>console.log( 'wrapper_g2a EXECUTED' );</script>";
					
                }else{
                    // no steam_game_name
                    echo "<script>console.log( 'wrappers ERROR' );</script>";
                    echo "<script>console.log( 'steam_game_name not set' );</script>";
                }
                
                echo "JSON"; // Da rimuovere quando verranno rimosse le altre echo
                echo json_encode($toReturn);

                break;
            }  
        }       
    }else{
        echo "<script>console.log( 'Error in the GET request.' );</script>";
        echo "<script>console.log( '_GET['game'] =".$_GET['game'].");</script>";
        echo "<script>console.log( '_GET['source'] =".$_GET['source'].");</script>";
    }
?>