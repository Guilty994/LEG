<?php
    $curl = curl_init("https://store.steampowered.com/search/?term=".$twitchGame."&category1=998");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_steam, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    foreach($html->find('div') as $div){
        if($div->id == 'search_result_container'){
            foreach($div->find('span') as $span){
                if($span->class == 'title'){
                    $resultSteam_name = $span->innertext;
                    break;
                }
            }
        }
    }

    foreach($html->find('div') as $div){
        if($div->class == 'col search_capsule'){
            foreach($div->find('img') as $img){
                $resultSteam_img = $img->src;
                break;
            }
        }
    }
    $game_obj = new Game($resultSteam_name, $resultSteam_img);

    //check matching steam-twitch
    if(strtolower(preg_replace("/[^a-zA-Z0-9\s]/", "", $resultSteam_name)) == strtolower(preg_replace("/[^a-zA-Z0-9\s]/", "", $twitchGame))){
        array_push($toReturn['topFive'], $game_obj);
    }
?>