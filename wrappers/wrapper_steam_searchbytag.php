<?php
    /*
        I tags sono contenuti nel file tags.json
    */
    //encoding tags 
    // controllo tags delegato a controller

    $curl = curl_init("https://store.steampowered.com/search/?ignore_preferences=1&tags=" . $tags_tosearch . "&category1=998");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_steam, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    foreach($html->find('span') as $span){
        if($span->class == 'title'){
            echo $span . '<br>';
        }
    }

?>