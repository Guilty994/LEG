<?php

    $curl = curl_init("https://gamesystemrequirements.com/search?q=".urlencode($steam_game_name));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo "<script>console.log( 'wrapper_steam ERROR' );</script>";
        echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    foreach($html->find('td') as $td){
        if($td->class == 'tbl1'){
            foreach($td->find('a') as $a){
                $link = $a->href;
                break;
            }
        }
    }

    //////////// da continuare





?>