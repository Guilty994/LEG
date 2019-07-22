<?php
    /*
        Thread lanciati dall'utente, multiple richieste per lanciare multipli wrapper.

    */
    include "usefulFunctions.php";
    include "simple_html_dom.php";

    /*header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    return;*/

    if(!isset($_GET["source"])){
        header($_SERVER['SERVER_PROTOCOL'] . 'Bisogna settare la fonte', true, 400);
        return;
    }

    $toReturn = array();

    switch($_GET["source"]){
        case "steam":
            if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $game = $_GET["game"];
            require "wrappers/wrapper_steam.php";
            break;
        case "steamcharts":
            if(isset($_GET['steam_appid']) && $_GET['steam_appid'] != ""){
                $steam_appId = $_GET['steam_appid'];
                // Steamcharts
                include "wrappers/wrapper_steamcharts.php";
            }else{
                // no steam_appId
                header($_SERVER['SERVER_PROTOCOL'] . 'wrapper_steamcharts, steam_appId not set', true, 400);
                return; 
            }
            break;
        case "twitch":
            if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $steam_game_name = $_GET["game"];
            // Twitch
            include "wrappers/wrapper_twitch.php";
            break;
        case "youtube":
            if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $steam_game_name = $_GET["game"];
            // Youtube
            include "wrappers/wrapper_youtube.php";
            break;
        case "greenman":
            if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $steam_game_name = $_GET["game"];
            // GreenMan Gaming
            include "wrappers/wrapper_greenman.php";
            break;
        case "g2a":
            if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $steam_game_name = $_GET["game"];
            // G2A
            include "wrappers/wrapper_g2a.php";
            break;
        case "kinguin":
			if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $steam_game_name = $_GET["game"];
            // // Kinguin
            include "wrappers/wrapper_kinguin.php";
            break;
		// case "g2play":
			// if(!isset($_GET["game"])){
                // header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                // return;
            // }
            // $steam_game_name = $_GET["game"];
            // // // Kinguin
            // include "wrappers/wrapper_g2play.php";
            // break;
            case "sysreq":
            if(!isset($_GET["game"])){
                header($_SERVER['SERVER_PROTOCOL'] . "Bisogna settare il game", true, 400);
                return;
            }
            $steam_game_name = $_GET["game"];
            // Game System Requirements
            include "wrappers\wrapper_gamesystemrequirements.php";
            break;
    }
    header($_SERVER['SERVER_PROTOCOL'] . "", true, 200);
    echo json_encode($toReturn);
    return;
?>