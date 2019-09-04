<?php
    /*
        Thread lanciati dall'utente, multiple richieste per lanciare multipli wrapper.

    */
    include "simple_html_dom.php";

    /*header("Qualcosa" . ' 500 Internal Server Error', true, 500);
    return;*/

    if(!isset($_GET["source"])){
        header("Source not set", true, 400);
        exit;
    }

    $toReturn = array();

    switch($_GET["source"]){
        case "steam":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
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
                header("Game not set", true, 400);
                exit; 
            }
            break;
        case "twitch":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Twitch
            include "wrappers/wrapper_twitch.php";
            break;
        case "youtube":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Youtube
            include "wrappers/wrapper_youtube.php";
            break;
        case "greenman":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // GreenMan Gaming
            include "wrappers/wrapper_greenman.php";
            break;
        case "g2a":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // G2A
            include "wrappers/wrapper_g2a.php";
            break;
        case "kinguin":
			if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Kinguin
            include "wrappers/wrapper_kinguin.php";
            break;
		case "g2play":
			if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // G2Play
            include "wrappers/wrapper_g2play.php";
            break;
        case "sysreq":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $steam_game_name = $_GET["game"];
            // Game System Requirements
            include "wrappers/wrapper_gamesystemrequirements.php";
            break;
        case "topf":
            // Twitch top 5
            include "wrappers/wrapper_twitch_topgames.php";
            break;
        case "searchbytags":
            if(!isset($_GET["tags"])){
                header("Tags not set", true, 400);
                exit;
            }
            // Steam Seach by TAGS
            include "wrappers/wrapper_steam_searchbytag.php";
            break;
        case "searchbyname":
            if(!isset($_GET["game"])){
                header("Game not set", true, 400);
                exit;
            }
            $game = $_GET["game"];
            // Steam Search by NAME
            include "wrappers/wrapper_steam_searchOnName.php";
            break;
        case "checksteam":
            if(!isset($_GET["twitchGame"])){
                header("Game not set", true, 400);
                exit;
            }
            $twitchGame = $_GET["twitchGame"];
            // Steam check game avaibility
            include "wrappers/wrapper_steam_checkgameavaibility.php";
            break;
    }
    header("Tappost", true, 200);
    echo json_encode($toReturn);
    return;
?>