<?php
    include "simple_html_dom.php";

    // // $steam_game_name = "dota 2";
    // include "wrappers/wrapper_twitch_topgames.php";
    // print_r($toReturn);


    $_GET['tags']="492%2C19";
    include "wrappers/wrapper_steam_searchbytag.php";
    print_r($toReturn);
?>