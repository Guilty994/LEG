<?php
    //search game su Steam
    //Steam(Nome, Id, Descrizione, Genere, Sviluppatore, Publisher, Screenshot, DataRilascio, TrendDiApprezzamento, ScoreMetaCritic, ImmagineCopertina)
    //Steam($steam_game_name, $appId, $steam_game_description, $steam_game_genere, $steam_game_developer, $steam_game_publisher, $steam_screenshot, $steam_release_date, $staem_trend, $steam_metacritic, $steam_image )
    //(gametrend, metacritic non sono sempre presenti)
    $curl = curl_init("https://store.steampowered.com/search/?term=".$game."&category1=998");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo "<script>console.log( 'wrapper_steam ERROR' );</script>";
        echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
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
        // ruba informazioni da steam
        
        $link = substr($link, 0, strpos($link, "?"));
        $steam_appId = str_replace("https://store.steampowered.com/app/", "", $link);// steam appid per il gioco
        $steam_appId = substr($steam_appId, 0, strpos($steam_appId, "/"));
        $toReturn["appId"] = $steam_appId;
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');// specifica locazione dei cookie da leggere
        // curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie_read.txt');// specifica locazione in cui sono scritti i cookie che erano presenti
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($curl);
        if(curl_errno($curl)){
            echo "<script>console.log( 'wrapper_steam ERROR' );</script>";
            echo "<script>console.log( 'Scraper error: " . curl_error($curl) . "' );</script>";
            exit;
        }
         
        curl_close($curl);

        $html = new simple_html_dom();
        $html -> load($response);

        // nome del gioco corretto
        foreach($html->find('div') as $div){
            if($div->class == 'apphub_AppName'){
                $steam_game_name = $div->innertext;
                break;
            }
        }
        if(isset($steam_game_name)){
            $toReturn["gameName"] = $steam_game_name;
        }else{
            $toReturn["gameName"] = "";
        }
        // echo "<b>Game name: </b>".$steam_game_name." <br>";

        //descrizione gioco
        foreach($html->find('div') as $div){
            if($div->class == 'game_description_snippet'){
                $steam_game_description = $div->innertext; 
                break;
            }
        }
        if(isset($steam_game_description)){
            $toReturn["gameDescription"] = $steam_game_description;
        }else{
            $toReturn["gameDescription"] = "";
        }
        // echo "<b>Game description: </b>".$steam_game_description." <br>";
        
        // genere
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
        if(isset($steam_game_genere)){
            $toReturn["gameGenere"] = $steam_game_genere;
        }else{
            $toReturn["gameGenere"] = "";
        }
        // echo "<b>Game genere: </b>";
        // $len = count($steam_game_genere);
        // $i=0;
        // foreach($steam_game_genere as $gen){
        //     if($i<$len-1)
        //         echo $gen.", ";
        //     else 
        //         echo $gen."<br>";
        //     $i++;
        // }

        // developer
        foreach($html->find('div') as $div){
            if($div->class == 'dev_row'){
                foreach($div->find('a') as $a){
                    $steam_game_developer = $a->innertext;       
                }
                break;
            }
        }  
        if(isset($steam_game_developer)){
            $toReturn["gameDeveloper"] = $steam_game_developer;
        }else{
            $toReturn["gameDeveloper"] = "";
        }
        
        // echo "<b>Game developer: </b>".$steam_game_developer." <br>";
        
        // publisher
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
        if(isset($steam_game_publisher)){
            $toReturn["gamePublisher"] = $steam_game_publisher;
        }else{
            $toReturn["gamePublisher"] = "";
        }
            
        // echo "<b>Game publisher: </b>";
        // $len = count($steam_game_publisher);
        // $i=0;
        // foreach($steam_game_publisher as $pub){
        //     if($i<$len-1)
        //         echo $pub.", ";
        //     else 
        //         echo $pub."<br>";
        //     $i++;
        // }

        // steam screenshot
        $steam_screenshot = array();
        foreach($html->find('div') as $div){
            if($div->class == 'highlight_player_item highlight_screenshot'){
                foreach($div->find('a') as $a){
                    if($a->class == 'highlight_screenshot_link')
                    array_push($steam_screenshot, $a->href);     
                }
            }
        }

        if(isset($steam_screenshot)){
            $toReturn["gameScreenshot"] = $steam_screenshot;
        }else{
            $toReturn["gameScreenshot"] = "";
        }
    
        // echo "<b>Game screenshot: </b>";
        // echo "<br>";
        // foreach($steam_screenshot as $scr){
        //     echo $scr."<br>";
        // }

        // steam_release_date
        foreach($html->find('div') as $div){
            if($div->class == 'date'){
                $steam_release_date = $div->innertext; 
            }
        } 
        if(isset($steam_release_date)){
            $toReturn["gameRelease"] = $steam_release_date;
        }else{
            $toReturn["gameRelease"] = "";
        } 
        
        // echo "<b>Game release date: </b>".$steam_release_date." <br>"; 

        //steam_trend
        $steam_trend = array();
        foreach($html->find('div') as $div){
            if($div->class == 'user_reviews_summary_row'){
                foreach($div->find('span') as $span){
                    if($span->class =='nonresponsive_hidden responsive_reviewdesc'){
                        array_push($steam_trend, $span->innertext);
                    }
                }
            }
        }  
        if(isset($steam_trend)){
            $toReturn["gameTrend"] = $steam_trend;
        }else{
            $toReturn["gameTrend"] = "";
        }

        // echo "<b>Game trend: </b>"; 
        // $len = count($steam_trend);
        // $i=0;
        // foreach($steam_trend as $trd){
        //     if($i<$len-1)
        //         echo "\"".$trd."\", ";
        //     else 
        //         echo "\"".$trd."\"<br>";
        //     $i++;
        // }

        // steam_metacritic
        foreach($html->find('div') as $div){
            if($div->id == 'game_area_metascore'){
                foreach($div->find('div') as $innerDiv){
                    $steam_metacritic = $innerDiv->innertext;
                    break;
                }
            }
        } 
       if(isset($steam_metacritic)){
            $toReturn["gameMetacritic"] = $steam_metacritic;
        }else{
            $toReturn["gameMetacritic"] = "";
        }
        
        // echo "<b>Game metacritic score: </b>".$steam_metacritic." <br>"; 

        // steam_image
        foreach($html->find('img') as $img){
            if($img->class == 'game_header_image_full'){
                $steam_image = $img->src;
            }
        }
        if(isset($steam_image)){
            $toReturn["gameImage"] = $steam_image;
        }else{
            $toReturn["gameImage"] = "";
        }
        
        // echo "<b>Game image: </b>".$steam_image." <br>"; 
    }else{
        $toReturn["appId"] = "";
        $toReturn["gameName"] = "";
        $toReturn["gameDescription"] = "";
        $toReturn["gameGenere"] = "";
        $toReturn["gameDeveloper"] = "";
        $toReturn["gamePublisher"] = "";
        $toReturn["gameScreenshot"] = "";
        $toReturn["gameRelease"] = "";
        $toReturn["gameTrend"] = "";
        $toReturn["gameMetacritic"] = "";
        $toReturn["gameImage"] = "";
    }
?>