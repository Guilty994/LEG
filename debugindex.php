<?php
    include "simple_html_dom.php";

    $toReturn = array();

    if(!isset($_GET["game"])){
        header("Game not set", true, 400);
        exit;
    }
    $game = $_GET["game"];
    include "wrappers/wrapper_steam_searchOnName.php";

    print_r($toReturn);
?>