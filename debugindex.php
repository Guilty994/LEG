<?php
    include "simple_html_dom.php";
    // $steam_game_name = "NARUTO SHIPPUDEN: Ultimate Ninja STORM 2";
    $toReturn = array();
    $toReturn['topFive'] = array(); 
   
    // include "wrappers/wrapper_gamesystemrequirements.php";
    // include "wrappers/wrapperg2play.php";
    // include "wrappers/wrapper_kinguin.php";

    
    include "wrappers\wrapper_twitch_topgames.php";
    echo 'before<br>';
    print_r($twitchTop);
    
   
    foreach($twitchTop as $twitchGame){
        include "wrappers\wrapper_stream_checkgameavaibility.php";
    }
    
    echo '<br> after <br>';
    print_r($toReturn);
    
?>