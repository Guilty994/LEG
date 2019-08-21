<?php
    class Game{
        public function __construct($name, $icon) {
            $this->name = $name;
            $this->icon = $icon;
        }
    }

    $curl = curl_init("https://store.steampowered.com/search/?term=".$game."&category1=998");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($curl);
    if(curl_errno($curl)){
        header("wrapper_steam, Scraper error: " . curl_error($curl), true, 500);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);
    
    $toReturn['search']['tags'][999] = 'NAME';

    //0 to 24max
    $index = 0;
    foreach($html->find('span') as $span){
        if($span->class == 'title'){
            // $toReturn['search']['result'][$index] = $span->innertext;
            // $index++;
            foreach($span->parent()->parent()->parent()->find('img') as $img){
                $img_src = $img->src;
            }
            $gameToAdd = new Game($span->innertext, $img_src);
            $toReturn['search']['result'][$index] = $gameToAdd;
            $index++;
        }
    }
?>