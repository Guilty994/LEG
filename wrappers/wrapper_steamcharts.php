<?php
    //steam charts
    $curl = curl_init("https://steamcharts.com/app/".$appId);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Scraper error: ' . curl_error($curl);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);
    foreach($html->find('td') as $td){
        if($td->class == 'right num-f italic'){
            echo "<b>Avg players last 30 days: </b>".$td->innertext."<br>"; //avg players last 30 days
        }
        if($td->class == 'right num italic'){
            echo "<b>Peak players: </b>".$td->innertext."<br>"; //peak players
        }
    }
?>