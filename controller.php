<?php
    /*
        Thread lanciati dall'utente, multiple richieste per lanciare multipli wrapper.

    */
    include "usefulFunctions.php";
    include "simple_html_dom.php";

    /*header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    return;*/
    
    if(isset($_GET["game"]) && isset($_GET["source"])){
        if($_GET["game"]==""){
            header($_SERVER['SERVER_PROTOCOL'] . 'Nessun gioco cercato', true, 400);
            return;
            //echo "<script>console.log( 'No game was searched.' );</script>";// bisogna gestire il fatto che non viene generato alcun json
        }if($_GET["source"]==""){
            header($_SERVER['SERVER_PROTOCOL'] . 'Nessuna fonte selezionata', true, 400);
            return;
            //echo "<script>console.log( 'No source was selected.' );</script>";
        }else{
            $toReturn = array();// Array dove mettere le cose
            $game = $_GET["game"];

            // // Prova risposta positiva
            // $toReturn["gameName"] = $game;
            // header($_SERVER['SERVER_PROTOCOL'] . "200", true, 200);
            // echo json_encode($toReturn); // Per mandare la risposta
            // return;

            // switch basato sulle source da interrogare

            if($_GET['source'] == "steam"){
                // Steam
                require "wrappers/wrapper_steam.php";
                header($_SERVER['SERVER_PROTOCOL'] . "wrapper_steam EXECUTED", true, 200);
            }else{                  
                if((isset($_GET['steam_game_name'])) && ($_GET['steam_game_name'] != "")){
                    $steam_game_name = $_GET['steam_game_name'];
                    switch($_GET['source']){
                        case "steamcharts":
                        if(isset($_GET['steam_appid']) && $_GET['steam_appid'] != ""){
                            $steam_appId = $_GET['steam_appid'];
                            // Steamcharts
                            include "wrappers/wrapper_steamcharts.php";
                            header($_SERVER['SERVER_PROTOCOL'] . "wrapper_steamcharts EXECUTED", true, 200);
                            // echo "<script>console.log( 'wrapper_steamcharts EXECUTED' );</script>";
                        }else{
                            // no steam_appId
                            header($_SERVER['SERVER_PROTOCOL'] . 'wrapper_steamcharts, steam_appId not set', true, 400);
                            // echo "<script>console.log( 'wrapper_steamcharts ERROR' );</script>";
                            // echo "<script>console.log( 'steam_appId not set' );</script>";    
                        }
                        break;
                            
                        case "twitch":
                        // Twitch
                        include "wrappers/wrapper_twitch.php";
                        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_twtich EXECUTED", true, 200);
                        // echo "<script>console.log( 'wrapper_twtich EXECUTED' );</script>";
                        break;
        
                        case "youtube":
                        // Youtube
                        include "wrappers/wrapper_youtube.php";
                        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_youtube EXECUTED", true, 200);
                        // echo "<script>console.log( 'wrapper_youtube EXECUTED' );</script>";
                        break;
        
                        case "kinguin":
                        // // Kinguin
                        // include "wrappers/wrapper_kinguin.php";
                        // echo "<script>console.log( 'wrapper_kinguin EXECUTED' );</script>";
                        break;

                        case "greenman":
                        // GreenMan Gaming
                        include "wrappers/wrapper_greenman.php";
                        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_greenmangaming EXECUTED", true, 200);
                        // echo "<script>console.log( 'wrapper_greenmangaming EXECUTED' );</script>";
                        break;

                        case "g2a":
                        // G2A
                        include "wrappers/wrapper_g2a.php";
                        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_g2a EXECUTED", true, 200);
                        // echo "<script>console.log( 'wrapper_g2a EXECUTED' );</script>";
                        break;
                    }
                }else{
                    // no steam_game_name
                    header($_SERVER['SERVER_PROTOCOL'] . 'wrappers, steam_game_name not set', true, 400);
                    // echo "<script>console.log( 'wrappers ERROR' );</script>";
                    // echo "<script>console.log( 'steam_game_name not set' );</script>";
                }
            }
            //echo "JSON"; // Da rimuovere quando verranno rimosse le altre echo
            header($_SERVER['SERVER_PROTOCOL'] . '200', true, 200);
            echo json_encode($toReturn);
        }       
    }else{
        header($_SERVER['SERVER_PROTOCOL'] . "GET request, _GET['game'] =".$_GET['game'] . " _GET['source'] =".$_GET['source'], true, 400);
        // echo "<script>console.log( 'Error in the GET request.' );</script>";
        // echo "<script>console.log( '_GET['game'] =".$_GET['game'].");</script>";
        // echo "<script>console.log( '_GET['source'] =".$_GET['source'].");</script>";
    }
?>