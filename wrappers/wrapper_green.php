<?php

//////TODO check game name
//TODO TEST
    $curl = curl_init("https://www.greenmangaming.com/games/".$game."-pc/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);
    if(curl_errno($curl)){
        echo 'Scraper error: ' . curl_error($curl);
        exit;
    }
    curl_close($curl);

    $html = new simple_html_dom();
    $html -> load($response);

    foreach($html->find('price') as $div){
			if($price->class == "current-price pdp-price notranslate"){
				$bestprice = $price->find('span')->innertext;
			}
			break;
		}	        
    }
	
?>




//https://www.kinguin.net/it/catalogsearch/result/index/?p=1&q=assassin+s+creed+III&order=min_price&dir_metacritic=desc&content_type%5B%5D=1&hide_outstock=1