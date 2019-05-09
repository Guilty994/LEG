<?php
    //search game su Steam
    //Steam(Nome, Id, Descrizione, Genere, Sviluppatore, Publisher, Screenshot, DataRilascio, TrendDiApprezzamento, ScoreMetaCritic, ImmagineCopertina)
    //Steam($steam_game_name, $appId, $steam_game_description, $steam_game_genere, $steam_game_developer, $steam_game_publisher, $steam_screenshot, $steam_release_data, $staem_trend, $steam_metacritic, $steam_image )

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
        $steam_game_name = array();
        foreach($html->find('div') as $div){
            if($div->class == 'apphub_AppName'){
                array_push($steam_game_name, $div->innertext); 
                break;
            }
        }
        $toReturn["gameName"] = $steam_game_name;
        echo "<b>Game name: </b>".$steam_game_name[0]." <br>";

        //descrizione gioco
        $steam_game_description = array();
        foreach($html->find('div') as $div){
            if($div->class == 'game_description_snippet'){
                array_push($steam_game_description, $div->innertext); 
                break;
            }
        }   
        $toReturn["gameDescription"] = $steam_game_description;
        echo "<b>Game description: </b>".$steam_game_description[0]." <br>";
        
        //genere
        $steam_game_genere = array();
        foreach($html->find('div') as $div){
            if($div->class == 'details_block'){
                foreach($div->find('a') as $a){
                    if($a->parent()->class == 'details_block')
                        array_push($steam_game_genere, $a->innertext);
                }
                break;
            }
        }   

        $toReturn["gameGenere"] = $steam_game_genere;
        echo "<b>Game genere: </b>";
        $len = count($steam_game_genere);
        $i=0;
        foreach($steam_game_genere as $gen){
            if($i<$len-1)
                echo $gen.", ";
            else 
                echo $gen."<br>";
            $i++;
        }

        //developer
        $steam_game_developer = array();
        foreach($html->find('div') as $div){
            if($div->class == 'dev_row'){
                foreach($div->find('a') as $a){
                    array_push($steam_game_developer, $a->innertext);       
                }
                break;
            }
        }  
        
        $toReturn["gameDeveloper"] = $steam_game_developer;
        echo "<b>Game developer: </b>".$steam_game_developer[0]." <br>";
        
        //publisher
        $steam_game_publisher = array();
        foreach($html->find('div') as $div){
            if($div->class == 'dev_row'){
                foreach($div->find('div') as $div_internal){
                    if($div_internal->class == 'summary column'){
                        if(isset($not_publisher)){
                            foreach($div_internal->find('a') as $a){
                                array_push($steam_game_publisher, $a->innertext);
                            }
                        }
                        else
                            $not_publisher = 1;
                    }
                }                
                
            }
            
        }

        $toReturn["gamePublisher"] = $steam_game_publisher;    
        echo "<b>Game publisher: </b>";
        $len = count($steam_game_publisher);
        $i=0;
        foreach($steam_game_publisher as $pub){
            if($i<$len-1)
                echo $pub.", ";
            else 
                echo $pub."<br>";
            $i++;
        }


        //steam screenshot
        $steam_screenshot = array();
        foreach($html->find('div') as $div){
            if($div->class == 'highlight_player_item highlight_screenshot'){
                foreach($div->find('a') as $a){
                    if($a->class == 'highlight_screenshot_link')
                    array_push($steam_screenshot, $a->href);     
                }
            }
        }

        $toReturn["gameScreenshot"] = $steam_screenshot;    
        echo "<b>Game screenshot: </b>";
        echo "<br>";
        foreach($steam_screenshot as $scr){
            echo $scr."<br>";
        }


        //steam_release_data
        $steam_release_data = array();
    }
?>