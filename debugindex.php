<?php
    include "simple_html_dom.php";

    // $steam_game_name = "dota 2";
    $steam_game_name = "league of maiden";
    echo "GameSystemRequirements";
    include "wrappers/wrapper_gamesystemrequirements.php";

    header("Tappost", true, 200);

    print_r($toReturn);
?>