<?php
   include "simple_html_dom.php";

    $curl = curl_init("https://gamesystemrequirements.com/gpu/database");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Scraper error: ' . curl_error($curl);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);
    $schedeVideo = array();
    $toAdd;
    
    foreach($html->find('td a') as $a){
        if(strpos($a->innertext,"img") !== false){
            $toAdd = $a->text();
        }else{
            $toAdd = $a->innertext;
        }
        array_push($schedeVideo, $toAdd);
    }

    $fp = fopen('./gpu.json', 'w');
    fwrite($fp, json_encode($schedeVideo));
    fclose($fp);
?>