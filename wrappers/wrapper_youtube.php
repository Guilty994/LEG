<?php
    $url_encoded = "https://www.youtube.com/results?search_query=".urlencode($steam_game_name)."+gameplay";
    
    $curl = curl_init($url_encoded);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo "<script>console.log( 'wrapper_youtube ERROR' );</script>";
        echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
        exit;
    }
    curl_close($curl);

    echo $response;



?>