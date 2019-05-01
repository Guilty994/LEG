<?php
    //search game su Steam
    //Steam(Nome, Id, Descrizione, Genere, Sviluppatore, Editore, Screenshot, DataRilascio, TrendDiApprezzamento, ScoreMetaCritic)
    //Steam($steam_game_name, $appId, $steam_game_description, $steam_game_genere, $steam_game_developer, $steam_game_publisher, )

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

        //nome del gioco corretto
        foreach($html->find('div') as $div){
            if($div->class == 'apphub_AppName'){
                $steam_game_name = $div->innertext; 
                break;
            }
        }
        echo "<b>Game name: </b>".$steam_game_name." <br>";

        //descrizione gioco
        foreach($html->find('div') as $div){
            if($div->class == 'game_description_snippet'){
                $steam_game_description = $div->innertext; 
                
                break;
            }
        }   
        echo "<b>Game description: </b>".$steam_game_description." <br>";
        
        //genere
        foreach($html->find('div') as $div){
            if($div->class == 'details_block'){
                foreach($div->find('a') as $a){
                    if(isset($steam_game_genere)){
                       if($a->parent()->class == 'details_block')
                            $steam_game_genere = $steam_game_genere.", ".$a->innertext;
                    }else{
                        if($a->parent()->class == 'details_block')
                            $steam_game_genere = $a->innertext;
                    }
                }
                break;
            }
        }   

        echo "<b>Game genere: </b>".$steam_game_genere." <br>";

        //developer
        foreach($html->find('div') as $div){
            if($div->class == 'dev_row'){
                foreach($div->find('a') as $a){
                    $steam_game_developer = $a->innertext;       
                }
                break;
            }
        }  
        
        echo "<b>Game developer: </b>".$steam_game_developer." <br>";
        
        //publisher ######################
        // foreach($html->find('div') as $div){
        //     $i=0;
        //     if($div->class == 'dev_row'){ 
        //         foreach($div->find('a') as $a){
        //             if($i>0){
        //                 if(isset($steam_game_publisher)){
        //                     $steam_game_publisher= $steam_game_publisher.", ".$a->innertext; 
        //                 }else{
        //                     $steam_game_publisher= $a->innertext; 
        //                 }
        //             }else{
        //                 $i++;
        //             }
        //         }
        //     }
        // }  

        // echo "Game publisher: ".$steam_game_publisher." <br>";
    }
?>