<?php
    /*
        Thread lanciati dall'utente, multiple richieste per lanciare multipli wrapper.

    */
    include "usefulFunctions.php";
    include "simple_html_dom.php";

    /*header("Qualcosa" . ' 500 Internal Server Error', true, 500);
    return;*/

    if(!isset($_GET["source"])){
        header("Qualcosa", true, 400);
        exit;
    }

    $toReturn = array();

    switch($_GET["source"]){
        case "steam":
            if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
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
                header("Qualcosa", true, 400);
                exit; 
            }
            break;
        case "twitch":
            if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Twitch
            include "wrappers/wrapper_twitch.php";
            break;
        case "youtube":
            if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Youtube
            include "wrappers/wrapper_youtube.php";
            break;
        case "greenman":
            if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // GreenMan Gaming
            include "wrappers/wrapper_greenman.php";
            $toReturn["Daniele"] = "TEST";
            break;
        case "g2a":
            if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // G2A
            include "wrappers/wrapper_g2a.php";
            break;
        case "kinguin":
			if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Kinguin
            include "wrappers/wrapper_kinguin.php";
            break;
		case "g2play":
			if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // G2Play
            include "wrappers/wrapper_g2play.php";
            break;
        case "sysreq":
            if(!isset($_GET["game"])){
                header("Qualcosa", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Game System Requirements
            include "wrappers\wrapper_gamesystemrequirements.php";
            break;
        case "topf":
            // Twitch top 5
            include "wrappers\wrapper_twitch_topgames.php";
            break;
    }
    header("Qualcosa", true, 200);
    echo json_encode($toReturn);
    return;
?>