<?php
   include "simple_html_dom.php";
   //$game = "Sekiro_Shadows_Die_Twice";
   //$game = "SeKirO_SCiadow_Die_TRICE";
   $game = "Sekiro";
    
    if(isset($_GET["scraping_targ"])){

        if($_GET["scraping_targ"]=="steam_charts")
            $_GET["scraping_targ"] = "steam";

        switch($scraping_targ = $_GET["scraping_targ"]){
            //script test
            case "test_script":

                $curl = curl_init('http://testing-ground.scraping.pro/textlist');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); 
                $page = curl_exec($curl);
                if(curl_errno($curl)){
                    echo 'Scraper error: ' . curl_error($curl);
                    exit;
                }
                curl_close($curl);
                $regex = '/<div id="case_textlist">(.*?)<\/div>/s';
                if ( preg_match($regex, $page, $list) )
                    echo $list[0];
                else 
                print "Not found"; 
            break;

            //steam
            case "steam":
                echo "Source Steam... <br>";

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

                    //steam charts
                    echo "Source Steamcharts... <br>";
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
                            echo "Avg players last 30 days: ".$td->innertext."<br>"; //avg players last 30 days
                        }
                        if($td->class == 'right num italic'){
                            echo "Peak players: ".$td->innertext."<br>"; //peak players
                        }
                    }  
                }else{
                    echo "No result found!";
                }
                
                
            break;

            //twitch
            case "twitch":
            
            break;

            //youtube
            case "youtube":
            
            break;
            default:
                echo "TODO";
        }
    }else{
        echo "Error in the GET request.";
    }
?> 