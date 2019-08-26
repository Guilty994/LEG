<?php
    $mod_steam_game_name = preg_replace("/[^a-zA-Z0-9\s\:\,\']/", "", $steam_game_name);
    //$mod_steam_game_name = preg_replace("/[^a-zA-Z0-9]/", " ", strtolower($mod_steam_game_name));
    $mod_steam_game_name = rawurlencode($mod_steam_game_name);
    $mod_steam_game_name = preg_replace("/(%20%20.*)$/","",$mod_steam_game_name);

    $curl = curl_init("https://gamesystemrequirements.com/search?q=".$mod_steam_game_name);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_gamesystemrequirements, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    $shortest = -1;
    foreach($html->find('div.main-panel table tr td.tbl1') as $result){
        $t = $result->firstChild()->plaintext;
        $t = rawurlencode($t);
        $t = preg_replace("/(%20%20.*)$/","",$t);
        $lev = levenshtein($t, $mod_steam_game_name);
        if ($lev == 0) {
            // Trovato
            $link = "https://gamesystemrequirements.com/" . $result->firstChild()->href;
            break;
        }
        if ($lev <= $shortest || $shortest < 0) {
            // set the closest match, and shortest distance
            $link = "https://gamesystemrequirements.com/" . $result->firstChild()->href;
            $shortest = $lev;
        }

    }

    if(isset($link)){
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        
        $response = curl_exec($curl);
        if(curl_errno($curl)){
            header("wrapper_gamesystemrequirements, Scraper error: " . curl_error($curl), true, 500);
            exit;
        }
        curl_close($curl);

        $html = new simple_html_dom();
        $html -> load($response);

        $counter = 0;
        foreach($html->find('div') as $div){
            if($div->class == 'srb_tab'){
                if($counter == 0){
                    $counter++;
                }else{
                    foreach($div->find('div') as $row){
                        if($row->class == 'srb_row'){
                            $colCounter = 0;
                            foreach($row->find('div') as $col){
                                if($col->class == 'tbl'){
                                    $plain_text = $col->plaintext;
                                    if(strpos($plain_text, 'https') !== false){
                                        $plain_text = substr($plain_text, 0, strpos($plain_text, "https"));
                                    }
                                    if($colCounter == 0){
                                        $index = preg_replace("/[^a-zA-Z0-9\s\,]/", "", $plain_text);
                                        $colCounter++;
                                    }else if($colCounter == 1){
                                        $toReturn['sysReq']['min'][$index] = $plain_text;
                                        $colCounter++;
                                    }else if($colCounter == 2){
                                        $index = preg_replace("/[^a-zA-Z0-9\s\,]/", "", $plain_text);
                                        $colCounter++;
                                    }
                                    else{
                                        $toReturn['sysReq']['rec'][$index] = $plain_text;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }else{
        header("Link not set", true, 404);
        exit;
    }  

?>