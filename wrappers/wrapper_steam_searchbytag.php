<?php
/*
    I tags sono contenuti nel file tags.json

*/
$curl = curl_init("https://store.steampowered.com/search/?ignore_preferences=1&category1=998");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_steam, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

?>