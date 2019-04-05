<?php
   include "simple_html_dom.php";
   //$game = "Sekiro_Shadows_Die_Twice";
   //$game = "SeKirO_SCiadow_Die_TRICE";
   $game = "Sekiro";
    
    if(isset($_GET["scraping_targ"])){

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
                            echo "Game name ".$div->innertext;
                        }
                    }
                }else{
                    echo "No result found!";
                }
                
                
            break;

            //steamcharts
            case "steam_charts":
            
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