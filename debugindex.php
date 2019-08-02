<?php
    include "simple_html_dom.php";

    $toReturn = array();

    $_GET['tags']="19,21,9";
    if(!isset($_GET["tags"])){
        header("Tags not set", true, 400);
        exit;
    }
    $tags_tosearch = $_GET['tags'];
    $tags_tosearch = str_replace (",", "%2C", $tags_tosearch);

    include "wrappers/wrapper_steam_searchbytag.php";
?>