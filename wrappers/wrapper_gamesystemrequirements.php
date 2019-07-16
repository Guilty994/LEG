<?php
    // testing 
    include "simple_html_dom.php";
    $steam_game_name = "Rocket League®";
    
    // testing end


    $mod_steam_game_name = preg_replace("/[^a-zA-Z0-9\s\:\,]/", "", $steam_game_name);
    $curl = curl_init("https://gamesystemrequirements.com/search?q=".urlencode($mod_steam_game_name));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_gamesystemrequirements, Scraper error: " . curl_error($curl), true, 400);
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
            header($_SERVER['SERVER_PROTOCOL'] . "wrapper_gamesystemrequirements, Scraper error: " . curl_error($curl), true, 400);
            exit;
        }
        curl_close($curl);

        $html = new simple_html_dom();
        $html -> load($response);

        echo $html;
        



    }else{
        header($_SERVER['SERVER_PROTOCOL'] . "wrapper_gamesystemrequirements, link not set", true, 400);
    }
    
?>