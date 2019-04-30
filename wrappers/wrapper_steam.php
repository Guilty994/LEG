<?php
    //search game su Steam
    $curl = curl_init("https://store.steampowered.com/search/?term=".$game);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Scraper error: ' . curl_error($curl);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    foreach($html->find('div') as $div){
        if($div->id == 'search_result_container'){
            foreach($div->find('a') as $a){
            $link = $a->href;
            break;
            }
        }
    }

    if(isset($link)){
        //ruba informazioni da steam
        $appId = str_replace("https://store.steampowered.com/app/", "", $link);//steam appid per il gioco
        $appId = substr($appId, 0, strpos($appId, "/"));
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl);
        if(curl_errno($curl)){
            echo 'Scraper error: ' . curl_error($curl);
            exit;
        }
        curl_close($curl);

        $html = new simple_html_dom();
        $html -> load($response);

        foreach($html->find('div') as $div){
            if($div->class == 'apphub_AppName'){
                $steam_game_name = $div->innertext; //nome del gioco corretto
                echo "Game name: ".$steam_game_name." <br>";
                break;
            }
        }
    }
    ?>