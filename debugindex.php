<?php
    include "simple_html_dom.php";

    $toReturn = array();

    $_GET['tags']="19%2C21%2C9";
    if(!isset($_GET["tags"])){
        header("Tags not set", true, 400);
        exit;
    }

    include "wrappers/wrapper_steam_searchbytag.php";

    print_r($toReturn);
?>