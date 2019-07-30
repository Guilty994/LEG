<?php
    $mod_steam_game_name = preg_replace("/[^a-zA-Z0-9\s\:\,]/", "", $steam_game_name);
    $curl = curl_init("https://gamesystemrequirements.com/search?q=".urlencode($mod_steam_game_name));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_gamesystemrequirements, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    foreach($html->find('div') as $div){
        if($div->class == 'main-container'){
            foreach($div->find('table') as $table){
                foreach($table->find('td') as $td){
                    if($td->class == 'tbl1'){
                        foreach($td->find('a') as $a){
                            $link = "https://gamesystemrequirements.com/" . $a->href;
                            break;
                        }
                        break;
                    }
                }                
            }
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
                                        // $index =  'min' . preg_replace("/[^a-zA-Z0-9\s\,]/", "", $plain_text);
                                        $index = preg_replace("/[^a-zA-Z0-9\s\,]/", "", $plain_text);
                                        $colCounter++;
                                    }else if($colCounter == 1){
                                        // $toReturn['sysReq'][$index] = $plain_text;
                                        $toReturn['sysReq']['min'][$index] = $plain_text;
                                        $colCounter++;
                                    }else if($colCounter == 2){
                                        // $index =  'rec' . preg_replace("/[^a-zA-Z0-9\s\,]/", "", $plain_text);
                                        $index = preg_replace("/[^a-zA-Z0-9\s\,]/", "", $plain_text);
                                        $colCounter++;
                                    }
                                    else{
                                        // $toReturn['sysReq'][$index] = $plain_text;
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
        header("wrapper_gamesystemrequirements, link not set", true, 404);
    }  

?>