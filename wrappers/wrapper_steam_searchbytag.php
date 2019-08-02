<?php
    /*
        I tags sono contenuti nel file tags.json
        I risultati della ricerca sono salvati su toReturn[]
    */
    $index = 0;
    foreach(explode("%2C", $_GET['tags'])as $tag){
        $toReturn['search']['tags'][$index] = $tag;
        $index++;
    }

    // $_GET['tags'] = str_replace (",", "%2C", $_GET['tags']);

    $curl = curl_init("https://store.steampowered.com/search/?ignore_preferences=1&tags=" . $_GET['tags'] . "&category1=998");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_steam, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);
    
    //0 to 24
    $index = 0;
    foreach($html->find('span') as $span){
        if($span->class == 'title'){
            $toReturn['search']['result'][$index] = $span->innertext;
            $index++;
        }
    }
?>